<?php

namespace Tests\Feature;

use App\Events\TaskCreated;
use App\Listeners\TaskCreatedListener;
use App\Models\Priority;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Repositories\TaskRepository;
use Database\Seeders\PrioritySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{

    protected function setUp() : void
    {
        parent::setUp();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_task()
    {
        $task_repo = app(TaskRepository::class);

        $data = Task::factory()->make([
            'priority_id' => Priority::factory()->create()->id,
            'task_category_id' => TaskCategory::factory()->create()->id,
        ])->toArray();

        $items = [
            [
                'name' => 'Task 1',
                'has_media' => '0'
            ],
            [
                'name' => 'Task 2',
                'has_media' => '1'
            ],
        ];

        Event::fake();
        $task = $task_repo->createTask($data, $items);

        Event::assertDispatched(TaskCreated::class, function($event) use ($task) {
            (new TaskCreatedListener())->handle($event);
            return $task->id = $event->task->id;
        });

        $this->assertCount(2, $task->task_items);
        $this->assertEquals($data['name'], $task->name);
        $this->assertCount(1, $task->getMedia('barcode'));

    }

    public function test_update_task()
    {
        $this->test_create_task();

        $task_repo = app(TaskRepository::class);


        $task_data = Task::first();

        $data = Task::factory()->make([
            'priority_id' => Priority::factory()->create()->id,
            'task_category_id' => TaskCategory::factory()->create()->id,
        ])->toArray();

        $items = [
            [
                'name' => 'Task 1',
                'has_media' => '0'
            ],
            [
                'name' => 'Task 2',
                'has_media' => '1'
            ],
            [
                'name' => 'Task 3',
                'has_media' => '1'
            ],
        ];

        $task = $task_repo->updateTask( $task_data, $data, $items);

        $this->assertCount(3, $task->task_items);
        $this->assertEquals($data['name'], $task->name);
    }
}
