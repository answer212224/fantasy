<?php

namespace Database\Factories;

use App\Models\GamePlayer;
use App\Models\History;
use App\Models\Player;
use App\Models\Selection;
use Illuminate\Database\Eloquent\Factories\Factory;

class SelectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Selection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'history_id' => History::factory(),
            'player_id' => Player::all()->random()->nba_player_id,
            // 'player_id' => GamePlayer::where('date_only', '2021-02-17')->get()->random()->player_id,
            'postion' => $this->faker->randomElement(['g', 'f', 'c']),
            'date_only' => function (array $attributes) {
                return History::find($attributes['history_id'])->date_only;
            },
            'order' => 1
        ];
    }
}
