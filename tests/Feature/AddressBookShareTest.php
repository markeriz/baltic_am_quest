<?php

namespace Tests\Feature;

use App\Models\AddressBook;
use App\Models\AddressBookShare;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressBookShareTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_only_owner_of_address_book_can_share_with_others()
    {
        $this->actingAsLoggedInUser();
        $this->post('/shares/'.
                        AddressBook::factory()->create([
                            'user_id' => User::factory()->create()->id
                        ])->id.
                    '/to/'.User::factory()->create()->id);

        $this->assertCount(0, AddressBookShare::get());
    }

    public function test_user_cant_share_address_book_with_self()
    {
        $this->actingAsLoggedInUser();
        $this->post('/shares/'.AddressBook::factory()->create()->id.'/to/'.auth()->user()->id);

        $this->assertCount(0, AddressBookShare::get());
    }

    private function actingAsLoggedInUser()
    {
        $this->actingAs(User::factory()->create());
    }

    private function address_book_data()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
