<?php

namespace Tests\Feature;

use App\Models\AddressBook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_logged_in_users_can_see_address_books_list()
    {
        $this->get('/address_books')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_see_address_books_list()
    {
        $this->actingAsLoggedInUser();
        $this->get('/address_books')->assertOk();
    }

    public function test_address_book_can_be_added_through_the_form()
    {
        $this->actingAsLoggedInUser();
        $this->post('/address_books', $this->address_book_data());
        $this->assertCount(1, AddressBook::get());
    }

    public function test_a_first_name_is_required()
    {
        $this->actingAsLoggedInUser();

        $this->post('/address_books', array_merge($this->address_book_data(), ['first_name' => '']))
            ->assertSessionHasErrors(['first_name']);

        $this->assertCount(0, AddressBook::get());
    }

    public function test_a_telephone_is_required()
    {
        $this->actingAsLoggedInUser();

        $this->post('/address_books', array_merge($this->address_book_data(), ['telephone' => '']))
            ->assertSessionHasErrors(['telephone']);

        $this->assertCount(0, AddressBook::get());
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
