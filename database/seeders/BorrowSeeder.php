<?php

namespace Database\Seeders;

use App\Models\Borrow;
use Illuminate\Database\Seeder;

class BorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Borrow::factory(50)->create();
    }
}
