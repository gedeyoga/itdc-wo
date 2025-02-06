<?php

namespace App\Providers;

use App\Models\AssetMaster;
use App\Models\AssetMasterParameter;
use App\Models\AssetMasterParameterUsage;
use App\Models\HistoryPompa;
use App\Models\Location;
use App\Models\LocationInstallation;
use App\Models\Pompa;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSchedule;
use App\Models\TaskScheduleDay;
use App\Models\TaskScheduleMonth;
use App\Models\TaskScheduleYear;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignee;
use App\Models\WorkOrderAttachment;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderLog;
use App\Repositories\AssetMasterParameterRepository;
use App\Repositories\AssetMasterParameterUsageRepository;
use App\Repositories\AssetMasterRepository;
use App\Repositories\Eloquent\EloquentAssetMasterParameterRepository;
use App\Repositories\Eloquent\EloquentAssetMasterParameterUsageRepository;
use App\Repositories\Eloquent\EloquentAssetMasterRepository;
use App\Repositories\Eloquent\EloquentHistoryPompaRepository;
use App\Repositories\Eloquent\EloquentLocationInstallationRepository;
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
use App\Repositories\Eloquent\EloquentTenantRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentWorkOrderAssigneeRepository;
use App\Repositories\Eloquent\EloquentWorkOrderAttachmentRepository;
use App\Repositories\Eloquent\EloquentWorkOrderItemRepository;
use App\Repositories\Eloquent\EloquentWorkOrderLogRepository;
use App\Repositories\Eloquent\EloquentWorkOrderRepository;
use App\Repositories\HistoryPompaRepository;
use App\Repositories\LocationInstallationRepository;
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
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderAttachmentRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderLogRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        $this->app->bind(LocationInstallationRepository::class, function () {

            $repository = new EloquentLocationInstallationRepository(new LocationInstallation());

            return $repository;
        });

        $this->app->bind(TenantRepository::class, function () {

            $repository = new EloquentTenantRepository(new Tenant());

            return $repository;
        });
        $this->app->bind(HistoryPompaRepository::class, function () {

            $repository = new EloquentHistoryPompaRepository(new HistoryPompa());

            return $repository;
        });
        $this->app->bind(WorkOrderAttachmentRepository::class, function () {

            $repository = new EloquentWorkOrderAttachmentRepository(new WorkOrderAttachment());

            return $repository;
        });
        $this->app->bind(AssetMasterRepository::class, function () {

            $repository = new EloquentAssetMasterRepository(new AssetMaster());

            return $repository;
        });

        $this->app->bind(AssetMasterParameterRepository::class, function () {

            $repository = new EloquentAssetMasterParameterRepository(new AssetMasterParameter());

            return $repository;
        });

        $this->app->bind(AssetMasterParameterUsageRepository::class, function () {

            $repository = new EloquentAssetMasterParameterUsageRepository(new AssetMasterParameterUsage());

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
