<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('data/books.json'));
        $books = json_decode($json, true);

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}