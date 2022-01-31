<?php

namespace Tests\Feature;

use App\Http\Livewire\Search\Index;
use App\Http\Livewire\Search\Show;
use App\Models\Group;
use App\Models\Order;
use App\Models\User;
use App\Repositories\DeliveryRepository;
use App\Repositories\ItemRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;
use Tests\Traits\WithMockery;

class SearchTest extends TestCase
{
    use RefreshDatabase, WithMockery;

    public function test_can_not_see_search_page_without_group(): void
    {
        $response = $this->get('/search');
        $response->assertStatus(404);
    }

    public function test_guest_can_not_see_search_page(): void
    {
        $group = Group::factory()->create();
        $response = $this->get('/search/'.$group->id);
        $response->assertRedirect('/login');
    }

    public function test_not_active_user_can_not_see_search_page(): void
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $response = $this->actingAs($user)->get('/search/'.$group->id);
        $response->assertStatus(401);
    }

    public function test_user_can_see_search_page(): void
    {
        $user = User::factory()->create(['active' => 1]);
        $group = Group::factory()->create();
        $response = $this->actingAs($user)->get('/search/'.$group->id);
        $response->assertOk();
    }

    public function test_user_can_find_item(): void
    {
        $user = User::factory()->create(['active' => 1]);
        $this->actingAs($user);
        $group = Group::factory()->create();

        $this->withMock(ItemRepository::class, 'where', Order::factory()->make()->toArray());

        $response = Livewire::test(Index::class, [
            'groupId' => $group->id,
        ])
            ->set('sid', 1)
            ->call('search')
            ->assertCount('items', 1)
            ->assertSeeLivewire('search.show');
        
        $response->assertOk();
    }

    public function test_user_can_store_item(): void
    {
        $response = $this->getShowTestInstance();
        
        $order = Order::factory()->make()->toArray();
        $this->withMock(ItemRepository::class, 'where', $order);
        $this->withMock(DeliveryRepository::class, 'getPrice', ['cost' => 1]);

        $response->set('qty', 1)
            ->call('store');

        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(Order::first()->users->first()->pivot->qty, 1);
        
        $response->assertOk();
    }

    public function test_user_can_destroy_item(): void
    {
        $response = $this->getShowTestInstance()
            ->call('remove')
            ->assertEmitted('searchDelete');
        
        $response->assertOk();
    }

    private function getShowTestInstance()
    {
        $user = User::factory()->create(['active' => 1]);
        $this->actingAs($user);
        $group = Group::factory()->create();

        $response = Livewire::test(Show::class, [
            'groupId' => $group->id,
            'item' => Order::factory()->make()->toArray(),
            'itemKey' => 1
        ]);
        return $response;
    }
}
