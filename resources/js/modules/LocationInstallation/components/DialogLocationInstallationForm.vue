<template>
    <el-dialog
        :title="locationInstallationForm.hasOwnProperty('id') ? 'Edit Location Installation' : 'Create Location Installation'"
        :visible.sync="show"
        width="30%"
        :close-on-click-modal="false"
    >
    <el-form 
        :model="locationInstallationForm" 
        :rules="rules" 
        ref="locationInstallationFormForm" 
        label-position="top"         
        class="demo-ruleForm">

        <el-form-item label="Name" prop="name">
            <el-input v-model="locationInstallationForm.name" placeholder="Cth: Pompa 1"></el-input>
        </el-form-item>
        <div class="row">
            <div class="col-lg-6">
                <el-form-item label="Location" prop="location_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="locationInstallationForm.location_id"
                        placeholder="Choose Location"
                    >
                        <el-option
                            v-for="location in locations"
                            :key="location.id"
                            :label="location.name"
                            :value="location.id"
                        ></el-option>
                    </el-select>
                </el-form-item>
            </div>
            <div class="col-lg-6">
                <el-form-item label="Pompa" prop="pompa_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="locationInstallationForm.pompa_id"
                        placeholder="Choose Pompa"
                    >
                        <el-option
                            v-for="pompa in pompas"
                            :key="pompa.id"
                            :label="pompa.name"
                            :value="pompa.id"
                        ></el-option>
                    </el-select>
                </el-form-item>
            </div>
            <el-form-item label="Pompa Type" prop="jenis_pompa">
                <el-radio-group v-model="locationInstallationForm.jenis_pompa">
                    <el-radio class="m-0 me-2" label="irigasi" border>Irigasi</el-radio>
                    <el-radio class="m-0" label="limbah" border>Limbah</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="Status" prop="status">
                <el-switch v-model="locationInstallationForm.status" active-text="Active" active-value="active" inactive-value="not_active"></el-switch>
            </el-form-item>
        </div>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitLocatioInstallationForm()">
            {{ locationInstallationForm.hasOwnProperty('id') ? 'Update Location Installation' : 'Create Location Installation' }}
        </el-button>
    </span>
    </el-dialog>
</template>

<script>

import { mapState , mapActions } from "vuex";

export default {
    data() {
        return {
            show: false,
            loading: false,
            locationInstallationForm: {
                name: '',
                location_id: '',
                pompa_id: '',
                jenis_pompa: '',
                status: '',
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Name is required'
                    },
                ],
                location_id: [
                    {
                        required: true,
                        trigger: ['change'],
                        message: 'Location is required'
                    },
                ],
                pompa_id: [
                    {
                        required: true,
                        trigger: ['change'],
                        message: 'Pompa is required'
                    },
                ],
                jenis_pompa: [
                    {
                        required: true,
                        trigger: ['change'],
                        message: 'Pompa Type is required'
                    },
                ],
                status: [
                    {
                        required: true,
                        trigger: ['change'],
                        message: 'Status is required'
                    },
                ],
            }
        }
    },

    computed: {
        ...mapState({
            locations: (state) => state.Location.locations,
            pompas: (state) => state.Pompa.pompas,
        }),
    },

    methods: {
        openDialog() {
            this.show = true;
        },

        closeDialog() {
            this.show = false;
        },

        submitLocatioInstallationForm(){

            this.$refs["locationInstallationFormForm"].validate((valid) => {
                let fields = this.$refs["locationInstallationFormForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.$confirm("Are you sure want to save?", "Confirmation", {
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        type: "warning",
                    }).then((result) => {
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

                                this.$emit('handleSuccessSubmit' , response.data);
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    })
                }
            })

        },

        getRoute() {
            if (typeof this.locationInstallationForm.id != "undefined") {
                return axios.put(route('api.location-installations.update' , {
                    location_installation: this.locationInstallationForm.id
                }) , this.locationInstallationForm);
            }
            return axios.post(route('api.location-installations.store') , this.locationInstallationForm);
        },

        setForm(location_installation) {
            this.locationInstallationForm = {...this.locationInstallationForm, ...location_installation};
        },

        resetForm() {
            this.locationInstallationForm = {
                name: '',
            };
        }
        
    }
}
</script>