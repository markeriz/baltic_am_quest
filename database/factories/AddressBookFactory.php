<?php

namespace Database\Factories;

use App\Models\AddressBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressBookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AddressBook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
