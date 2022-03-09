<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Writer;
use \App\Models\Book;
use \App\Models\Genre;

use Hash;

class HardcodedWriters extends Seeder
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

        // Update names of writers for sorting...
        Writer::find(1)->update(['name' => 'Gert Zalm']);
        sleep(1);
        Writer::find(2)->update(['name' => 'Hans Jorren']);
        sleep(2);
        Writer::find(3)->update(['name' => 'Albert Keessen']);
        sleep(1);
        Writer::find(4)->update(['name' => 'Zieder Adders']);
        sleep(2);
        Writer::find(5)->update(['name' => 'Barry Konink']);
        
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
