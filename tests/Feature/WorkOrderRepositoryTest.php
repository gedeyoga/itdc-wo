<?php

namespace Tests\Feature;

use App\Events\WorkOrderFinished;
use App\Events\WorkOrderProgress;
use App\Models\Priority;
use App\Models\TaskCategory;
use App\Models\User;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorkOrderRepositoryTest extends TestCase
{

    protected function setUp() : void {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_workorder()
    {
        $workorder_repo = app(WorkOrderRepository::class);
        $work_order = WorkOrder::factory()->pending()->make([
            'task_category_id' => TaskCategory::factory()->create()->id,
            'priority_id' => Priority::factory()->create()->id,
        ])->toArray();
        $work_order_items = [
            [
                'name' => 'Task Satu', 
                'has_media' => '0',
            ],
            [
                'name' => 'Task Dua', 
                'has_media' => '0',
            ],
        ];

        $rs = $workorder_repo->createWorkOrder($work_order, $work_order_items);

        $this->assertEquals($work_order['name'] , $rs->name);
        $this->assertEquals($work_order['status'] , $rs->status);
        $this->assertCount(count($work_order_items) , $rs->work_order_items);
    }

    public function test_update_workOrder() 
    {
        $this->test_create_workorder();

        $workorder_repo = app(WorkOrderRepository::class);

        $work_order = WorkOrder::first();
        $work_order_items = $work_order->work_order_items->toArray();

        $data = $work_order->toArray();
        $data['name'] = 'Ini Work Order';

        array_push($work_order_items, [
            'name' => 'Task Tiga',
            'has_media' => '0',
        ]);

        $rs = $workorder_repo->updateWorkOrder($work_order, $data, $work_order_items);

        $this->assertEquals($work_order['name'] , $rs->name);
        $this->assertCount(count($work_order_items) , WorkOrder::first()->work_order_items);

    }

    public function test_work_order_progress()
    {
        $this->test_update_workOrder();

        $workorder_repo = app(WorkOrderRepository::class);

        $work_order = WorkOrder::first();

        Event::fake();
        $rs = $workorder_repo->statusChanged($work_order, 'progress');

        Event::assertDispatched(WorkOrderProgress::class, function($event) use ($rs) {
            return $event->work_order->id == $rs->id;
        });

        $this->assertEquals('progress' , $rs->status);

    }

    public function test_update_wo_with_file_and_status_changed()
    {
        $this->test_work_order_progress();

        Storage::fake('local');
        $workorder_repo = app(WorkOrderRepository::class);
        $work_order = WorkOrder::first();

        $work_order = WorkOrder::first();
        $work_order_items = $work_order
                                ->work_order_items
                                ->map(function($item) {
                                    $item->media = UploadedFile::fake()->create('document.png');
                                    $item->has_media = 1;
                                    $item->status = 'finish';
                                    return $item;
                                })
                                ->toArray();

        $data = $work_order->toArray();

        Event::fake();
        $rs = $workorder_repo->updateWorkOrder($work_order, $data, $work_order_items);
        $rs = $workorder_repo->statusChanged($rs, 'finish');

        Event::assertDispatched(WorkOrderFinished::class , function($event) use ($rs) {
            return $event->work_order->id == $rs->id;
        });

        $this->assertEquals('finish' , $rs->status);
        $this->assertEquals(3, $rs->work_order_items()->has('media')->count());
    }
}
