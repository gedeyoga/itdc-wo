<template>
    <el-dialog
        :title="locationForm.hasOwnProperty('id') ? 'Edit Location' : 'Create Location'"
        :visible.sync="show"
        width="30%"
    >
    <el-form 
        :model="locationForm" 
        :rules="rules" 
        ref="locationFormForm" 
        label-position="top"         
        class="demo-ruleForm">

        <el-form-item label="Name" prop="name">
            <el-input v-model="locationForm.name"></el-input>
        </el-form-item>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitLocationForm()">
            {{ locationForm.hasOwnProperty('id') ? 'Update Location' : 'Create Location' }}
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
            locationForm: {
                name: '',
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Name is required'
                    },
                ],
            }
        }
    },

    methods: {
        openDialog() {
            this.show = true;
        },

        closeDialog() {
            this.show = false;
        },

        submitLocationForm(){

            this.$refs["locationFormForm"].validate((valid) => {
                let fields = this.$refs["locationFormForm"].fields;
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
            if (typeof this.locationForm.id != "undefined") {
                return axios.put(route('api.locations.update' , {
                    location: this.locationForm.id
                }) , this.locationForm);
            }
            return axios.post(route('api.locations.store') , this.locationForm);
        },

        setForm(location) {
            this.locationForm = {...this.locationForm, ...location};
        },

        resetForm() {
            this.locationForm = {
                name: '',
            };
        }
        
    }
}
</script>