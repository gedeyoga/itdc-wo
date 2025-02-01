<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Minute Counter</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Minute Counter
                    </li>
                </ol>
            </nav>
        </div>

        <el-tabs type="border-card">
            <el-tab-pane label="Limbah">
                <limbah-table></limbah-table>
            </el-tab-pane>
            <el-tab-pane label="Irigasi">Config</el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
import _ from "lodash";
import LimbahTable from "./LimbahTable.vue";

export default {
    components:{
        LimbahTable
    },
    data() {
        return {
            
        };
    },

    mounted() {
        this.$store.dispatch('fetchLocations');
        this.$store.dispatch('fetchPompas');
    }
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>