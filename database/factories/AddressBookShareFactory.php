<?php

namespace Database\Factories;

use App\Models\AddressBookShare;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressBookShareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AddressBookShare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address_book_id' => 1,
            'user_id' => 1,
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
