<template>
    <div>
        <div class="row mb-3 align-items-end">
            <div class="col-lg-2">
                <span class="filter-text">
                    <small>Filter Location</small>
                </span>
                <el-select
                    clearable
                    v-model="filter.location_id"
                    @change="fetchData"
                    filterable
                    placeholder="Choose Location"
                >
                    <el-option
                        v-for="location in locations"
                        :key="location.id"
                        :label="location.name"
                        :value="location.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-lg-2">
                <span class="filter-text">
                    <small>Filter Pompa</small>
                </span>
                <el-select
                    clearable
                    filterable
                    v-model="filter.pompa_id"
                    @change="fetchData"
                    placeholder="Choose Pompa"
                >
                    <el-option
                        v-for="pompa in pompas"
                        :key="pompa.id"
                        :label="pompa.name"
                        :value="pompa.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col">
                <div class="btn-group w-100">
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
                    {{
                        meta.per_page * (meta.current_page - 1) +
                        scope.$index +
                        1
                    }}
                </template>
            </el-table-column>
            <el-table-column prop="name" label="Location">
                <template slot-scope="scope">
                    <span class="d-block">{{ scope.row.name }}</span>
                    <small
                        ><span class="d-block"
                            >{{ scope.row.location.name }}
                        </span></small
                    >
                </template>
            </el-table-column>
            <el-table-column prop="type" label="Pompa">
                <template slot-scope="scope">
                    <span class="d-block">{{ scope.row.pompa.name }}</span>
                </template>
            </el-table-column>
            <el-table-column prop="after" label="Last Counter" sortable>
            </el-table-column>
            <el-table-column prop="before" label="Last Counter Before" sortable>
            </el-table-column>
            <el-table-column prop="selisih" label="Usage" sortable>
            </el-table-column>
            <el-table-column prop="status" label="Status" sortable>
                <template slot-scope="scope">
                    <span
                        v-if="scope.row.status == 'active'"
                        class="badge bg-label-success"
                        style="text-transform: capitalize"
                    >
                        Active
                    </span>
                    <span
                        v-if="scope.row.status == 'not_active'"
                        class="badge bg-label-danger"
                        style="text-transform: capitalize"
                    >
                        Not Active
                    </span>
                </template>
            </el-table-column>
            <el-table-column prop="actions" label="Action">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-button
                            v-if="hasAccess('pompa.pompa-update')"
                            type="primary"
                            icon="el-icon-info"
                            @click="$router.push({name: 'history.minute-counter.detail' , params: {
                                location_installation_id: scope.row.id
                            }})"
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
</template>

<script src="">

import { mapState , mapActions } from "vuex";

export default {
    data() {
        return {
            data: [],
            filter: {
                search: "",
                pompa_id: null,
                location_id: null,
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

    computed: {
        ...mapState({
            locations: (state) => state.Location.locations,
            pompas: (state) => state.Pompa.pompas,
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
                    jenis_pompa: 'limbah',
                    ...this.filter,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.location-installations.history"), properties).then((response) => {
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
            });
        },

        handleSortChange(params) {
            this.order_meta.order = params.order;
            this.order_meta.order_by = params.prop;

            this.meta.page = 1;

            this.fetchData();
        },
    },

    mounted() {
        this.fetchData();
    },
};
</script>
