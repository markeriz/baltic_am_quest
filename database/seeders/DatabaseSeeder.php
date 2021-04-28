<?php

namespace Database\Seeders;

use App\Models\AddressBook;
use App\Models\User;
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
        $users = 10;

        User::factory($users)->create()->each(function ($user) {
            $user->withoutEvents(function () use ($user) {
                $user->address_books()->saveMany(AddressBook::factory(rand(0, 30)))->create(['user_id' => $user->id]);
            });
        });
    }
}
