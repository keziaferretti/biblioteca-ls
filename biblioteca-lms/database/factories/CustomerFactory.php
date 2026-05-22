<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'document'   => $this->faker->unique()->numerify('###########'),
            'phone'      => $this->faker->phoneNumber(),
            'address'    => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'birth_date' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
