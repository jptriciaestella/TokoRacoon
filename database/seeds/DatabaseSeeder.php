<?php

use App\category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Beauty and Health', 'Technology', 'Hobby', 'Fashion'];

        foreach ($array as $category) {
            category::create([
                'category_name' => $category
            ]);
        }

        $this->call(UserSeeder::class);
    }
}
