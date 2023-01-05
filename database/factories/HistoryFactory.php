<?php

namespace Database\Factories;

use App\Models\History;
use App\Models\Member;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = History::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id' => Member::factory(),
            'date_only' => Schedule::all()->random()->date_only,
            // 'date_only' => '2021-02-17',
            'year' => '2021',
            'type' => 'playoff',
            'ip' => $this->faker->ipv4(),
        ];
    }
}
