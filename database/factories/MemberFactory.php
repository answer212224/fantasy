<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fb' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'ip' => $this->faker->ipv4(),
        ];
    }
}
