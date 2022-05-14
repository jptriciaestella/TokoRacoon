<?php

use App\category;
use Carbon\Carbon;
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
        
        $now = Carbon::now()->toDateTimeString();

        category::insert([
            ['category_name' => 'Beauty and Health', 'slug' => 'Beauty%20and%20Health', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Technology', 'slug' => 'Technology', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Hobby', 'slug' => 'Hobby', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Fashion', 'slug' => 'Fashion', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->call(UserSeeder::class);
    }
}
