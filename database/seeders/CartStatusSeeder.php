<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CartStatus;

class CartStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create(1, 1, 'new', "Новый");
        $this->create(2, 3, 'added', "Выгружен успешно");
        $this->create(3, 4, 'not-added', "Не выгружен");
        $this->create(4, 4, 'less-qty', "Количество меньше минимального");
        $this->create(5, 4, 'diff-qty', "Количество отличается от загруженного");
        $this->create(6, 5, 'changed', 'Изменен после выгрузки в корзине');
    }

    private function create(int $id, int $status_id, string $slug, string $name): void
    {
        CartStatus::firstOrCreate(compact('id', 'status_id', 'slug', 'name'));
    }
}
