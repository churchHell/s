<?php

namespace Tests\Feature;

use App\Http\Livewire\Delete;
use App\Http\Livewire\Edit;
use App\Http\Livewire\Order\Create;
use App\Http\Livewire\Order\Show;
use App\Models\Group;
use App\Models\Order;
use App\Models\Pivots\OrderUser;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\DeliveryRepositoryContract;
use App\Repositories\Contracts\ItemRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;
use Tests\Traits\WithMockery;

class OrderTest extends TestCase
{
    
    use RefreshDatabase, WithMockery;

    public function test_user_can_see_orders_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $group = Group::factory()->create();
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_user_can_join_order()
    {
        $user = User::factory()->create(['active' => 0]);
        $anotherUser = User::factory()->create(['active' => 1]);
        $admin = User::factory()->create(['active' => 1, 'role_id' => Role::ADMIN]);
        $group = Group::factory()->create();
        $order = Order::factory()->create();
        $this->withMock(DeliveryRepositoryContract::class, 'getPrice', ['cost' => 1]);
        $this->withMock(ItemRepositoryContract::class, 'where', Order::first()->toArray());
        $qty = 5;

        // not active user can not join to order
        $response = $this->createQuery($user, $order);
        $response->assertStatus(403);

        // user can join to order
        $user->active = 1;
        $response = $this->createQuery($user, $order);
        $this->assertEquals(Order::count(), 1);
        $this->checkOrderUser($order, $qty);

        // user can not update another order
        $response = $this->updateQuery($anotherUser, $order);
        $response->assertStatus(403);
        $this->checkOrderUser($order, $qty);

        // user can update self order
        $response = $this->updateQuery($user, $order);
        $this->checkOrderUser($order, $qty = $qty + 1);

        // admin can update any order
        $response = $this->updateQuery($admin, $order);
        $this->checkOrderUser($order, $qty = $qty + 1);

        // user can not delete another order
        $response = $this->deleteQuery($anotherUser, $order);
        $response->assertStatus(403);
        $this->assertEquals(Order::count(), 1);
        $this->checkOrderUser($order, $qty);

        // user can delete self order
        $response = $this->deleteQuery($user, $order);
        $this->assertEquals(Order::count(), 0);
        $this->assertEquals(OrderUser::count(), 0);

        // admin can delete any order
        $order = Order::factory()->create();
        $response = $this->createQuery($user, $order);
        $this->assertEquals(Order::count(), 1);
        $response = $this->deleteQuery($admin, $order);
        $this->assertEquals(Order::count(), 0);
        $this->assertEquals(OrderUser::count(), 0);
    }

    public function test_user_can_update_item_info(): void
    {
        $user = User::factory()->create(['active' => 0]);
        $group = Group::factory()->create();
        $order = Order::factory()->create();
        $orderUser = OrderUser::factory()->create();
        // $this->withMock(
        //     DeliveryRepositoryContract::class, 
        //     'getPrice', 
        //     ['cost' => $order->users->first()->pivot->delivery + 1]
        // );
        // $this->withMock(
        //     ItemRepositoryContract::class, 
        //     'where', 
        //     Order::factory()->make(['price' => 111])->toArray()
        // );

        // not active user can no update price
        $response = $this->updatePricesQuery($user, $order, 'updatePrice');
        $response->assertStatus(403);

        // not active user can no update delivery
        $response = $this->updatePricesQuery($user, $order, 'updateDelivery', $order->users->first()->pivot->id);
        $response->assertStatus(403);

        // $user->active = 1;
        // // user can update price
        // $response = $this->updatePricesQuery($user, $order, 'updatePrice');
        // $this->assertEquals(Order::findOrFail($order->id)->price, $order->price + 1);

        // // user can update delivery
        // $response = $this->updatePricesQuery($user, $order, 'updateDelivery', $order->users->first()->pivot->id);
        // $this->assertEquals(
        //     Order::findOrFail($order->id)->users->first()->pivot->delivery, 
        //     $order->users->first()->pivot->delivery + 1
        // );
    }

    private function createQuery(User $user, Order $order): TestableLivewire
    {
        $this->actingAs($user);
        $response = Livewire::test(Create::class, compact('order'))
            ->set('qty', 5)
            ->call('store');
        return $response;
    }

    private function updateQuery(User $user, Order $order): TestableLivewire
    {
        $this->actingAs($user);
        $pivot = $order->users->first()->pivot;
        return Livewire::test(Edit::class, [
            'class' => OrderUser::class,
            'row' => $pivot->id,
            'fields' => ['qty' => $pivot->qty],
            'rules' => ['qty' => 'required']
        ])
            ->set('fields.qty', $pivot->qty + 1)
            ->call('update');
    }

    private function deleteQuery(User $user, Order $order): TestableLivewire
    {
        $this->actingAs($user);
        $pivot = $order->users->first()->pivot;
        return Livewire::test(Delete::class, [
            'class' => OrderUser::class,
            'row' => $pivot->id,
        ])->call('confirmYes');
    }

    private function updatePricesQuery(User $user, Order $order, string $call, ?string $param = null): TestableLivewire
    {
        $this->actingAs($user);
        $response = Livewire::test(Show::class, compact('order'))
            ->call($call, $param);
        return $response;
    }

    private function checkOrderUser(Order $order, int $qty): void
    {
        $order->load('users');
        $this->assertEquals($order->users->count(), 1);
        $this->assertEquals($order->users->first()->pivot->qty, $qty);
    }

    public function order_actions(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        // Store not active user
        $response = $this->storeQuery($this->createUser(1, 0));
        $this->assertEquals(Order::count(), 0);
        $this->assertEquals(OrderUser::count(), 0);
        $response->assertStatus(403);

        // Store order
        $response = $this->storeQuery($this->user);
        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(($order = Order::first())->users->first()->id, $this->user->id);
        $this->assertEquals($order->users->count(), 1);
        $this->assertEquals($order->users->first()->pivot->qty, 1);

        // Update self order
        $response = $this->updateQuery($order, 2, $this->user);
        $this->assertEquals(Order::first()->userPivot($this->user)->qty, 2);

        // Join order
        $response = $this->joinQuery($order);
        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(($order = Order::first())->users->last()->id, $this->anotherUser->id);
        $this->assertEquals($order->users->count(), 2);
        $this->assertEquals($order->users->last()->pivot->qty, 5);

        // Update another order
        $response = $this->updateQuery($order, 6, $this->user, $this->anotherUser);
        $this->assertEquals(Order::first()->userPivot($this->anotherUser)->qty, 5);
        $response->assertStatus(403);

        // Update admin order
        $response = $this->updateQuery($order, 1, $this->admin, $this->user);
        $this->assertEquals(Order::first()->userPivot($this->user)->qty, 1);

        // Destroy another order
        $response = $this->destroyQuery($order, $this->user, $this->anotherUser);
        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(OrderUser::count(), 2);
        $response->assertStatus(403);

        // Destroy admin order
        $response = $this->destroyQuery($order, $this->admin, $this->anotherUser);
        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(OrderUser::count(), 1);

        // Destroy self single order
        $response = $this->destroyQuery($order, $this->user);
        $this->assertEquals(Order::count(), 0);
        $this->assertEquals(OrderUser::count(), 0);
    }


}
