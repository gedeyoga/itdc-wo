<template>
    <div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div
                        class="card-header d-flex align-items-center justify-content-between"
                    >
                        <h5 class="card-title m-0 me-2">Your Workorder</h5>
                        <el-radio-group size="mini" v-model="mode_wo">
                            <el-radio-button label="Ongoing"></el-radio-button>
                            <el-radio-button label="Done"></el-radio-button>
                        </el-radio-group>
                    </div>
                    <div class="card-body">
                        <el-table
                            :data="work_orders"
                            style="width: 100%"
                            ref="pageTable"
                            height="350"
                            v-loading.body="tableIsLoading"
                        >
                            <el-table-column label="Workorder" prop="name" fixed>
                                <template slot-scope="scope">
                                    <div class="d-flex align-items-center mb-1">
                                        <status-component style="margin-right: 7px;" :status="scope.row.status"></status-component>
                                        <el-divider direction="vertical"></el-divider>
                                        <span class="text-light">
                                            <small>{{ scope.row.date | formatDateTime }} </small>
                                        </span>
                                        
                                        
                                    </div>
                                    <span>
                                        <b>{{ scope.row.name }}</b>
                                    </span> <br>
                                    <div class="d-flex mt-3 align-items-center">
                                        <priority-component style="margin-right: 7px" :status="scope.row.priority.name.toLowerCase()"></priority-component>
                                        <el-divider direction="vertical"></el-divider>
                                        <span >{{ scope.row.location.name }}</span>
                                    </div>
                                </template>
                            </el-table-column>
                            <el-table-column width="90" >
                                <template slot-scope="scope">
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
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div
                        class="card-header d-flex align-items-center justify-content-between"
                    >
                        <h5 class="card-title m-0 me-2">Overview</h5>
                    </div>
                    <div class="card-body" v-loading="loading_overview">
                        <div class="text-center">
                            <el-progress type="dashboard" :percentage="persentase_overview" :color="[
                                {color: '#E6381A', percentage: 25},
                                {color: '#FFAB00', percentage: 50},
                                {color: '#FFAB00', percentage: 70}
                            ]"></el-progress>
                        </div>
                       <ul class="p-0 m-0">
                        <li v-for="(key , index) in status_overview" :key="index" class="d-flex py-4 border-bottom">
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0" style="text-transform: capitalize">{{ index }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">{{ key }}</h6>
                              
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>

        <dialog-detail-work-order ref="dialogWorkorderRef" @refreshList="fetchData"></dialog-detail-work-order>
    </div>
</template>

<script>
import PriorityComponent from "../../Workorder/components/PriorityComponent.vue";
import StatusComponent from "../../Workorder/components/StatusComponent.vue";
import DialogDetailWorkOrder from "../../Workorder/components/DialogDetailWorkOrder.vue";

export default {
    components: {
        PriorityComponent,
        StatusComponent,
        DialogDetailWorkOrder
    },

    watch: {
        mode_wo: function(val) {
            if(val.toLowerCase() == 'ongoing') {
                this.fetchOngoingWo()
            }else {
                this.fetchDoneWo()
            }
        }
    },
    data() {
        return {
            work_orders: [],
            tableIsLoading: false,
            loading_overview: false,
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            list_roles: [],
            filter: {},
            mode_wo: 'Ongoing',
            status_overview: {},
        };
    },

    computed: {
        persentase_overview() {
            if(Object.keys(this.status_overview).length > 0) {

                let total_wo = 0;
                for (const key in this.status_overview) {
                    total_wo += this.status_overview[key]
                }

                const percentage = Math.round((this.status_overview.finish / total_wo ) * 100);

                console.log(typeof percentage);

                return !isNaN(percentage) ? percentage : 0;
            }

            return 0;
        }
    },

    methods: {
        queryServer() {
            const cancelSource = axios.CancelToken.source();
            const properties = {
                params: {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    search: this.searchQuery,
                    user_id: this.user.id,
                    relations:
                        "priority,task_category,work_order_items,assignees.user,location",
                    ...this.filter,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios
                .get(route("api.work-order.list"), properties)
                .then((response) => {
                    if (typeof response !== "undefined") {
                        this.tableIsLoading = false;
                        this.work_orders = response.data.data;
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
        cancel() {
            this.request.cancel();
        },

        fetchOngoingWo() {
            this.filter = {
                status: ["pending", "progress"],
            };

            this.fetchData();
        },

        fetchDoneWo() {
            this.filter = {
                status: ["finish", "cancel"],
            };
            this.fetchData();
        },

        fetchOverview() {
            this.loading_overview = true;
            axios
                .get(route("api.work-order.overview"), {
                    params: {
                        user_id: this.user.id,
                        date: [
                            '2023-12-01',
                            '2023-12-31'
                        ]
                    }
                })
                .then((response) => {
                    this.loading_overview = false;

                    this.status_overview = response.data
                })
                .catch(() => {
                    this.loading_overview = false;
                });
        },
    },

    mounted() {
        Promise.all([
            this.fetchOverview(),
            this.fetchOngoingWo(),
        ])
    },
};
</script>
