<template>
    <el-dialog
        :title="taskCategory.hasOwnProperty('id') ? 'Edit Task Category' : 'Create Task Category'"
        :visible.sync="show"
        width="30%"
    >
    <el-form 
        :model="taskCategory" 
        :rules="rules" 
        ref="taskCategoryForm" 
        label-position="top"         
        class="demo-ruleForm">

        <el-form-item label="Name" prop="name">
            <el-input v-model="taskCategory.name"></el-input>
        </el-form-item>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitTaskForm()">
            {{ taskCategory.hasOwnProperty('id') ? 'Update Task Category' : 'Create Task Category' }}
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
            taskCategory: {
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

        submitTaskForm(){

            this.$refs["taskCategoryForm"].validate((valid) => {
                let fields = this.$refs["taskCategoryForm"].fields;
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
            if (typeof this.taskCategory.id != "undefined") {
                return axios.put(route('api.task-categories.update' , {
                    task_category: this.taskCategory.id
                }) , this.taskCategory);
            }
            return axios.post(route('api.task-categories.store') , this.taskCategory);
        },

        setForm(task) {
            this.taskCategory = {...this.taskCategory, ...task};
        },

        resetForm() {
            this.taskCategory = {
                name: '',
            };
        }
        
    }
}
</script>