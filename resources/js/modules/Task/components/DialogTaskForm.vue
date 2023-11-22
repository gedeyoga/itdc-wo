<template>
    <el-dialog
        :title="task.hasOwnProperty('id') ? 'Edit Task' : 'Create Task'"
        :visible.sync="show"
        width="50%"
    >
    <el-form 
        :model="task" 
        :rules="rules" 
        ref="taskForm" 
        label-position="top"         
        class="demo-ruleForm">

        <h5>Task</h5>
        <el-form-item label="Title" prop="name">
            <el-input v-model="task.name"></el-input>
        </el-form-item>
        <el-form-item label="Description" prop="description">
            <el-input type="textarea" v-model="task.description"></el-input>
        </el-form-item>
        <h5 class="mt-4">Task Items</h5>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th width="90px">Media</th>
                    <th width="90px">Action</th>
                </tr>
            </thead>
           <tbody>
                <tr v-for="(item, index) in task.task_items" :key="index">
                    <td class="pt-3">
                        <el-form-item :prop="'task_items.' + index + '.name'" :rules="{
                            required: true,
                            trigger: ['blur'],
                            message: 'Form is required'
                        }">
                            <el-input v-model="item.name" placeholder="Example: Checking email notification"></el-input>
                        </el-form-item>
                    </td>
                    <td class="pt-3">
                        <el-form-item :prop="'task_items.' + index + '.has_media'">
                            <el-switch
                                v-model="item.has_media"
                                :active-value="1"
                                :inactive-value="0">
                            </el-switch>
                        </el-form-item>
                    </td>
                    <td>
                       <el-button type="danger" icon="el-icon-delete" size="small" @click="task.task_items.splice(index,1)"></el-button>
                    </td>
                </tr>
           </tbody>
        </table>
        <div>
            <el-button 
                size="small" 
                type="primary" 
                icon="el-icon-plus" 
                plain
                @click="task.task_items.push({
                    name: '',
                    has_media: 0,
                })"
            >
                 Add Item
            </el-button>
        </div>
        <h5 class="mt-4">Settings</h5>
        <div class="row">
            <div class="col-lg-6">
                <el-form-item label="Priority" prop="priority_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="task.priority_id"
                        placeholder="Choose Priority"
                    >
                        <el-option
                            v-for="priority in priorities"
                            :key="priority.id"
                            :label="priority.name"
                            :value="priority.id"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
            </div>
            <div class="col-lg-6">
                <el-form-item label="Category" prop="task_category_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="task.task_category_id"
                        placeholder="Choose Priority"
                    >
                        <el-option
                            v-for="task_category in task_categories"
                            :key="task_category.id"
                            :label="task_category.name"
                            :value="task_category.id"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
            </div>
        </div>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitTaskForm()">
            {{ task.hasOwnProperty('id') ? 'Update Task' : 'Create Task' }}
        </el-button>
    </span>
    </el-dialog>
</template>

<script>

import { mapState } from "vuex";

export default {
    data() {
        return {
            show: false,
            loading: false,
            task: {
                name: '',
                description: '',
                task_category_id: '',
                priority_id: '',
                task_items: [
                    {
                        name: '',
                        has_media: 0,
                    }
                ],
            },
            rules: {
                name: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Title is required'
                    },
                ],
                description: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Description is required'
                    },
                ],
                priority_id: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Priority is required'
                    },
                ],
                task_category_id: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Category is required'
                    },
                ],
            }
        }
    },

    computed: {
         ...mapState({
            priorities: (state) => state.Priority.priorities,
            task_categories: (state) => state.TaskCategory.task_categories,
        })
    },

    methods: {
        openDialog() {
            this.show = true;
        },

        closeDialog() {
            this.show = false;
        },

        submitTaskForm(){

            this.$refs["taskForm"].validate((valid) => {
                let fields = this.$refs["taskForm"].fields;
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
            if (typeof this.task.id != "undefined") {
                return axios.put(route('api.task.update' , {
                    task: this.task.id
                }) , this.task);
            }
            return axios.post(route('api.task.store') , this.task);
        },

        setForm(task) {
            this.task = {...this.task, ...task};
        },

        resetForm() {
            this.task = {
                name: '',
                description: '',
                task_category_id: '',
                priority_id: '',
                task_items: [
                    {
                        name: '',
                        has_media: 0,
                    }
                ],
            };
        }
        
    }
}
</script>