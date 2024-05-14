<template>
    <el-dialog
        class="tenant-form"
        :title="tenantForm.hasOwnProperty('id') ? 'Edit Tenant' : 'Create Tenant'"
        :visible.sync="show"
        width="70%"
        :close-on-click-modal="false"
    >
    <el-form 
        :model="tenantForm" 
        :rules="rules" 
        ref="tenantFormForm" 
        label-position="top"         
        class="demo-ruleForm">

        <el-form-item label="Name" prop="name">
            <el-input v-model="tenantForm.name" placeholder="Cth: ITDC"></el-input>
        </el-form-item>
        <el-form-item label="Address" prop="address">
            <el-input type="textarea" rows="2" v-model="tenantForm.address" placeholder="Cth: JL. Thamrin"></el-input>
        </el-form-item>
        <el-form-item label="Phone" prop="phone">
            <el-input v-model="tenantForm.phone" placeholder="Cth: 08123456789"></el-input>
        </el-form-item>
        <div class="row">
            <div class="col-lg-6">
                <el-form-item label="Bank Name" prop="bank">
                    <el-input v-model="tenantForm.bank" placeholder="Cth: BCA"></el-input>
                </el-form-item>
            </div>
            <div class="col-lg-6">
                <el-form-item label="Virtual Account" prop="virtual_account">
                    <el-input v-model="tenantForm.virtual_account" placeholder="Cth: 023458230480"></el-input>
                </el-form-item>
            </div>
        </div>
        <el-form-item label="Npwp" prop="npwp">
            <el-input v-model="tenantForm.npwp" placeholder="Cth: 029342304820  "></el-input>
        </el-form-item>
        <el-form-item label="Npwp" prop="npwp">
            <el-upload
                class="avatar-uploader"
                action="#"
                :show-file-list="false"
                :auto-upload="false"
                :on-change="beforeAvatarUpload">
                <img v-if="tenantForm.logo" :src="tenantForm.logo" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
        </el-form-item>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitTenantForm()">
            {{ tenantForm.hasOwnProperty('id') ? 'Update Tenant' : 'Create Tenant' }}
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
            tenantForm: {
                name: '',
                address : '',
                phone : '',
                virtual_account : '',
                bank : '',
                npwp : '',
                file_logo : null, 
                logo: null,
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Name is required'
                    },
                ],
                address: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Address is required'
                    },
                ],
                phone: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Phone is required'
                    },
                ],
                virtual_account: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Virtual Account is required'
                    },
                ],
                bank: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Bank Name is required'
                    },
                ],
                npwp: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'NPWP Name is required'
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

        submitTenantForm(){

            this.$refs["tenantFormForm"].validate((valid) => {
                let fields = this.$refs["tenantFormForm"].fields;
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
            const formData = new FormData();
            for (const key in this.tenantForm) {
                formData.append(key, this.tenantForm[key]);
            }

            if (typeof this.tenantForm.id != "undefined") {
                formData.append('_method' , 'PUT');

                return axios.post(route('api.tenants.update' , {
                    tenant: this.tenantForm.id
                }) , formData , {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    }
                });
            }
            return axios.post(route('api.tenants.store') , formData , {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            });
        },

        setForm(tenant) {
            this.tenantForm = {...this.tenantForm, ...tenant};
        },

        resetForm() {
            this.tenantForm = {
                name: '',
                address : '',
                phone : '',
                virtual_account : '',
                bank : '',
                npwp : '',
                file_logo : null, 
                logo: null,
            };
        },

        beforeAvatarUpload(file) {
            this.tenantForm.file_logo = file.raw;
            this.tenantForm.logo = URL.createObjectURL(file.raw);
            
        }
        
    }
}
</script>
<style>
  .tenant-form .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .tenant-form .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .tenant-form .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .tenant-form .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>