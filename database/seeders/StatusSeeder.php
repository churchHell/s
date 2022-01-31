<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createStatus(1, 'new', 'Новый');
        $this->createStatus(2, 'archived', 'Архивный');
        $this->createStatus(3, 'success', 'Успех', 'check-circle');
        $this->createStatus(4, 'error', 'Ошибка', 'exclamation-circle');
        $this->createStatus(5, 'info', 'Информация', 'info-circle');
    }

    private function createStatus(int $id, string $slug, string $name, string $icon = null)
    {
        Status::firstOrCreate(compact('id', 'slug', 'name', 'icon'));
    }
}
