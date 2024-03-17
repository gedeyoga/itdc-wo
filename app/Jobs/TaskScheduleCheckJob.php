<?php

namespace App\Jobs;

use App\Models\TaskSchedule;
use App\Repositories\TaskScheduleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TaskScheduleCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $task_schedule_repo = app(TaskScheduleRepository::class);

        $lists = $task_schedule_repo->list([
            'status' => 'active'
        ]);

        foreach ($lists as $schedule) {
            if($schedule->type == 'daily' && $this->checkDaily($schedule)) {
                dispatch(new CreateWorkOrderJob($schedule));
            } else if ($schedule->type == 'monthly' && $this->checkMonthly($schedule)) {
                dispatch(new CreateWorkOrderJob($schedule));
            } else if ($schedule->type == 'yearly' && $this->checkYearly($schedule)) {
                dispatch(new CreateWorkOrderJob($schedule));
            }
        }
    }

    public function checkDaily(TaskSchedule $taskSchedule)
    {
        $days = $taskSchedule->days;
        $generate_wo = false;

        foreach ($days as $day) {
            
            if($day->day == date('N') && $day->hour == date('H:i:00')) {
                $generate_wo = true;
                break;
            }
        };

        return $generate_wo;
    }

    public function checkMonthly(TaskSchedule $taskSchedule)
    {
        $months = $taskSchedule->months;
        $generate_wo = false;
        foreach ($months as $month) {
            if ($month->date == date('j') && $month->hour == date('H:i:00')) {
                $generate_wo = true;
                break;
            }
        };

        return $generate_wo;
    }

    public function checkYearly(TaskSchedule $taskSchedule)
    {
        $years = $taskSchedule->years;
        $generate_wo = false;
        foreach ($years as $year) {
            if ( $year->month == date('n') && $year->date == date('j') && $year->hour == date('H:i:00')) {
                $generate_wo = true;
                break;
            }
        };

        return $generate_wo;
    }
}
