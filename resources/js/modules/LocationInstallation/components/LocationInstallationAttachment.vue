<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="m-0 mb-2">{{ locationInstallation ? locationInstallation.name  : '-'}}</h5>
                       <small> <span>{{ pompa ? pompa.name : '-' }}</span></small>
                    </div>
                    <div>
                        <span v-if="locationInstallation" class="badge bg-label-info">{{ locationInstallation.jenis_pompa == 'irigasi' ? 'Pompa Irigasi' : 'Pompa Limbah' }}</span>
                        <span v-else>-</span>
                    </div>
                </div>
                <el-form
                    :model="form"
                    ref="locationInstallationFormRef"
                    class="demo-ruleForm"
                >
                    <el-form-item
                        label="Meter Counter"
                        prop="meter_counter"
                        :rules="{
                            required: true,
                            trigger: ['blur'],
                            message: 'Meter Counter is required'
                        }"
                        
                    >
                        <el-input  type="number" v-model="form.meter_counter" placeholder="Cth : 123088" @blur="updateMeterCounter" :disabled="!canFill"></el-input>
                    </el-form-item>
                </el-form>
            </div>
        </div>
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
                meter_counter: null,
            },
        };
    },

    computed: {
        pompa() {
            if(this.attachment) {
                if(this.attachment.history_pompa) {
                   if(this.attachment.history_pompa.location) {
                        if(this.attachment.history_pompa.location.pompa) {
                            return this.attachment.history_pompa.location.pompa;
                        }
                   }
                }
            }

            return null;
        },

        locationInstallation() {
            if(this.attachment) {
                if(this.attachment.history_pompa) {
                    this.form.meter_counter = this.attachment.history_pompa.selisih;
                   if(this.attachment.history_pompa.location) {
                        return this.attachment.history_pompa.location;
                   }
                }
            }

            this.form.meter_counter = null;

            return null;
        },

        historyPompa() {
             if(this.attachment) {
                if(this.attachment.history_pompa) {
                    
                    return this.attachment.history_pompa;
                }
            }

            return null;
        }
    },

    methods: {
        validateForm() 
        {
            return new Promise((resolve) => {
                this.$refs['locationInstallationFormRef'].validate((valid) => {
                    console.log(valid);
                    resolve(valid);
                });
            });
        },

        getValue() {
            return this.form;
        },

        async updateMeterCounter() {
            
            if(this.form.meter_counter) {
                const response = await axios.put(route('api.history-pompas.update', {
                    history_pompa: this.attachment.history_pompa.id
                }), this.getValue());
            }



        },
    }
};
</script>
