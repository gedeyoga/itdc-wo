<?php

namespace Tests\Feature;

use App\Models\Priority;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSchedule;
use App\Models\User;
use App\Repositories\TaskScheduleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskScheduleRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_task_schedule_day()
    {
        $task_repo = app(TaskScheduleRepository::class);

        $data = TaskSchedule::factory()->daily()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'day' => '2',
                'hour' => '08:00'
            ],
            [
                'day' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_repo->createSchedule($data, $items);

        $this->assertCount(2, $task_schedule->days);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }

    public function test_update_task_schedule_day()
    {
        $this->test_create_task_schedule_day();

        $task_schedule_repo = app(TaskScheduleRepository::class);


        $task_data = TaskSchedule::first();

        $data = TaskSchedule::factory()->daily()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'day' => '2',
                'hour' => '08:00'
            ],
            [
                'day' => '2',
                'hour' => '08:00'
            ],
            [
                'day' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_schedule_repo->updateSchedule($task_data, $data, $items);

        $this->assertCount(3, $task_schedule->days);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }

    public function test_create_task_schedule_month()
    {
        $task_repo = app(TaskScheduleRepository::class);

        $data = TaskSchedule::factory()->monthly()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'date' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_repo->createSchedule($data, $items);

        $this->assertCount(2, $task_schedule->months);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }

    public function test_update_task_schedule_month()
    {
        $this->test_create_task_schedule_month();

        $task_schedule_repo = app(TaskScheduleRepository::class);


        $task_data = TaskSchedule::first();

        $data = TaskSchedule::factory()->monthly()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'date' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_schedule_repo->updateSchedule($task_data, $data, $items);

        $this->assertCount(3, $task_schedule->months);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }

    public function test_create_task_schedule_year()
    {
        $task_repo = app(TaskScheduleRepository::class);

        $data = TaskSchedule::factory()->yearly()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'date' => '2',
                'month' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'month' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_repo->createSchedule($data, $items);

        $this->assertCount(2, $task_schedule->years);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }

    public function test_update_task_schedule()
    {
        $this->test_create_task_schedule_year();

        $task_schedule_repo = app(TaskScheduleRepository::class);


        $task_data = TaskSchedule::first();

        $data = TaskSchedule::factory()->yearly()->make([
            'task_id' => Task::factory()->create([
                'priority_id' => Priority::factory()->create()->id,
                'task_category_id' => TaskCategory::factory()->create()->id,
            ])->id,
        ])->toArray();

        $user = User::factory()->create();

        $this->actingAs($user);

        $items = [
            [
                'date' => '2',
                'month' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'month' => '2',
                'hour' => '08:00'
            ],
            [
                'date' => '2',
                'month' => '2',
                'hour' => '08:00'
            ],
        ];

        $task_schedule = $task_schedule_repo->updateSchedule($task_data, $data, $items);

        $this->assertCount(3, $task_schedule->years);
        $this->assertEquals($data['task_id'], $task_schedule->task_id);
    }
}
