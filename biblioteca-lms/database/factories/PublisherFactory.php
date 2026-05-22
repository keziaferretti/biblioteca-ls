<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    protected $model = Publisher::class;

    public function definition(): array
    {
        $companies = [
            'Penguin Random House', 'HarperCollins', 'Simon & Schuster',
            'Hachette Book Group', 'Macmillan Publishers', 'Scholastic Corporation',
            'Bloomsbury Publishing', 'Oxford University Press', 'Cambridge University Press',
            'Pearson Education', 'Wiley', 'Springer Nature', 'Elsevier',
            'McGraw-Hill Education', 'Houghton Mifflin Harcourt',
        ];

        $name = $this->faker->unique()->randomElement($companies);
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '', $name));

        return [
            'name'    => $name,
            'email'   => "contact@{$slug}.com",
            'phone'   => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress() . ', ' . $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'website' => "https://www.{$slug}.com",
        ];
    }
}
