<template>
    <div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monthly Report</h1>
            <div>
                
            </div>
        </div>

        <div class="card">
            <!-- <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Filter Assignee</h5>
            </div> -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Date</small>
                        </span>
                        <el-date-picker 
                            style="width: 100%" 
                            v-model="filter.date" 
                            type="month"
                            @change="fetchData"
                            format="MMMM yyyy" 
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                    </div>
                    <div class="col-md-3 mb-3">
                        <span class="filter-text d-block">
                            <small>Filter Assignee</small>
                        </span>
                        <el-select
                            class="w-100"
                            filterable
                            searchable
                            clearable
                            multiple
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
                </div>

                <div class="border-bottom"></div>

                <el-table
                    :data="data"
                    stripe
                    border
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                    @cell-click="handleClickCell"
                >
                    <!-- <el-table-column label="No" width="70">
                        <template slot-scope="scope">
                            {{ meta.per_page * (meta.current_page - 1) + scope.$index + 1 }}
                        </template>
                    </el-table-column> -->
                    <el-table-column width="290" label="Name" fixed>
                        <template slot-scope="scope">
                            <div class="d-flex align-items-center">
                                <el-avatar :size="'large'" :src="scope.row.default_profile"></el-avatar>
                                <div style="margin-left: 15px;">
                                    <span class="d-block">{{ scope.row.name }}</span>
                                    <span></span>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column :label="getLabelTable(index)" v-for="index in getMaxDay" :key="index" :prop="getPropCell(index)">
                        <template slot-scope="scope">
                            
                            <el-tooltip v-if="getDataPercentagePerDay(scope.row , index) != '-' " class="item" effect="dark" content="See Detail" placement="top">
                                <el-button size="small">{{getDataPercentagePerDay(scope.row , index)}}</el-button>
                            </el-tooltip>
                            <span v-else>{{ getDataPercentagePerDay(scope.row , index) }}</span>
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

        <dialog-list-wo-per-day ref="dialogWoPerDayRef"/>

    </div>
</template>

<script>
import _ from "lodash";
import DialogListWoPerDay from "./DialogListWoPerDay.vue"
import moment from "moment";

export default {
    components:{
        DialogListWoPerDay,
    },
    data() {
        return {
            data: [],
            tableIsLoading: false,
            loadingSummary: false,
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
                date: moment().startOf().format('YYYY-MM-DD'),
                search: "",
                user_id: [],
            },

            users: [],
        };
    },

    computed: {
        getMaxDay() {
            return  parseInt(moment(this.filter.date).endOf('month').format('D'));
        }
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
                    ...this.filter
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.work-order.report.monthly"), properties).then((response) => {
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

        getDataPercentagePerDay(row, day){
            const date = this.filter.date.split('-');
            const dayNumber = day < 10 ? '0' + day : day;
            const data = row[date[0] + '-' + date[1] + '-' + dayNumber];
            return data ? data + '%' : '-';
        },

        getLabelTable(day) {
            const date = this.filter.date.split('-');
            return moment(date[0]  + '-' + date[1] + '-' + day).format('MMM DD');
        },

        getPropCell(day){
            const date = this.filter.date.split('-');
            return moment(date[0]  + '-' + date[1] + '-' + day).format('YYYY-MM-DD');
        },

        handleClickCell(row, column, cell, event) {

            console.log(row, column.property);
            
            if(column.property) {
                if(row[column.property]) {
                    this.$refs['dialogWoPerDayRef'].openDialog({
                        date: [
                            moment(column.property).format('YYYY-MM-DD 00:00:00'),
                            moment(column.property).format('YYYY-MM-DD 23:59:59'),
                        ],
                        user_id: row.id,

                        data_user: row,
                        percentage: row[column.property]
                    });
                }
            }
        }
    },

    mounted() {
        this.$nextTick().then(() => {

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