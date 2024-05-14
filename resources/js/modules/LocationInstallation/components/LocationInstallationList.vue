<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Location Installation</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Location Installation
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="m-0">Location Installation</h5>
                <el-button
                    v-if="hasAccess('location-installation.location-installation-list')"
                    type="primary"
                    icon="el-icon-plus"
                    @click="() => {
                        $refs['dialogLocationInstallationRef'].resetForm()
                        $refs['dialogLocationInstallationRef'].openDialog()
                    }"
                    >Create Location Installation</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end w-100">
                    <div class="col-lg-3">
                        <span class="filter-text">
                            <small>Filter Location</small>
                        </span>
                        <el-select
                            class="w-100"
                            clearable
                            v-model="filter.location_id"
                            @change="fetchData"
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
                    <div class="col-lg-3">
                        <span class="filter-text">
                            <small>Filter Pompa</small>
                        </span>
                        <el-select
                             class="w-100"
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
                    <div class="col-lg-3 flex justify-content-end">
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
                    <el-table-column label="No" width="90">
                        <template slot-scope="scope">
                            {{ meta.per_page * (meta.current_page - 1) + scope.$index + 1 }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="location_id" label="Location" sortable>
                        <template slot-scope="scope">
                            <span >{{ scope.row.location.name }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="pompa_id" label="Pompa" sortable>
                         <template slot-scope="scope">
                            <span>{{ scope.row.pompa.name }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Name" sortable>
                    </el-table-column>
                    <el-table-column prop="jenis_pompa" label="Jenis Pompa" sortable>
                        <template slot-scope="scope">
                            <span style="text-transform: capitalize">{{ scope.row.jenis_pompa }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="status" label="Status" sortable>
                        <template slot-scope="scope">
                            <span v-if="scope.row.status == 'active'" class="badge bg-label-success" style="text-transform: capitalize;">
                                Active
                            </span>
                            <span v-if="scope.row.status == 'not_active'" class="badge bg-label-danger" style="text-transform: capitalize;">
                                Not Active
                            </span>
                        </template>
                    </el-table-column>
                    <el-table-column width="250px" prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('location-installation.location-installation-update')"
                                    type="primary"
                                    icon="el-icon-edit"
                                    @click="() => {
                                        $refs['dialogLocationInstallationRef'].setForm(scope.row)
                                        $refs['dialogLocationInstallationRef'].openDialog()
                                    }"
                                ></el-button>
                                <el-button
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    v-if="hasAccess('location-installation.location-installation-delete')"
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

        <dialog-location-installation-form
            ref="dialogLocationInstallationRef"
            @handleSuccessSubmit="fetchData"
        ></dialog-location-installation-form>
    </div>
</template>

<script>
import _ from "lodash";
import { mapState , mapActions } from "vuex";
import DialogLocationInstallationForm from './DialogLocationInstallationForm.vue';

export default {
    components:{
        DialogLocationInstallationForm,
    },
    data() {
        return {
            data: [],
            filter: {
                search: '',
                pompa_id: '',
                location_id: '',
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
                    ...this.filter,
                    ...this.order_meta,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.location-installations.list"), properties).then((response) => {
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
            this.order_meta = {
                order_by: event.prop,
                order: event.order,
            };

            this.queryServer();
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
                        route("api.location-installations.destroy", {
                            location_installation: row.id,
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
        this.$store.dispatch('fetchLocations');
        this.$store.dispatch('fetchPompas');
        this.fetchData();
        
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>