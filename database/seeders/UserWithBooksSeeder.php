<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Writer;
use \App\Models\Book;
use \App\Models\Genre;

use Hash;

class UserWithBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed genres
        Genre::factory()->count(10)->create();

        // Create a single user with 5 writers associated to it
        $user = User::factory()
            ->hasWriters(5)
            ->create();
        
        // Add books
        Book::factory()->count(200)->create();

        // Overwrite name, email and password for test
        $user->name = 'Pim';
        $user->is_onboarded = 1;
        $user->email = 'pim@plint-sites.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}
