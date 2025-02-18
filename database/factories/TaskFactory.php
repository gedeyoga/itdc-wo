<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(), 
            'description' => $this->faker->sentence(), 
            'task_category_id' => $this->faker->randomDigitNotZero(), 
            'priority_id' => $this->faker->randomDigitNotZero(),
            'location_id' => $this->faker->randomDigitNotZero(),
        ];
    }
}
