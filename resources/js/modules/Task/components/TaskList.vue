<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Task</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Task
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Task</h5>
                <el-button
                    v-if="hasAccess('task.task-list')"
                    type="primary"
                    icon="el-icon-plus"
                    @click="() => {
                        $refs['dialogTaskForm'].resetForm()
                        $refs['dialogTaskForm'].openDialog()
                    }"
                    >Create Task</el-button
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
                    <el-table-column prop="name" width="80" label="QR Code">
                        <template slot-scope="scope">
                             <el-image
                                style="width: 70px; height: 70px"
                                :src="scope.row.barcode ? scope.row.barcode.original_url : '#'"
                                :preview-src-list="scope.row.barcode ? [scope.row.barcode.original_url] : [] "
                                fit="fill">
                            </el-image>
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Task">
                    </el-table-column>
                    <el-table-column prop="priority_id" label="Priority">
                        <template slot-scope="scope">
                            <priority-component :status="scope.row.priority.name.toLowerCase()"></priority-component>
                        </template>
                    </el-table-column>
                    <el-table-column prop="task_category_id" label="Kategori">
                        <template slot-scope="scope">
                            {{ scope.row.task_category.name }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('task.task-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="() => {
                                        $refs['dialogTaskForm'].setForm(scope.row)
                                        $refs['dialogTaskForm'].openDialog()
                                    }"
                                ></el-button>
                                <el-button
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    v-if="hasAccess('task.task-delete')"
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

        <dialog-task-form
            ref="dialogTaskForm"
            @handleSuccessSubmit="fetchData"
        ></dialog-task-form>
    </div>
</template>

<script>
import _ from "lodash";
import { mapState } from "vuex";
import DialogTaskForm from './DialogTaskForm.vue';
import PriorityComponent from '../../Workorder/components/PriorityComponent.vue';

export default {
    components:{
        DialogTaskForm,
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
                priority_id: "",
                task_category_id: "",
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
                    relations: "priority,task_category,task_items,task_attachments",
                    ...this.filter
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.task.list"), properties).then((response) => {
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
                        route("api.task.destroy", {
                            task: row.id,
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
                this.$store.dispatch('fetchLocationInstallations' , {
                    status: 'active',
                }),
                this.$store.dispatch('fetchAssetMasters' , {
                    status: 'active',
                }),
                this.$store.dispatch('fetchPriorities'),
                this.$store.dispatch('fetchTaskCategories'),
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