<template>
    <div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail History Asset</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        History Asset
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">History</h5>
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
                            @change="fetchHistoryAsset"
                            format="MMMM yyyy" 
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                    </div>
                </div>

                <table class="table table-responsive table-bordered table-sm">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center" valign="middle" width="150">Date</th>
                            <th v-for="(parameter , key) in history_assets" :key="key" colspan="2" class="text-center">{{ parameter.label }} ({{ parameter.satuan }})</th>
                            <!-- <th colspan="4" class="text-center">Minute Counter</th> -->
                        </tr>
                        <tr>
                            <template v-for="(parameter , key) in history_assets">
                                <th width="100">Record</th>
                                <th width="100">Usage</th>
                            </template>
                            <th>Action</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in listHistory" :key="key">
                            <td>{{ item.date |formatDate }}</td>
                            <template v-for="(parameter , indexParameter) in history_assets">
                                <template v-if="parameter.asset_usages.length > 0">

                                    <td >{{ checkDateHistory(key + 1, parameter.asset_usages).after }}</td>
                                    <td >{{ checkDateHistory(key + 1, parameter.asset_usages).selisih }}</td>
                                    
                                </template>
                                <template v-else>
                                    <td >0</td>
                                    <td>0</td>
                                    <td>-</td>
                                </template>
                            </template>

                            <td>
                                <el-button 
                                    v-if="
                                        (history_assets.length > 0) && 
                                        (history_assets[history_assets.length - 1].asset_usages.length > 0) &&
                                        checkDateHistory(key + 1, history_assets[history_assets.length - 1].asset_usages).work_order_attachment
                                    " 
                                    size="mini" 
                                    icon="el-icon-info" 
                                    @click="$refs['dialogDetailWorkOrderRef'].openDialog(checkDateHistory(key + 1, history_assets[history_assets.length - 1].asset_usages).work_order_attachment.work_order_id)">
                                    Detail
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            history_assets: [],
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

            return listHistory;
        },  
    },

    methods: {

        async fetchHistoryAsset()
        {
            const response = await axios.get(route('api.asset-usages.history-assets.detail') , {
                params: {
                    periode: this.filter.periode,
                    asset_id: this.$route.params.asset_master,
                    relations: 'work_order_attachment.work_order.assignees.user'
                }
            })

            if(response.status == 200) {
                this.history_assets = response.data.data;
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
        },

        checkDateHistory(day , usages) {

            console.log(usages , 'usages');
            let parts = this.filter.periode.split('-');
            let date = parts[0] + '-' + parts[1] + '-' + (day < 10 ? '0' + day : day);

            let dataHistory = usages.find((item) => {
                let part_date = item.created_at.split(' ');

                return part_date[0] == date;
            })

            const data = dataHistory ? dataHistory : {
                after : 0,
                before: 0,
                usage: 0,
                work_order_attachment: null,
            }

            return data
        }
    },

    mounted() {
        this.fetchHistoryAsset();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>