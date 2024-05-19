<template>
    <el-dialog
        :title="work_order.hasOwnProperty('id') ? 'Edit Task' : 'Create Task'"
        :visible.sync="show"
        width="50%"
    >
    <el-form 
        :model="work_order" 
        :rules="rules" 
        ref="workorderForm" 
        label-position="top"         
        class="demo-ruleForm">

        <div class="row">
            <div class="col-6">
                <h5>Task</h5>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <!-- <el-button type="primary" plain size="mini" icon="el-icon-notebook-2">Use Template</el-button> -->
                <popover-choose-task-template
                    @handleTempalteUse="templateUsed"
                ></popover-choose-task-template>
            </div>
        </div>
        <el-form-item label="Title" prop="name">
            <el-input v-model="work_order.name" placeholder="Ex: Create a workorder..."></el-input>
        </el-form-item>
        <el-form-item label="Description" prop="description">
            <el-input type="textarea" placeholder="Ex: Create a description..." v-model="work_order.description"></el-input>
        </el-form-item>
        <h5 class="mt-4">Workorder Items</h5>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th width="90px">Media</th>
                    <th width="90px">Action</th>
                </tr>
            </thead>
           <tbody>
                <tr v-for="(item, index) in work_order.work_order_items" :key="index">
                    <td class="pt-3">
                        <el-form-item :prop="'work_order_items.' + index + '.name'" :rules="{
                            required: true,
                            trigger: ['blur'],
                            message: 'Form is required'
                        }">
                            <el-input v-model="item.name" placeholder="Example: Checking email notification"></el-input>
                        </el-form-item>
                    </td>
                    <td class="pt-3">
                        <el-form-item :prop="'work_order_items.' + index + '.has_media'">
                            <el-switch
                                v-model="item.has_media"
                                :active-value="1"
                                :inactive-value="0">
                            </el-switch>
                        </el-form-item>
                    </td>
                    <td>
                       <el-button type="danger" icon="el-icon-delete" size="small" @click="work_order.work_order_items.splice(index,1)"></el-button>
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
                @click="work_order.work_order_items.push({
                    name: '',
                    has_media: 0,
                })"
            >
                 Add Item
            </el-button>
        </div>
        <h5 class="mt-4">Settings</h5>
        <el-form-item label="Date" prop="date">
            <el-date-picker
                style="width: 100%"
                v-model="work_order.date"
                type="datetime"
                format="yyyy-MM-dd HH:mm"
                value-format="yyyy-MM-dd HH:mm"
                placeholder="Choose date">
            </el-date-picker>
        </el-form-item>
        <div class="row">
            <div class="col-lg-6">
                <el-form-item label="Assignee" prop="assignees">
                    <el-select
                        class="w-100"
                        filterable
                        searchable
                        clearable
                        multiple
                        v-model="work_order.assignees"
                        placeholder="Choose useer"
                    >
                        <el-option-group
                            v-for="group in user_assignees"
                            :key="group.name"
                            :label="group.name">
                            <el-option
                                v-for="item in group.data"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                                <div class="d-flex align-items-center">
                                    <el-avatar style="margin-right: 7px;" class="mr-3" size="small" :src="item.default_profile" :shape="'circle'"></el-avatar>
                                    <span>{{ item.name }}</span>
                                </div>
                            </el-option>
                        </el-option-group>
                    </el-select>
                </el-form-item>
            </div>
            <div class="col-lg-6">
                <el-form-item label="Location" prop="location_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="work_order.location_id"
                        placeholder="Choose Location"
                    >
                        <el-option
                            v-for="location in locations"
                            :key="location.id"
                            :label="location.name"
                            :value="location.id"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <el-form-item label="Priority" prop="priority_id">
                    <el-select
                        class="w-100"
                        clearable
                        v-model="work_order.priority_id"
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
                        v-model="work_order.task_category_id"
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

        <div class="mt-4">
            <h5>Attachment</h5>
            <el-checkbox v-model="work_order.fill_history_pompa" :true-label="1" :false-label="0">Wajib mencatat meter counter pompa</el-checkbox>
            <el-form-item v-if="work_order.fill_history_pompa" label="Choose Location Installation" prop="work_order_attachments" :rules="{
                required: true,
                trigger: ['change'],
                message: 'Field required.'
            }">
                <el-select clearable filterable multiple class="w-100" v-model="work_order.work_order_attachments" placeholder="Choose Location">
                    <el-option :value="item.value" :label="item.name" v-for="(item, index) in locationInstallations" :key="index"></el-option>
                </el-select>
            </el-form-item>
        </div>
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitWorkorderForm()">
            {{ work_order.hasOwnProperty('id') ? 'Update Task' : 'Create Task' }}
        </el-button>
    </span>
    </el-dialog>
</template>

<script>

import { mapActions, mapState } from "vuex";
import _ from "lodash";
import PopoverChooseTaskTemplate from './PopoverChooseTaskTemplate.vue';

export default {
    components: {
        PopoverChooseTaskTemplate,
    },  
    data() {
        return {
            show: false,
            loading: false,
            work_order: {
                name: '',
                description: '',
                date: '',
                location_id: '',
                task_category_id: '',
                priority_id: '',
                assignees: [],
                work_order_attachments: [],
                work_order_items: [
                    {
                        name: '',
                        has_media: 0,
                    }
                ],
            },
            user_assignees: [],
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
                date: [
                    {
                        required: true,
                        trigger: ['blur' , 'change'],
                        message: 'Date is required'
                    },
                ],
                assignees: [
                    {
                        required: true,
                        trigger: ['blur' , 'change'],
                        message: 'Assignees is required'
                    },
                ],
                location_id: [
                    {
                        required: true,
                        trigger: ['blur' , 'change'],
                        message: 'Location is required'
                    },
                ],
            }
        }
    },

    computed: {
         ...mapState({
            priorities: (state) => state.Priority.priorities,
            task_categories: (state) => state.TaskCategory.task_categories,
            locations: (state) => state.Location.locations,
            locationInstallations: (state) => state.LocationInstallation.locationInstallations.map((item) => {
                return {
                    name: item.name,
                    value: item.id + ':' + item.type_relation,
                };
            }),
        }),

    },

    methods: {
        ...mapActions(['fetchUsers']),
        openDialog() {
            this.show = true;
        },

        closeDialog() {
            this.show = false;
        },

        submitWorkorderForm(){

            this.$refs["workorderForm"].validate((valid) => {
                let fields = this.$refs["workorderForm"].fields;
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
            let formData = {...this.work_order};
            formData.assignees = this.work_order.assignees.map((item) => {
                let data = {}
                data.user_id = item;
                if(this.work_order.hasOwnProperty('id')){
                    data.work_order_id = this.work_order.id;
                }

                return data;
            })
            
            if (typeof this.work_order.id != "undefined") {
                return axios.put(route('api.work-order.update' , {
                    work_order: this.work_order.id
                }) , formData);
            }
            return axios.post(route('api.work-order.store') , formData);
        },

        setForm(work_order) {
            let data = {...work_order};

            data.work_order_attachments = work_order.work_order_attachments.map((item) => { 
                return item.attach_id + ':' + item.attach_type
            });
            this.work_order = {...this.work_order, ...data};
            this.work_order.assignees = work_order.assignees.map((item) => item.user_id);
        },

        resetForm() {
            this.work_order = {
                name: '',
                description: '',
                task_category_id: '',
                priority_id: '',
                fill_history_pompa: 0,
                work_order_attachments: [],
                work_order_items: [
                    {
                        name: '',
                        has_media: 0,
                    }
                ],
            };
        },

        templateUsed(task) {
            let workorder = {...task};

            console.log(workorder);
            delete workorder.work_order_items
            delete workorder.id

            workorder.work_order_items = task.task_items.map((item) => {
                delete  item.id;
                return item;
            });

            workorder.work_order_attachments = task.task_attachments.map((item) => item.attach_id + ':' + item.attach_type);

            this.work_order = {...this.work_order, ...workorder};
        }
        
    },

    mounted() {
       this.$nextTick().then(() => {
            this.$store.dispatch('fetchLocationInstallations' , {
                status: 'active',
            })
            this.$store.dispatch('fetchUsers', {relations: 'roles',}).then((response) => {

                let users = response.data.data;
            
                let role_mapping = users.map((user) => {
                    user.roles = user.roles[0];
                    return user
                })
                let grouped = _.groupBy( role_mapping , 'roles.name');

                let mapping = Object.keys(grouped).map((type) => {
                    return {
                        name: type,
                        data : grouped[type]
                    };
                });

                this.user_assignees = mapping;
            });
       })
    }
}
</script>