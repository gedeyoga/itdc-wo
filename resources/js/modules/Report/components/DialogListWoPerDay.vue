<template>
    <el-dialog
        :title="getTitle(filter.date[0])"
        :visible.sync="show"
        width="90%"
        :close-on-click-modal="false"
    >
        <div class="row border mx-2 align-items-center p-4 p-lg-2 rounded">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <div class="d-flex justify-content-center justify-content-lg-center align-items-center">
                    <el-avatar style="margin-right: 15px;" class="mr-3" size="large" :src="data_user.default_profile" :shape="'circle'"></el-avatar>
                    <div class="d-flex flex-column">
                        <label>{{ data_user.name }}</label>
                        <span><small>{{ data_user.email }}</small></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="d-flex flex-column">
                    <label for="">Percentage</label>
                    <el-progress :text-inside="true" :stroke-width="15" :percentage="percentage" status="success"></el-progress>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-12 d-flex align-items-center align-items-lg-start flex-column">
                <span>Filter Status</span>
                <el-checkbox-group @change="fetchData" v-model="filter.status">
                    <el-checkbox-button v-for="status in status_list" :label="status" :key="status">{{ status }}</el-checkbox-button>
                </el-checkbox-group>
            </div>
        </div>
        <el-table
            :data="workorders"
            stripe
            style="width: 100%"
            ref="pageTable"
            v-loading.body="tableIsLoading"
        >
            <el-table-column width="130" label="Code" prop="code">
                <template slot-scope="scope">
                    <span class="d-block">{{ scope.row.code }}</span>
                    <priority-component
                        :status="scope.row.priority.name.toLowerCase()"
                    ></priority-component>
                </template>
            </el-table-column>
            <el-table-column width="220" prop="name" label="Workorder">
                <template slot-scope="scope">
                    <a
                        href="#"
                        @click.prevent="
                            $refs['dialogWorkorderRef'].openDialog(scope.row.id)
                        "
                        >{{ scope.row.name }}</a
                    >
                </template>
            </el-table-column>
            <el-table-column prop="date" label="Date" width="200">
                <template slot-scope="scope">
                    {{ scope.row.date | formatDateTime }}
                </template>
            </el-table-column>
            <el-table-column width="120" prop="status" label="Status">
                <template slot-scope="scope">
                    <status-component
                        :status="scope.row.status"
                    ></status-component>
                </template>
            </el-table-column>
            <el-table-column  prop="user_id" label="Assignee">
                <template slot-scope="scope">
                    <el-tooltip
                        class="item"
                        effect="dark"
                        :content="assignee.user.name"
                        placement="top"
                        v-for="assignee in scope.row.assignees"
                        :key="assignee.id"
                    >
                        <el-avatar
                            class="m-1"
                            size="small"
                            :src="assignee.user.default_profile"
                        ></el-avatar>
                    </el-tooltip>
                </template>
            </el-table-column>
            <!-- <el-table-column prop="task_category_id" label="Category">
                <template slot-scope="scope">
                    {{ scope.row.task_category.name }}
                </template>
            </el-table-column> -->
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

        <span slot="footer" class="dialog-footer">
            <el-button @click="closeDialog">Tutup</el-button>
        </span>
    </el-dialog>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            show: false,
            data_user: {
                name: '',
                email: '',
                data_user: '',
            },
            workorders: [],
            tableIsLoading: false,
            status_list: [
                'finish',
                'progress',
                'pending',
                'cancel'
            ],
            meta: {
                current_page: 1,
                per_page: 10,
                total: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            filter: {
                date: [
                    moment().format('YYYY-MM-DD'),
                    moment().format('YYYY-MM-DD'),
                ],
                user_id: null,
                status: [
                    'finish',
                ]
            },
            percentage: 0,
        };
    },
    methods: {
        closeDialog() {
            this.show = false;
        },

        openDialog(params) {
            this.show = true;

            let dataParams = {...params};

            delete dataParams.data_user;

            this.filter = {...this.filter , ...dataParams};

            this.data_user = {...this.data_user, ...params.data_user};
            this.percentage = parseInt(params.percentage);
            this.fetchData();
        },

        queryServer(customProperties) {
            const cancelSource = axios.CancelToken.source();
            const properties = {
                params: {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
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
                    this.workorders = response.data.data;
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

        getTitle(date) {
            return  'Report - ' + moment(date).format('YYYY MMM DD');
        }
    },
};
</script>
