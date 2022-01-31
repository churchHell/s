<?php

namespace Tests\Feature;

use App\Http\Livewire\Edit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_account_page():void
    {
        $response = $this->get('/account');
        $response->assertRedirect('/login');

        $user = User::factory()->create(['active' =>1 ]);
        $response = $this->actingAs($user)->get('/account');
        $response->assertStatus(200);
    }

    public function test_user_can_update_name():void
    {
        $user = User::factory()->create(['active' => 1]);
        $this->actingAs($user);
        $response = Livewire::test(Edit::class, [
            'class' => User::class,
            'row' => $user->id,
            'fields' => ['name' => $user->name],
            'rules' => ['name' => 'required']
        ])
            ->set('fields.name', $user->name.'a')
            ->call('update');
        $newUser = User::findOrFail($user->id);
        $this->assertEquals($user->name.'a', $newUser->name);
    }

    public function test_user_can_update_password():void
    {
        $user = User::factory()->create(['active' => 1]);
        $this->actingAs($user);
        $response = Livewire::test(Edit::class, [
            'class' => User::class,
            'row' => $user->id,
            'fields' => ['old_password' => '', 'password' => '', 'password_confirmation' => ''],
            'rules' => ['old_password' => 'required', 'password' => 'required', 'password_confirmation' => 'required']
        ])
            ->set('fields.old_password', 'password')
            ->set('fields.password', 'asasasas')
            ->set('fields.password_confirmation', 'asasasas')
            ->call('update');
        $newUser = User::findOrFail($user->id);
        $this->assertTrue(Hash::check('asasasas', $newUser->password));
    }
}
