<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::query()->count() > 0
            ? Author::query()->get()
            : Author::factory(20)->create();

        Book::factory(50)->create()->each(function (Book $book) use ($authors): void {
            $maxAuthors = min(3, $authors->count());
            $pickCount = $maxAuthors > 0 ? rand(1, $maxAuthors) : 0;

            if ($pickCount === 0) {
                return;
            }

            $picked = collect($authors->random($pickCount));
            $book->authors()->sync($picked->pluck('id')->all());
        });
    }
}
