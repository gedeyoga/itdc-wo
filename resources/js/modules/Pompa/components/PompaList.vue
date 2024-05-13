<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Pompa</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Pompa
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Pompa</h5>
                <el-button
                    v-if="hasAccess('pompa.pompa-list')"
                    type="primary"
                    icon="el-icon-plus"
                    @click="() => {
                        $refs['dialogPompaRef'].resetForm()
                        $refs['dialogPompaRef'].openDialog()
                    }"
                    >Create Pompa</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
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
                    sortable="custom"
                    @sort-change="handleSortChange"
                >
                    <el-table-column label="No" prop="id" width="90" sortable>
                        <template slot-scope="scope">
                            {{ meta.per_page * (meta.current_page - 1) + scope.$index + 1 }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Pompa" sortable>
                        <template slot-scope="scope">
                            <span class="d-block">{{ scope.row.name }}</span>
                            <small><span class="d-block">{{ scope.row.merk }} </span></small>
                        </template>
                    </el-table-column>
                    <el-table-column prop="type" label="Type" sortable>
                    </el-table-column>
                    <el-table-column prop="year" label="Year" sortable>
                    </el-table-column>
                    <el-table-column prop="power_kwh" label="Power (kW/h)" sortable>
                        <template slot-scope="scope">
                            <span>{{ scope.row.power_kwh }} kW/h</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="capacity" label="Capacity" sortable>
                        <template slot-scope="scope">
                            <span>{{ scope.row.capacity }} m3/Minute</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Action">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('pompa.pompa-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="() => {
                                        $refs['dialogPompaRef'].setForm(scope.row)
                                        $refs['dialogPompaRef'].openDialog()
                                    }"
                                ></el-button>
                                <el-button
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    v-if="hasAccess('pompa.pompa-delete')"
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

        <dialog-pompa-form
            ref="dialogPompaRef"
            @handleSuccessSubmit="fetchData"
        ></dialog-pompa-form>
    </div>
</template>

<script>
import _ from "lodash";
import DialogPompaForm from './DialogPompaForm.vue';

export default {
    components:{
        DialogPompaForm,
    },
    data() {
        return {
            data: [],
            filter: {
                search: '',
            },
            tableIsLoading: false,
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
        };
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
                    ...this.filter,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.pompas.list"), properties).then((response) => {
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
                        route("api.pompas.destroy", {
                            pompa: row.id,
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

        handleSortChange(params) {
            this.order_meta.order = params.order
            this.order_meta.order_by = params.prop;

            this.meta.page = 1;

            this.fetchData();
        }
    },

    mounted() {
        this.fetchData();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>