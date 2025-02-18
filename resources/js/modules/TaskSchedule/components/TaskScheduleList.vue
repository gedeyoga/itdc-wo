<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Task Schedule </h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Task Schedule 
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Task Schedule </h5>
                <el-button
                    v-if="hasAccess('task-schedule.task-schedule-list')"
                    type="primary"
                    icon="el-icon-plus"
                    @click="() => {
                        $refs['dialogTaskScheduleForm'].resetForm()
                        $refs['dialogTaskScheduleForm'].openDialog()
                    }"
                    >Create Task Schedule </el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-3">
                        <span class="filter-text">
                            <small>Filter Priority</small>
                        </span>
                        <el-select
                            clearable
                            v-model="filter.priority_id"
                            placeholder="Choose Priority"
                        >
                            <el-option
                                v-for="priority in priorities"
                                :key="priority.id"
                                :label="priority.name"
                                :value="priority.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3">
                        <span class="filter-text">
                            <small>Filter Category</small>
                        </span>
                        <el-select
                            clearable
                            v-model="filter.task_category_id"
                            placeholder="Choose Category"
                        >
                            <el-option
                                v-for="category in task_categories"
                                :key="category.id"
                                :label="category.name"
                                :value="category.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col">
                        <div
                            class="btn-group w-100"
                        >
                            <el-input
                                prefix-icon="el-icon-search"
                                @keyup.enter.native="fetchData"
                                v-model="filter.search"
                                :placeholder="'Cari..'"
                            >
                                <template slot="append">
                                    <el-button @click="fetchData">
                                        <span class="el-icon-search"></span>
                                    </el-button>
                                </template>
                            </el-input>
                        </div>
                    </div>
                </div>

                <div class="border-bottom"></div>

                <el-table
                    :data="data"
                    stripe
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                >
                    <el-table-column label="No" width="50">
                        <template slot-scope="scope">
                            {{ meta.per_page * (meta.current_page - 1) + scope.$index + 1 }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Task Schedule ">
                        <template slot-scope="scope">
                            <span>{{ scope.row.task.name }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="type" label="Type">
                        <template slot-scope="scope">
                            <span style="text-transform: capitalize;">{{ scope.row.type }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="priority_id" label="Priority">
                        <template slot-scope="scope">
                            <priority-component :status="scope.row.task.priority.name.toLowerCase()"></priority-component>
                        </template>
                    </el-table-column>
                    <el-table-column prop="priority_id" label="Status">
                        <template slot-scope="scope">
                            <span class="badge bg-label-success" v-if="scope.row.status == 'active'">Active</span>
                            <span class="badge bg-label-danger" v-if="scope.row.status == 'not-active'">Not Active</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('task-schedule.task-schedule-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="() => {
                                        $refs['dialogTaskScheduleForm'].setForm(scope.row)
                                        $refs['dialogTaskScheduleForm'].openDialog()
                                    }"
                                ></el-button>
                                <el-button
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    v-if="hasAccess('task-schedule.task-schedule-delete')"
                                    @click="onDelete(scope.row)"
                                ></el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <div
                    class="pagination-wrap"
                    style="text-align: center; padding-top: 20px"
                >
                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page.sync="meta.current_page"
                        :page-sizes="[10, 20, 50, 100]"
                        :page-size="parseInt(meta.per_page)"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="meta.total"
                    ></el-pagination>
                </div>
            </div>
        </div>

        <dialog-task-schedule-form
            ref="dialogTaskScheduleForm"
            @handleSuccessSubmit="fetchData"
        ></dialog-task-schedule-form>
    </div>
</template>

<script>
import _ from "lodash";
import { mapState } from "vuex";
import DialogTaskScheduleForm from './DialogTaskScheduleForm.vue';
import PriorityComponent from '../../Workorder/components/PriorityComponent.vue';

export default {
    components:{
        DialogTaskScheduleForm,
        PriorityComponent
    },
    data() {
        return {
            data: [],
            tableIsLoading: false,
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            list_roles: [],
            filter: {
                // priority_id: "",
                // task_category_id: "",
                search: "",
            },
        };
    },

    watch: {
        'filter.priority_id' : function(value) {
            this.fetchData();
        },
        'filter.task_category_id' : function(value) {
            this.fetchData();
        }
    },

    computed: {
        ...mapState({
            priorities: (state) => state.Priority.priorities,
            task_categories: (state) => state.TaskCategory.task_categories,
        })
    },
    methods: {
        queryServer(customProperties) {
            const cancelSource = axios.CancelToken.source();
            const properties = {
                params: {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    search: this.searchQuery,
                    relations: "task,days,months,years,task.priority,users",
                    ...this.filter
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.task-schedules.list"), properties).then((response) => {
                if (typeof response !== "undefined") {
                    this.tableIsLoading = false;
                    this.data = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.order_meta.order_by = properties.order_by;
                    this.order_meta.order = properties.order;
                }
            });
        },
        fetchData() {
            this.tableIsLoading = true;
            if (this.request) this.cancel();
            this.queryServer();
        },
        handleSizeChange(event) {
            console.log(`per page :${event}`);
            this.tableIsLoading = true;
            this.meta.per_page = event;
            this.queryServer();
        },
        handleCurrentChange(event) {
            console.log(`current page :${event}`);
            this.tableIsLoading = true;
            this.meta.current_page = event;
            this.queryServer();
        },
        handleSortChange(event) {
            console.log("sorting", event);
            this.tableIsLoading = true;
            this.queryServer({
                order_by: event.prop,
                order: event.order,
            });
        },
        performSearch: _.debounce(function (query) {
            console.log(`searching:${query.target.value}`);
            this.tableIsLoading = true;
            this.queryServer({
                search: query.target.value,
            });
        }, 300),
        cancel() {
            this.request.cancel();
        },

        onDelete(row) {
            this.$confirm("Are you sure want to delete?", "Confirmation", {
                confirmButtonText: "Save",
                cancelButtonText: "Cancel",
                type: "warning",
            }).then((result) => {
                axios
                    .delete(
                        route("api.task-schedules.destroy", {
                            task_schedule: row.id,
                        })
                    )
                    .then((response) => {
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });

                        this.fetchData();
                    });
            })
        },
    },

    mounted() {
        this.$nextTick().then(() => {
            Promise.all([
                this.$store.dispatch('fetchLocations'),
                this.$store.dispatch('fetchPriorities'),
                this.$store.dispatch('fetchTaskCategories'),
                this.$store.dispatch('fetchTasks',{
                    relations: 'priority,task_items',
                }),
            ])
        })

        this.fetchData();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>