<template>
    <el-dialog
        :title="assetMasterForm.hasOwnProperty('id') ? 'Edit AssetMaster' : 'Create AssetMaster'"
        :visible.sync="show"
        width="50%"
        :close-on-click-modal="false"
    >
        <el-form
            :model="assetMasterForm"
            :rules="rules"
            ref="assetMasterFormForm"
            label-position="top"
            class="demo-ruleForm"
        >
            <el-form-item label="Name" prop="name">
                <el-input v-model="assetMasterForm.name" placeholder="Cth : AssetMaster lagoon 1"></el-input>
            </el-form-item>
            <el-form-item label="Notes" prop="description">
                <el-input v-model="assetMasterForm.description" type="textarea" placeholder="Cth : pompa dekat gedung 1"></el-input>
            </el-form-item>
            <el-form-item label="Status" prop="status">
                <el-switch v-model="assetMasterForm.status" active-value="active" inactive-value="inactive" active-text="Active"></el-switch>
            </el-form-item>

            <p><span class="text-danger">*</span>Asset Parameters</p>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Satuan</th>
                        <th>With Image</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in assetMasterForm.asset_parameters" :key="key">
                        <td>
                            <el-form-item 
                                class="d-inline-block mb-0 mr-3 w-100" 
                                :prop="'asset_parameters.' + key + '.label'" 
                                :rules="[
                                    {
                                        required: true,
                                        trigger: ['blur'],
                                        message: 'Label required!'
                                    },
                                ]">
                                <el-input v-model="item.label" placeholder="Cth : Minute Counter"></el-input>
                            </el-form-item>
                        </td>
                        <td>
                            <el-form-item 
                                class="d-inline-block mb-0 mr-3 w-100" 
                                :prop="'asset_parameters.' + key + '.satuan'" 
                                :rules="[
                                    {
                                        required: true,
                                        trigger: ['blur'],
                                        message: 'Satuan required!'
                                    },
                                ]">
                                <el-input v-model="item.satuan" placeholder="Cth : m3/menit"></el-input>
                            </el-form-item>
                        </td>
                        <td>
                            <el-form-item :prop="'asset_parameters.' + key + '.has_image'" >
                                <el-switch v-model="item.has_image" :active-value="1" :inactive-value="0"></el-switch>
                            </el-form-item>
                        </td>
                        <td>
                            <el-button icon="el-icon-delete" type="danger" @click="removeParameter(key)"></el-button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            <el-button icon="el-icon-plus" @click="handleAddParameter">Add Parameter</el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button :loading="loading" @click="closeDialog"
                >Cancel</el-button
            >
            <el-button
                :loading="loading"
                type="primary"
                @click="submitAssetMasterForm()"
            >
                {{
                    assetMasterForm.hasOwnProperty("id")
                        ? "Update Asset"
                        : "Create Asset"
                }}
            </el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    data() {
        return {
            show: false,
            loading: false,
            assetMasterForm: {
                name: "",
                description: "",
                status: "",
                asset_parameters: [
                    {
                        label: '',
                        satuan: '',
                        has_image: 0,
                    }
                ],
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Name is required",
                    },
                ],
                description: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Description is required",
                    },
                ],
                status: [
                    {
                        required: true,
                        trigger: ["change"],
                        message: "Status is required",
                    },
                ],
            },
        };
    },

    methods: {
        openDialog() {
            this.show = true;
        },

        closeDialog() {

            this.resetForm();
            this.show = false;
        },

        submitAssetMasterForm() {
            this.$refs["assetMasterFormForm"].validate((valid) => {
                let fields = this.$refs["assetMasterFormForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.$confirm(
                        "Are you sure want to save?",
                        "Confirmation",
                        {
                            confirmButtonText: "Save",
                            cancelButtonText: "Cancel",
                            type: "warning",
                        }
                    ).then((result) => {
                        this.loading = true;
                        this.getRoute()
                            .then((response) => {
                                this.loading = false;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });

                                this.closeDialog();

                                this.$emit(
                                    "handleSuccessSubmit",
                                    response.data
                                );
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    });
                }
            });
        },

        getRoute() {
            if (typeof this.assetMasterForm.id != "undefined") {
                return axios.put(
                    route("api.asset-masters.update", {
                        asset_master: this.assetMasterForm.id,
                    }),
                    this.assetMasterForm
                );
            }
            return axios.post(route("api.asset-masters.store"), this.assetMasterForm);
        },

        setForm(assetMaster) {
            this.assetMasterForm = { ...this.assetMasterForm, ...assetMaster };
        },

        handleAddParameter() {
            this.assetMasterForm.asset_parameters.push({
                label: '',
                satuan: '',
                has_image: 0,
            });
        },

        removeParameter(index) {
            this.assetMasterForm.asset_parameters.splice(index, 1)
        },

        resetForm() {
            this.assetMasterForm = {
                name: "",
                description: "",
                status: "",
                asset_parameters: [
                    {
                        label: '',
                        satuan: '',
                        has_image: 0,
                    }
                ],
            };
        },
    },
};
</script>
