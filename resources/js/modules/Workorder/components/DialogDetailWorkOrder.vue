<template>
    <el-dialog
        :title="workorder_data ? workorder_data.code : 'Loading..'"
        :visible.sync="show"
        :width="isMobile() ? '90%' : '50%'"
        :close-on-click-modal="false">

        <detail-work-order 
            ref="detailWorkorderRef"
            v-if="workorder_data" 
            :workorder.sync="workorder"
            @subtaskUpdating="(val) => loading = val"
        ></detail-work-order>

        <span slot="footer" class="dialog-footer d-flex justify-content-center">
            <template v-if="workorder_data">
                <el-button  icon="el-icon-close" v-if="!['finish' , 'cancel'].includes(workorder_data.status)" :loading="loading" @click="submitWorkorder('cancel')" type="danger">Cancel</el-button>
                <el-button icon="el-icon-position" v-if="workorder_data.status == 'pending'" :loading="loading" @click="submitWorkorder('progress')" type="primary">Progress</el-button>
                <el-button icon="el-icon-check" v-else-if="workorder_data.status == 'progress'" :loading="loading" @click="submitWorkorder('finish')" type="success">Finish</el-button>
            </template>
        </span>
    </el-dialog>
</template>
<script>

import DetailWorkOrder from "./DetailWorkOrder.vue";

export default {
    components: {
        DetailWorkOrder,        
    },
    data() {
        return {
            show: false,
            workorder: null,
            loading: false,
            refreshListWorkorderOnCloseDialog: false,
        }
    },

    watch: {
        show: function(val) {
            if(val == false) {
                if(this.refreshListWorkorderOnCloseDialog) {
                    this.$emit('refreshList', {});
                }
            }
        }
    },

    computed: {
        workorder_data: {
            set() {
                return this.workorder;
            },

            get() {
                return this.workorder;
            }
        }
    },

    methods: {
        openDialog(workorder_id) {
            this.refreshListWorkorderOnCloseDialog = false;
            this.show = true;

            this.fetchWorkOrder(workorder_id);
        },

        closeDialog(){
            this.workorder = {}
            this.show = false;
        },

        fetchWorkOrder(workorder_id) {
            this.loading = true;
            axios
                .get(route('api.work-order.show' , {work_order: workorder_id}))
                .then((response) => {
                    this.loading = false;
                    this.workorder = response.data.data;
                })
                .catch(() => {
                    this.loading = false;
                })
        },

        submitWorkorder(status)
        {
            if(status == 'progress') {
                this.progressWorkorder();
            } else if(status == 'finish') {
                this.finishWorkorder();
            } else if(status == 'cancel') {
                this.cancelWorkOrder();
            }
        },

        progressWorkorder()
        {
            this.$confirm("Are you sure want to progress workorder?", "Confirmation", {
                confirmButtonText: "Save",
                cancelButtonText: "Cancel",
                type: "warning",
            }).then((result) => {
                const form = {
                    status: 'progress'
                };

                this.loading = true;
                axios
                    .post(route('api.work-order.update-status', {work_order: this.workorder_data.id}), form)
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });

                        this.fetchWorkOrder(this.workorder_data.id);
                    })
                    .catch(() => {
                        this.loading = false;
                    })
            })
        },

        finishWorkorder()
        {
            this.$refs['detailWorkorderRef'].validate((valid) => {
                if(valid) {
                    this.$confirm("Are you sure want to finish workorder?", "Confirmation", {
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        type: "warning",
                    }).then((result) => {
                        const form = {
                            status: 'finish'
                        };

                        this.loading = true;
                        axios
                            .post(route('api.work-order.update-status', {work_order: this.workorder_data.id}), form)
                            .then((response) => {
                                this.loading = false;
                                this.refreshListWorkorderOnCloseDialog = true;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });

                                this.fetchWorkOrder(this.workorder_data.id);
                                
                            })
                            .catch(() => {
                                this.loading = false;
                            })
                    })
                }
            })
        },

        cancelWorkOrder()
        {
            this.$refs['detailWorkorderRef'].validate((valid) => {
                if(valid) {
                    this.$confirm("Are you sure want to cancel workorder?", "Confirmation", {
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        type: "warning",
                    }).then((result) => {
                        const form = {
                            status: 'cancel'
                        };

                        this.loading = true;
                        axios
                            .post(route('api.work-order.update-status', {work_order: this.workorder_data.id}), form)
                            .then((response) => {
                                this.loading = false;
                                this.refreshListWorkorderOnCloseDialog = true;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });

                                this.fetchWorkOrder(this.workorder_data.id);
                                
                            })
                            .catch(() => {
                                this.loading = false;
                            })
                    })
                }
            })
        },




    }
}
</script>