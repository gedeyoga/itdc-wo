<template>
    <div class="container">
        <navbar>
            <div slot="navbar-right">
                <el-button :loading="loading" type="primary" icon="el-icon-s-home" @click="$router.push({name: 'home'})">Dashboard</el-button>
            </div>
        </navbar>
        <div class="card mx-4 mt-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="detail-task" v-if="task.hasOwnProperty('id')">
                        <el-descriptions class="margin-top"  :column="1" size="small" border>
                            <template slot="title">
                                <h3>{{ task.name }}</h3>
                            </template>
                            <el-descriptions-item :labelStyle="{
                                'width': '170px',
                            }">
                                <template  slot="label">
                                    <i class="el-icon-price-tag"></i>
                                    Priority
                                </template>
                                <priority-component v-if="task.priority" :status="task.priority.name.toLowerCase()"></priority-component>
                            </el-descriptions-item>
                            <el-descriptions-item :labelStyle="{
                                'width': '170px',
                            }">
                                <template  slot="label">
                                    <i class="el-icon-price-tag"></i>
                                    Category
                                </template>
                                {{ task.task_category.name }}
                            </el-descriptions-item>
                            <!-- <el-descriptions-item :labelStyle="{
                                'width': '170px',
                            }">
                                <template  slot="label">
                                    <i class="el-icon-location"></i>
                                    Location
                                </template>
                                {{ task.location.name }}
                            </el-descriptions-item> -->
                        </el-descriptions>

                        <h5 class="mb-3 mt-5">Subtasks</h5>

                        <el-form :model="task_form" ref="taskForm" class="demo-ruleForm">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th width="100px">Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, key) in task_form.task_items" :key="key">
                                        <td>{{ item.name }}</td>
                                        <td>
                                            <i v-if="item.has_media == 1" class="el-icon-success text-success"></i>
                                            <i v-else-if="item.has_media == 0" class="el-icon-error text-danger"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <el-switch
                                class="my-3"
                                v-model="task_form.has_team"
                                active-text="Add staff to this work order"
                                :active-value="1"
                                :inactive-value="0">
                            </el-switch>

                            <el-form-item v-if="task_form.has_team == 1" label="Staffs" prop="assignees">
                                <el-select
                                    class="w-100"
                                    filterable
                                    searchable
                                    clearable
                                    multiple
                                    v-model="task_form.assignees"
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

                            <div class="text-center mt-5">
                                <el-button :loading="loading" class="w-100" type="primary" icon="el-icon-position" @click="onSubmit">Progress Task</el-button>
                            </div>

                            
                        </el-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../../components/core/Navbar.vue'
import PriorityComponent from '../../Workorder/components/PriorityComponent.vue'
import StatusComponent from '../../Workorder/components/StatusComponent.vue'
import MainData from "../../../components/mixin/MainData";
// require("../../../mixins.js");

export default {
    props: ['task'],
    mixins:[
        MainData,
    ],
    components:{
        PriorityComponent,
        StatusComponent,
        Navbar,
    },
    data() {
        return {
            task_form: {
                assignees: [],
            },
            user_assignees: [],
            loading: false,
        }
    },

    watch: {
        task: function(val) {
            this.task_form = {...this.task_form , ...val};
        }
    },

    methods: {
        updateTask(item) {
            const form = item;

            this.$emit('subtaskUpdating', true);
            axios
                .post(route('api.work-order.update-item', {work_order: this.task.id}), form)
                .then((response) => {
                    this.$emit('subtaskUpdating', false);
                })
                .catch((err) => {
                    this.$emit('subtaskUpdating', false);
                });
        },

        validate(callback){
            
            this.$refs["taskForm"].validate((valid) => {
                let fields = this.$refs["taskForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }

                    const prop = fields[i].prop.split('.');

                    if(prop.length > 1) {
                        if(this.task_form[prop[0]][prop[1]].has_media == 1) {
                            if(this.task_form[prop[0]][prop[1]].media == undefined || this.task_form[prop[0]][prop[1]].media == null) {
                                this.$refs['uploadMediaWoRef'].openDialog(this.task_form[prop[0]][prop[1]]);
                                return false;
                            }
                        }
                    }
                }

                if (valid) {
                    callback(valid);
                }
            })

        },

        uploadMediaSuccess(wo_item) {
            let task = {...this.task_form};
            let index = task.task_items.findIndex((item) => item.id == wo_item.id);
            task.task_items[index] = wo_item;

            this.$emit('update:task' , task);
        },

        taskCompletedRule(rule, value, callback) {
            if (value === 'progress') {
                callback(new Error('Please input the password'));
            } 
            callback();
        },

        onSubmit() {
            this.$refs["taskForm"].validate((valid) => {
                let fields = this.$refs["taskForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.$confirm("Are you sure want to progress task?", "Confirmation", {
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        type: "warning",
                    }).then((result) => {
                        this.loading = true;

                        let form = {...this.task_form};
                        form.assignees = this.task_form.assignees.map((id) => {
                            return {
                                user_id: id,
                            }
                        })
                        form.task_items = this.task_form.task_items.map((item) => {
                            delete item.created_at;
                            delete item.updated_at;
                            return item
                        })

                        delete form.barcode;
                        delete form.priority;
                        delete form.task_category;
                        delete form.deleted_at;

                        axios.post(route('api.work-order.progress-task') , form)
                            .then((response) => {
                                this.loading = false;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });

                                this.$router.push({name: 'home'});

                                this.$emit('handleSuccessSubmit' , response.data);
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    })
                }
            })
        }
    },

    mounted() {
        this.task_form = {...this.task_form , ...this.task};

        this.$store.dispatch('fetchUsers', {relations: 'roles',})
        .then((response) => {

            let users = response.data.data.filter((item) => item.id != this.user.id);
        
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
    }
}
</script>

<style>
.detail-task{
    width: 100%;
}
.detail-task .el-checkbox__inner{
    padding: 10px;
    margin: 4px;
}
.detail-task .el-checkbox__inner::after{
    margin: 4px;
}
</style>