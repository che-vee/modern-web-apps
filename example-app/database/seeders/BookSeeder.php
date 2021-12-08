<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            ["book" => "Ulysses", "author" => 1, "pages" => 500],
            ["book" => "The Great Gatsby", "author" => 2, "pages" => 262],
            ["book" => "War and Peace", "author" => 2, "pages" => 789],
            ["book" => "Elizabeth Bennet", "author" => 5, "pages" => 374],
            ["book" => "Catch-22", "author" => 7, "pages" => 647],
            ["book" => "The Tragedy of Hamlet", "author" => 4, "pages" => 353],
            ["book" => "The Catcher in the Rye ", "author" => 3, "pages" => 987],
            ["book" => "Anna Karenina", "author" => 6, "pages" => 957],
            ["book" => "The Iliad", "author" => 6, "pages" => 2337],
        ];

        DB::table("books")->insert($books);

    }
}
