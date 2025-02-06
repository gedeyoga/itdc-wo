<template>
    <div>
        <div class="card">
            <div class="card-body" style="cursor: pointer;" @click="show = true;">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <el-image
                            style="width: 50px; height: 50px"
                            :src="null"
                            :fit="'cover'">
                        </el-image>
                    </div>
                    <div>
                        <h5 class="m-0 mb-2">{{ attachment ? attachment.attachment.name  : '-'}}</h5>
                        <p>{{ attachment ? attachment.attachment.description  : '-'}}</p>
                    </div>
                </div>
            </div>
        </div>

        <el-dialog
            :title="attachment ? attachment.attachment.name  : '-'"
            :visible.sync="show"
            width="50%"
            :close-on-click-modal="false"
            append-to-body
        >
            <el-form
                :model="form"
                ref="locationInstallationFormRef"
                class="demo-ruleForm"
            >
                <div v-for="(parameter , key) in form.data" >
                    <el-form-item
                        :key="key"
                        :prop="'data.' + key + '.after'"
                        :label="parameter ? parameter.asset_parameter ? parameter.asset_parameter.label : '-' : '-'"
                        :rules="{
                            required: true,
                            trigger: ['blur'],
                            message: parameter ? parameter.asset_parameter ? parameter.asset_parameter.label : '-' : '-' + ' is required'
                        }"
                        
                    >
                        <!-- <input v-model="form.data[key].value" type="number" placeholder="Cth : 123088" :disabled="!canFill" /> -->
                        <el-input v-model="parameter.after" type="number" placeholder="Cth : 123088" :min="0" @blur="updateValue(key)">
                            <template slot="append">
                                {{ parameter ? parameter.asset_parameter ? parameter.asset_parameter.satuan : '-' : '-' }}
                            </template>
                        </el-input>
                    </el-form-item>
                </div>
                
                <div class="text-center">
                    <el-button icon="el-icon-close" size="mini" @click="closeDialog">Back</el-button>
                    <el-button icon="el-icon-check" type="success" size="mini" @click="saveData">Simpan</el-button>
                </div>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: {
        attachment: {
            default: null,
        },

        canFill: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            form: {
                testValue: null,
                data: [
                    {
                        asset_parameter: {
                            name: '',
                            description: '',  
                        },
                        asset_parameter: {
                            label: '',
                            satuan: '',
                        }
                    }
                ],
            },

            show: false,
        };
    },

    watch: {
        attachment: function(val) {
            if(val) {
                console.log('sdfjkhsdkl');
                this.syncForm(val);
            }
        }
    },  

    methods: {
        validateForm() 
        {
            return new Promise((resolve) => {
                this.$refs['locationInstallationFormRef'].validate((valid) => {
                    resolve(valid);
                });
            });
        },

        getValue() {
            return this.form;
        },

        async updateValue(key) {
            if(this.form.data[key].after) {
                const response = await axios.post(route('api.asset-usages.update-usage'),{
                    id: this.form.data[key].id,
                    usage: this.form.data[key].after
                });

                console.log(response);
            }
        },

        syncForm(data) {
            this.form.data = [];

            for (let index = 0; index < data.attachment_datas.length; index++) {
                this.form.data.push(data.attachment_datas[index]);
                
            }
        },

        openDialog() {
            this.show = true;
        },

        closeDialog() {
            this.show = false;
        },

        saveData() {
            this.validateForm().then((valid) => {
                if(valid) { 
                    this.$confirm("Are you sure want to save?", "Confirmation", {
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        type: "warning",
                    })
                    .then((res) => {
                        this.closeDialog()
                    })
                }
            })
        }
    },

    created() {
        
    },

    mounted() {
        if(this.attachment) {
            this.syncForm(this.attachment);
        }
    }
};
</script>
