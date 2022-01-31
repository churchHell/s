<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create('Евгений', 'Петросян', 'a@a.a', 3);
        $this->create('Елена', 'Степаненко', 'b@b.b', 1);
        $this->create('Геннадий', 'Ветров', 'c@c.c', 1);
        $this->create('Джэйсон', 'Стэтхэм', 'd@d.d', 1);
    }

    public function create(string $name, string $surname, string $email, int $role)
    {
        User::create([
            'name' => $name,
            'surname' => $surname,
            'phone' => '1234567890',
            'email' => $email,
            'email_verified_at' => now(),
//            'password' => '$2y$10$fP78If0NmtAb4IDO3JakHOYm4/aynzXujR03lJSpUEuxOmdnx9NzC', // asasasas
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role_id' => $role,
            'active' => 1
        ]);
    }
}
