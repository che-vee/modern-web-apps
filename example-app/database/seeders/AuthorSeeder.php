<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            ["name" => "Joseph Conrad"],
            ["name" => "Vladimir Nabokov"],
            ["name" => "F. Scott Fitzgerald"],
            ["name" => "Gabriel Garcia Marquez"],
            ["name" => "James Joyce"],
            ["name" => "Joseph Heller"],
            ["name" => "William Shakespeare"],
            ["name" => "Virginia Woolf"],
        ];

        DB::table("authors")->insert($authors);

    }
}
