<?php

namespace Database\Factories;

use App\Models\TaskSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskScheduleFactory extends Factory
{
    protected $model = TaskSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_id' => $this->faker->randomDigitNotZero(), 
            'description' => $this->faker->word(), 
            'status' => $this->faker->randomElement(['active' , 'not-active']), 
            'type' => $this->faker->randomElement(['daily' , 'monthly' , 'yearly']), 
        ];
    }

    public function daily()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'daily',
            ];
        });
    }

    public function monthly()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'monthly',
            ];
        });
    }

    public function yearly()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'yearly',
            ];
        });
    }


}
