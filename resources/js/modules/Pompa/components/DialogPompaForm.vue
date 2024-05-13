<template>
    <el-dialog
        :title="pompaForm.hasOwnProperty('id') ? 'Edit Pompa' : 'Create Pompa'"
        :visible.sync="show"
        width="70%"
    >
        <el-form
            :model="pompaForm"
            :rules="rules"
            ref="pompaFormForm"
            label-position="top"
            class="demo-ruleForm"
        >
            <el-form-item label="Name" prop="name">
                <el-input v-model="pompaForm.name" placeholder="Cth : L75.01"></el-input>
            </el-form-item>
            <el-form-item label="Merk" prop="name">
                <el-input v-model="pompaForm.merk" placeholder="Cth : EBARA"></el-input>
            </el-form-item>
            <div class="row">
                <div class="col-lg-6">
                     <el-form-item label="Type Pompa" prop="type">
                        <el-input v-model="pompaForm.type" placeholder="Cth : DSC330"></el-input>
                    </el-form-item>
                </div>
                <div class="col-lg-6">
                    <el-form-item label="Year" prop="year">
                        <el-date-picker
                            v-model="pompaForm.year"
                            type="year"
                            placeholder="Pick a year"
                        >
                        </el-date-picker>
                    </el-form-item>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <el-form-item label="Power KWH" prop="power_kwh">
                        <el-input type="number" v-model="pompaForm.power_kwh" placeholder="Cth : 7.5">
                            <template slot="append">Kwh</template>
                        </el-input>
                    </el-form-item>
                </div>
                <div class="col-lg-6">
                    <el-form-item label="Capacity" prop="capacity">
                        <el-input type="number" v-model="pompaForm.capacity" placeholder="Cth : 11.5">
                            <template slot="append">m3/minute</template>
                        </el-input>
                    </el-form-item>
                </div>
            </div>
           
            
            
            <el-form-item label="Status" prop="status">
                <el-switch v-model="pompaForm.status" active-value="active" inactive-value="not_active" active-text="Active"></el-switch>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button :loading="loading" @click="closeDialog"
                >Cancel</el-button
            >
            <el-button
                :loading="loading"
                type="primary"
                @click="submitPompaForm()"
            >
                {{
                    pompaForm.hasOwnProperty("id")
                        ? "Update Pompa"
                        : "Create Pompa"
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
            pompaForm: {
                name: "",
                merk: "",
                year: "",
                type: "",
                power_kwh: "",
                capacity: "",
                status: "",
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Name is required",
                    },
                ],
                year: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Year is required",
                    },
                ],
                type: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Type is required",
                    },
                ],
                power_kwh: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Power Kwh is required",
                    },
                ],
                capacity: [
                    {
                        required: true,
                        trigger: ["blur"],
                        message: "Capacity is required",
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
            this.show = false;
        },

        submitPompaForm() {
            this.$refs["pompaFormForm"].validate((valid) => {
                let fields = this.$refs["pompaFormForm"].fields;
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
            if (typeof this.pompaForm.id != "undefined") {
                return axios.put(
                    route("api.pompas.update", {
                        pompa: this.pompaForm.id,
                    }),
                    this.pompaForm
                );
            }
            return axios.post(route("api.pompas.store"), this.pompaForm);
        },

        setForm(pompa) {
            this.pompaForm = { ...this.pompaForm, ...pompa };
        },

        resetForm() {
            this.pompaForm = {
                name: "",
            };
        },
    },
};
</script>
