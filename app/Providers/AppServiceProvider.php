<?php

namespace App\Providers;

use App\Models\Location;
use App\Models\Pompa;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSchedule;
use App\Models\TaskScheduleDay;
use App\Models\TaskScheduleMonth;
use App\Models\TaskScheduleYear;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignee;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderLog;
use App\Repositories\Eloquent\EloquentLocationRepository;
use App\Repositories\Eloquent\EloquentPompaRepository;
use App\Repositories\Eloquent\EloquentPriorityRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentTaskCategoryRepository;
use App\Repositories\Eloquent\EloquentTaskRepository;
use App\Repositories\Eloquent\EloquentTaskScheduleDayRepository;
use App\Repositories\Eloquent\EloquentTaskScheduleMonthRepository;
use App\Repositories\Eloquent\EloquentTaskScheduleRepository;
use App\Repositories\Eloquent\EloquentTaskScheduleYearRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentWorkOrderAssigneeRepository;
use App\Repositories\Eloquent\EloquentWorkOrderItemRepository;
use App\Repositories\Eloquent\EloquentWorkOrderLogRepository;
use App\Repositories\Eloquent\EloquentWorkOrderRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PompaRepository;
use App\Repositories\PriorityRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TaskCategoryRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskScheduleDayRepository;
use App\Repositories\TaskScheduleMonthRepository;
use App\Repositories\TaskScheduleRepository;
use App\Repositories\TaskScheduleYearRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderLogRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function () {

            $repository = new EloquentUserRepository(new User());

            return $repository;
        });

        $this->app->bind(RoleRepository::class, function () {

            $repository = new EloquentRoleRepository(new Role());

            return $repository;
        });

        $this->app->bind(TaskRepository::class, function () {

            $repository = new EloquentTaskRepository(new Task());

            return $repository;
        });

        $this->app->bind(TaskCategoryRepository::class, function () {

            $repository = new EloquentTaskCategoryRepository(new TaskCategory());

            return $repository;
        });

        $this->app->bind(PriorityRepository::class, function () {

            $repository = new EloquentPriorityRepository(new Priority());

            return $repository;
        });

        $this->app->bind(WorkOrderRepository::class, function () {

            $repository = new EloquentWorkOrderRepository(new WorkOrder());

            return $repository;
        });

        $this->app->bind(WorkOrderItemRepository::class, function () {

            $repository = new EloquentWorkOrderItemRepository(new WorkOrderItem());

            return $repository;
        });

        $this->app->bind(WorkOrderAssigneeRepository::class, function () {

            $repository = new EloquentWorkOrderAssigneeRepository(new WorkOrderAssignee());

            return $repository;
        });

        $this->app->bind(LocationRepository::class, function () {

            $repository = new EloquentLocationRepository(new Location());

            return $repository;
        });

        $this->app->bind(WorkOrderLogRepository::class, function () {

            $repository = new EloquentWorkOrderLogRepository(new WorkOrderLog());

            return $repository;
        });

        $this->app->bind(TaskScheduleRepository::class, function () {

            $repository = new EloquentTaskScheduleRepository(new TaskSchedule());

            return $repository;
        });

        $this->app->bind(TaskScheduleDayRepository::class, function () {

            $repository = new EloquentTaskScheduleDayRepository(new TaskScheduleDay());

            return $repository;
        });

        $this->app->bind(TaskScheduleMonthRepository::class, function () {

            $repository = new EloquentTaskScheduleMonthRepository(new TaskScheduleMonth());

            return $repository;
        });

        $this->app->bind(TaskScheduleYearRepository::class, function () {

            $repository = new EloquentTaskScheduleYearRepository(new TaskScheduleYear());

            return $repository;
        });

        $this->app->bind(PompaRepository::class, function () {

            $repository = new EloquentPompaRepository(new Pompa());

            return $repository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('NGROK') == true) {
            URL::forceScheme('https');
        }
    }
}
