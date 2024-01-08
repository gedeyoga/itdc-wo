<?php

namespace App\Repositories\Eloquent;

use App\Models\TaskSchedule;
use App\Repositories\TaskScheduleDayRepository;
use App\Repositories\TaskScheduleMonthRepository;
use App\Repositories\TaskScheduleRepository;
use App\Repositories\TaskScheduleYearRepository;

class EloquentTaskScheduleRepository extends EloquentBaseRepository implements TaskScheduleRepository
{
    public function list(array $params)
    {
        $datas = $this->model

            ->when(isset($params['relations']), function ($q) use ($params) {
                $relations = explode(',', $params['relations']);
                return $q->with($relations);
            })

            ->when(isset($params['type']), function ($q) use ($params) {
                return $q->where('type' , $params['type']);
            })

            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status' , $params['status']);
            })

            ->orderBy('created_at', 'desc');

        if (!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);
    }

    public function createSchedule(array $data , $times = [])
    {
        $schedule_day_repo = app(TaskScheduleDayRepository::class);
        $schedule_month_repo = app(TaskScheduleMonthRepository::class);
        $schedule_year_repo = app(TaskScheduleYearRepository::class);

        $task_schedule = $this->create($data);

        $time_schedules = array_map(function($item) use ($task_schedule) {
            $item['task_schedule_id'] = $task_schedule->id;
            return $item;
        } , $times);

        foreach ($time_schedules as $time_schedule) {
            if($task_schedule->type == 'daily') {
                $schedule_day_repo->create($time_schedule);
            } else if ($task_schedule->type == 'monthly') {
                $schedule_month_repo->create($time_schedule);
            } else if ($task_schedule->type == 'yearly') {
                $schedule_year_repo->create($time_schedule);
            }
        }

        if (isset($data['user_id'])) {
            $this->scheduleUser($task_schedule, $data['user_id']);
        }

        return $task_schedule;

    }

    public function updateSchedule(TaskSchedule $task_schedule, array $data , $times = [])
    {
        $schedule_day_repo = app(TaskScheduleDayRepository::class);
        $schedule_month_repo = app(TaskScheduleMonthRepository::class);
        $schedule_year_repo = app(TaskScheduleYearRepository::class);

        $task_schedule = $this->update( $task_schedule, $data);

        $time_schedules = array_map(function ($item) use ($task_schedule) {
            $item['task_schedule_id'] = $task_schedule->id;
            return $item;
        },
            $times
        );

        $task_schedule->days()->delete();
        $task_schedule->months()->delete();
        $task_schedule->years()->delete();

        foreach ($time_schedules as $time_schedule) {
            if ($task_schedule->type == 'daily') {
                $schedule_day_repo->create($time_schedule);
            } else if ($task_schedule->type == 'monthly') {
                $schedule_month_repo->create($time_schedule);
            } else if ($task_schedule->type == 'yearly') {
                $schedule_year_repo->create($time_schedule);
            }
        }

        if(isset($data['user_id'])) {
            $this->scheduleUser($task_schedule, $data['user_id']);
        }

        return $task_schedule;
    }

    public function scheduleUser(TaskSchedule $task_schedule, array $user_ids)
    {
        $task_schedule->users()->delete();
        return $task_schedule->users()->createMany($user_ids);
    }
    
}
