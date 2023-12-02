<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Work Order</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Work Order
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Work Order</h5>
                <el-button
                    v-if="hasAccess('workorder.workorder-list')"
                    type="primary"
                    icon="el-icon-plus"
                    @click="() => {
                        $refs['dialogWorkorderForm'].resetForm()
                        $refs['dialogWorkorderForm'].openDialog()
                    }"
                    >Create Work Order</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Date</small>
                        </span>
                        <el-date-picker 
                            style="width: 100%" 
                            v-model="filter.date" 
                            type="daterange"
                            start-placeholder="Start date" 
                            end-placeholder="End date" 
                            @change="fetchData"
                            format="dd MMMM yyyy" 
                            value-format="yyyy-MM-dd">
                      </el-date-picker>
                    </div>
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Priority</small>
                        </span>
                        <el-select
                            clearable
                            v-model="filter.priority_id"
                            @change="fetchData"
                            placeholder="Choose Priority"
                        >
                            <el-option
                                v-for="priority in priorities"
                                :key="priority.id"
                                :label="priority.name"
                                :value="priority.id"
                            >
                                <priority-component :status="priority.name.toLowerCase()"></priority-component>
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Category</small>
                        </span>
                        <el-select
                            clearable
                            filterable
                            v-model="filter.task_category_id"
                            @change="fetchData"
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
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Assignee</small>
                        </span>
                        <el-select
                            class="w-100"
                            filterable
                            searchable
                            clearable
                            v-model="filter.user_id"
                            @change="fetchData"
                            placeholder="Choose useer"
                        >
                            <el-option-group
                                v-for="group in users"
                                :key="group.name"
                                :label="group.name">
                                <el-option
                                    v-for="item in group.data"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                                    <div class="d-flex align-items-center">
                                        <el-avatar style="margin-right: 7px;" class="mr-3" size="small" :src="item.default_profile" :shape="'circle'"></el-avatar>
                                        <span>{{ item.name }}</span>
                                    </div>
                                </el-option>
                            </el-option-group>
                        </el-select>
                    </div>
                    <div class="col mb-3">
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
                    <!-- <el-table-column label="No" width="90">
                        <template slot-scope="scope">
                            {{ meta.per_page * (meta.current_page - 1) + scope.$index + 1 }}
                        </template>
                    </el-table-column> -->
                    <el-table-column width="130" label="Code" prop="code" fixed>
                        <template slot-scope="scope">
                            <span class="d-block">{{ scope.row.code }}</span>
                            <priority-component :status="scope.row.priority.name.toLowerCase()"></priority-component>
                        </template>
                    </el-table-column>
                    <el-table-column width="220" prop="name" label="Workorder">
                    </el-table-column>
                    <el-table-column prop="date" label="Date" width="200">
                        <template slot-scope="scope">
                            {{ scope.row.date | formatDateTime }}
                        </template>
                    </el-table-column>
                    <el-table-column width="120" prop="status" label="Status">
                        <template slot-scope="scope">
                            <status-component :status="scope.row.status"></status-component>
                        </template>
                    </el-table-column>
                    <el-table-column width="180" prop="user_id" label="Assignee">
                        <template slot-scope="scope">
                            <el-tooltip 
                                class="item" 
                                effect="dark" 
                                :content="assignee.user.name" 
                                placement="top" 
                                v-for="assignee in scope.row.assignees" :key="assignee.id">
                                <el-avatar 
                                    class="m-1"
                                    size="small" 
                                    :src="assignee.user.default_profile"
                                ></el-avatar>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column width="220" prop="task_category_id" label="Category">
                        <template slot-scope="scope">
                            {{ scope.row.task_category.name }}
                        </template>
                    </el-table-column>
                    <el-table-column width="150" prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip class="item" effect="dark" content="See Detail Workorder" placement="top">
                                    <el-button
                                        type="success"
                                        size="small"
                                        plain
                                        icon="el-icon-info"
                                        @click="() => {
                                            $refs['dialogWorkorderRef'].openDialog(scope.row.id)
                                        }"
                                    ></el-button>
                                </el-tooltip>
                                <el-tooltip class="item" effect="dark" content="Edit Workorder" placement="top">
                                    <el-button
                                        v-if="!['finish' , 'cancel'].includes(scope.row.status) && hasAccess('workorder.workorder-update')"
                                        type="primary"
                                        size="small"
                                        plain
                                        icon="el-icon-edit"
                                        @click="() => {
                                            $refs['dialogWorkorderForm'].setForm(scope.row)
                                            $refs['dialogWorkorderForm'].openDialog()
                                        }"
                                    ></el-button>
                                </el-tooltip>
                                <el-tooltip class="item" effect="dark" content="Delete Workorder" placement="top">
                                    <el-button
                                        type="danger"
                                        plain
                                        size="small"
                                        icon="el-icon-delete"
                                        v-if="!['finish' , 'cancel'].includes(scope.row.status) && hasAccess('workorder.workorder-delete')"
                                        @click="onDelete(scope.row)"
                                    ></el-button>
                                </el-tooltip>
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

        <dialog-workorder-form
            ref="dialogWorkorderForm"
            @handleSuccessSubmit="fetchData"
        ></dialog-workorder-form>

        <dialog-detail-work-order ref="dialogWorkorderRef" @refreshList="fetchData"></dialog-detail-work-order>
    </div>
</template>

<script>
import _ from "lodash";
import { mapState , mapActions } from "vuex";
import DialogWorkorderForm from './DialogWorkorderForm.vue';
import StatusComponent from './StatusComponent.vue';
import PriorityComponent from './PriorityComponent.vue';
import DialogDetailWorkOrder from './DialogDetailWorkOrder.vue';

export default {
    components:{
        DialogWorkorderForm,
        StatusComponent,
        PriorityComponent,
        DialogDetailWorkOrder
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
                date: [],
                search: "",
            },

            users: [],
        };
    },

    computed: {
        ...mapState({
            priorities: (state) => state.Priority.priorities,
            task_categories: (state) => state.TaskCategory.task_categories,
            locations: (state) => state.Location.locations,
        }),
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
                    relations: "priority,task_category,work_order_items,assignees.user",
                    ...this.filter
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.work-order.list"), properties).then((response) => {
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
                        route("api.work-order.destroy", {
                            work_order: row.id,
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
            this.$store.dispatch('fetchLocations');
            this.$store.dispatch('fetchPriorities');
            this.$store.dispatch('fetchTaskCategories');

            this.$store.dispatch('fetchUsers', {relations: 'roles',}).then((response) => {

                let users = response.data.data;
            
                let role_mapping = users.map((user) => {
                    user.roles = user.roles[0];
                    return user
                })
                let grouped = _.groupBy( role_mapping , 'roles.name');

                let mapping = Object.keys(grouped).map((type) => {
                    return {
                        name: type,
                        data : grouped[type]
                    };
                });

                this.users = mapping;
            });
            this.$store.dispatch('fetchTasks',{
                relations: 'priority,task_items',
            });

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