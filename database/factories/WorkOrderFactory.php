<?php

namespace Database\Factories;

use App\Models\TaskCategory;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkOrderFactory extends Factory
{
    protected $model = WorkOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => null, 
            'name' => $this->faker->word(), 
            'description' => $this->faker->word(), 
            'task_category_id' => $this->faker->randomDigitNotNull(), 
            'priority_id' => $this->faker->randomDigitNotNull(), 
            'status' => 'pending', 
            'date' => date('Y-m-d H:i:s'), 
            'location_id' => $this->faker->randomDigitNotNull(), 
            'start_at' => null, 
            'start_by' => null, 
            'finish_at' => null, 
            'finish_by' => null, 
        ];
    }

    public function pending() {
        return $this->state(function(array $attributes) {
            return [
                'status' => 'pending',
                'date' => date('Y-m-d H:i:s'),
                'start_at' => null,
                'start_by' => null,
                'finish_at' => null,
                'finish_by' => null,
            ];
        });
    }

    public function progress() {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'progress',
                'start_at' => date('Y-m-d H:i:s'),
                'start_by' => $this->faker->randomDigitNotNull(),
                'finish_at' => null,
                'finish_by' => null,
            ];
        });
    }

    public function finish() {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'finish',
                'finish_at' => date('Y-m-d H:i:s'),
                'finish_by' => $this->faker->randomDigitNotNull(),
            ];
        });
    }
}
