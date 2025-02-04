<template>
    <div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Minute Counter</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Minute Counter
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">History Minute Counter</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <span class="filter-text">
                            <small>Filter Date</small>
                        </span>
                        <el-date-picker 
                            style="width: 100%" 
                            v-model="filter.periode" 
                            type="month"
                            @change="fetchDetailMinuteCounter"
                            format="MMMM yyyy" 
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                    </div>
                </div>

                <el-table
                    :data="listHistory"
                    stripe
                    border
                    style="width: 100%"
                    ref="pageTable"
                    size="small"
                    v-loading.body="tableIsLoading"
                >
                    <el-table-column width="130" label="Date" prop="date">
                        <template slot-scope="scope">
                            <span class="d-block">{{ scope.row.date | formatDate }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column width="160" prop="after" label="Meter Record">
                        <template slot-scope="scope">
                           <span>{{ scope.row.after }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column width="160" prop="selisih" label="Usage">
                        <template slot-scope="scope">
                           <span>{{ scope.row.selisih }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="assignees" label="Assignees">
                        <template slot-scope="scope">
                            <el-tooltip v-for="(user, index ) in scope.row.assignees" :key="index" class="item" effect="dark" :content="user.name" placement="top">
                                <el-avatar style="cursor: pointer;" :size="'medium'"  :src="user.default_profile"></el-avatar>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column width="120"  label="Action">
                        <template slot-scope="scope">
                            <el-tooltip v-if="scope.row.work_order_id"  class="item" effect="dark" content="Detail Work Order" placement="left">
                                <el-button type="primary" size="small" icon="el-icon-info" @click="$refs['dialogDetailWorkOrderRef'].openDialog(scope.row.work_order_id)"></el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
        <dialog-detail-work-order ref="dialogDetailWorkOrderRef"></dialog-detail-work-order>
    </div>
</template>

<script>
import _ from "lodash";
import DialogDetailWorkOrder from "../../../Workorder/components/DialogDetailWorkOrder.vue";
import moment from "moment";


export default {
    components:{
        DialogDetailWorkOrder
    },
    data() {
        return {
            history_pompas: [],
            tableIsLoading: false,
            loadingSummary: false,
            location_installation: null,
            meta: {
                current_page: 1,
                per_page: 10,
            },

            filter: {
                periode: moment().startOf().format('YYYY-MM-01'),
            },
        };
    },

    computed: {
        listHistory() {
            let lastDay = this.getLastDayOfMonthFromDateString(this.filter.periode);

            let listHistory = [];
            for (let day = 1; day <= lastDay; day++) {

                let parts = this.filter.periode.split('-');
                let date = parts[0] + '-' + parts[1] + '-' + (day < 10 ? '0' + day : day);

                let dataHistory = this.history_pompas.find((item) => {
                    let part_date = item.created_at.split(' ');

                    return part_date[0] == date;
                })

                if(dataHistory) {
                    listHistory.push({
                        date: parts[0] + '-' + parts[1] + '-' + day,
                        before: dataHistory.before,
                        after:  dataHistory.after,
                        selisih:  dataHistory.selisih,
                        capacity:  dataHistory.capacity,
                        assignees: dataHistory.work_order_attachment.work_order.assignees.map((item) => {
                            return item.user;
                        }),
                        work_order_id: dataHistory.work_order_attachment.work_order_id

                    })
                }else{
                    listHistory.push({
                        date: date,
                        before: null,
                        after: null,
                        selisih: null,
                        capacity: null,
                        assignees: [],
                        work_order_id: null,
                    })
                }
            }

            return listHistory;
        },  
    },

    methods: {
        async fetchDetailMinuteCounter()
        {
            console.log(this.$route.params.location_installation_id);
            const response = await axios.get(route('api.location-installations.show' , {
                location_installation: this.$route.params.location_installation_id,
            }))

            if(response.status == 200) {
                this.location_installation = response.data.data;
            }
        },

        async fetchHistoryPompa()
        {
            const response = await axios.get(route('api.history-pompas.list') , {
                params: {
                    periode: this.filter.periode,
                    location_installation_id: this.$route.params.location_installation_id,
                    relations: 'work_order_attachment.work_order.assignees.user'
                }
            })

            if(response.status == 200) {
                this.history_pompas = response.data.data;
            }
        },

        getLastDayOfMonthFromDateString(dateString) {
            // Mengurai tanggal dari string
            var parts = dateString.split('-');
            var year = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            
            // Bulan dalam JavaScript dihitung dari 0 (Januari) hingga 11 (Desember)
            // Jadi, untuk mendapatkan bulan berikutnya, kita menggunakan month
            var date = new Date(year, month, 0);
            
            // Mengembalikan hari terakhir dari bulan
            return date.getDate();
        }
    },

    mounted() {
        this.fetchDetailMinuteCounter();
        this.fetchHistoryPompa();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>