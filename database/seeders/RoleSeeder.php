<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addRole(1, 'user', 'Пользователь', 'user', 'color-default');
        $this->addRole(2, 'admin', 'Администратор', 'user-tie', 'color-success');
        $this->addRole(3, 'super', 'Супер', 'user-graduate', 'color-accent');
    }

    private function addRole(int $id, string $slug, string $name, string $icon, string $color): void
    {
        Role::firstOrCreate(compact('id', 'slug', 'name', 'icon', 'color'));
    }
}
