<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create(); //create() means start to generate 10 rows data for User model and store in DB.

         \App\Models\User::factory()->create([ //allows us to pass an array to overwrite some of the column with this specific data
             'name' => 'Test User',
             'email' => 'test@example.com',
             'is_admin'=> true
         ]);
        \App\Models\User::factory()->create([ //allows us to pass an array to overwrite some of the column with this specific data
            'name' => 'Test User2',
            'email' => 'test2@example.com',
        ]);
        \App\Models\Listing::factory(10)->create([
            'by_user_id' => 1
        ]);
        \App\Models\Listing::factory(10)->create([
            'by_user_id' => 2
        ]);
        //here will generate 20 rows fake data
        //why can use factory on listing model (Models/Listing.php) because where got "use HasFactory;"
        //that can let laravel know this factory it belong to Listing model
    }
}
