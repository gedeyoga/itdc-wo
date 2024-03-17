<template>
    <el-dialog
        :title="task_schedule.hasOwnProperty('id') ? 'Edit Task Schedule' : 'Create Task Schedule'"
        :visible.sync="show"
        width="50%"
    >
    <el-form 
        :model="task_schedule" 
        :rules="rules" 
        ref="task_scheduleForm" 
        label-position="top"         
        class="demo-ruleForm">

        <el-form-item  prop="task_id" label="Task">
            <el-select class="w-100" v-model="task_schedule.task_id" fitlerable clearable placeholder="Choose task..">
                <el-option 
                    v-for=" task in tasks" 
                    :key="task.id" 
                    :value="task.id"
                    :label="task.name"
                >
                    <div class="d-flex">
                        <priority-component :status="task.priority.name.toLowerCase()"></priority-component>
                        <span style="margin-left: 8px;">{{ task.name }}</span>
                    </div>
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item  prop="description" label="Description">
            <el-input type="textarea" rows="2" v-model="task_schedule.description"></el-input>
        </el-form-item>
        <el-form-item  prop="type" label="Type">
            <el-radio-group v-model="task_schedule.type">
                <el-radio-button v-for="type in types" :key="type" :label="type"></el-radio-button>
            </el-radio-group>
        </el-form-item>

        <div class="mb-3" v-if="task_schedule.type == 'daily'">
            <el-table :data="task_schedule.days">
                <el-table-column label="Day" >
                    <template slot-scope="scope">
                        <el-checkbox v-model="scope.row.checked" :label="scope.row.label"></el-checkbox>
                    </template>
                </el-table-column>
                <el-table-column label="Time" >
                    <template slot-scope="scope">
                        <el-time-picker
                            v-if="scope.row.checked"
                            v-model="scope.row.hour"
                            format="HH:mm"
                            value-format="HH:mm"
                            :picker-options="{
                                selectableRange: '00:00:00 - 23:59:00'
                            }"
                            placeholder="Arbitrary time">
                        </el-time-picker>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="mb-3" v-if="task_schedule.type == 'monthly'">
            <el-table :data="task_schedule.months">
                <el-table-column label="Date" >
                    <template slot-scope="scope">
                        <el-select v-model="scope.row.date">
                            <el-option v-for="date in 31" :key="date" :label="date" :value="date"></el-option>
                        </el-select>
                    </template>
                </el-table-column>
                <el-table-column label="Time" >
                    <template slot-scope="scope">
                        <el-time-select
                            v-model="scope.row.hour"
                            placeholder="Select time">
                        </el-time-select>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="mb-3" v-if="task_schedule.type == 'yearly'">
            <el-table :data="task_schedule.years">
                <el-table-column label="Month" >
                    <template slot-scope="scope">
                        <el-select v-model="scope.row.month">
                            <el-option v-for="month in 12" :key="month" :label="month" :value="month"></el-option>
                        </el-select>
                    </template>
                </el-table-column>
                <el-table-column label="Date" >
                    <template slot-scope="scope">
                        <el-select v-model="scope.row.date">
                            <el-option v-for="date in 31" :key="date" :label="date" :value="date"></el-option>
                        </el-select>
                    </template>
                </el-table-column>
                <el-table-column label="Time" >
                    <template slot-scope="scope">
                        <el-time-select
                            v-model="scope.row.hour"
                            placeholder="Select time">
                        </el-time-select>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <el-form-item  prop="status" label="Status">
            <el-switch
                v-model="task_schedule.status"
                active-text="Active"
                active-value="active"
                inactive-value="not-active">
            </el-switch>
        </el-form-item>
        <el-form-item label="Assignee" prop="user_id">
            <el-select
                class="w-100"
                filterable
                searchable
                clearable
                multiple
                v-model="task_schedule.user_id"
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
        
       
    </el-form>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" @click="closeDialog">Cancel</el-button>
        <el-button :loading="loading" type="primary" @click="submitTaskForm()">
            {{ task_schedule.hasOwnProperty('id') ? 'Update Schedule' : 'Create Schedule' }}
        </el-button>
    </span>
    </el-dialog>
</template>

<script>

import PriorityComponent from '../../Workorder/components/PriorityComponent.vue';
import { mapState } from "vuex";

export default {
    components: {
        PriorityComponent,
    },
    data() {
        return {
            show: false,
            loading: false,
            user_assignees: [],
            task_schedule: {
                task_id: '',
                description: '',
                status: '',
                type: '',
                days: [],
                months: [],
                years: [],
            },
            rules: {
                task_id: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Task is required'
                    },
                ],
                description: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Description is required'
                    },
                ],
                status: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Status is required'
                    },
                ],
                type: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Type is required'
                    },
                ],
                user_id: [
                    {
                        required: true,
                        trigger: ['blur'],
                        message: 'Assignee is required'
                    },
                ],
            },

            types: [
                'daily',
                'monthly',
                'yearly'
            ],

            days: [
                {
                    checked:false,
                    label:"Sunday",
                    hour:null,
                    value: 7,
                },
                {
                    checked:false,
                    label:"Monday",
                    hour:null,
                    value: 1,
                },
                {
                    checked:false,
                    label:"Tuesday",
                    hour:null,
                    value: 2,
                },
                {
                    checked:false,
                    label:"Wednesday",
                    hour:null,
                    value: 3,
                },
                {
                    checked:false,
                    label:"Thursday",
                    hour:null,
                    value: 4,
                },
                {
                    checked:false,
                    label:"Friday",
                    hour:null,
                    value: 5,
                },
                {
                    checked:false,
                    label:"Saturday",
                    hour:null,
                    value: 6,
                },
            ],

            months: [
                {
                    date: '',
                    hour: null,
                }
            ],
            years: [
                {
                    date:'',
                    month:'',
                    hour: null,
                }
            ]
        }
    },

    computed: {
         ...mapState({
            priorities: (state) => state.Priority.priorities,
            task_schedule_categories: (state) => state.TaskCategory.task_schedule_categories,
            locations: (state) => state.Location.locations,
            tasks: (state) => state.Task.tasks,
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

            this.$refs["task_scheduleForm"].validate((valid) => {
                let fields = this.$refs["task_scheduleForm"].fields;
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

            let task_schedule = {...this.task_schedule};

            if(this.task_schedule.type == 'daily') {
                task_schedule.items = this.task_schedule.days.filter((item) => item.checked == true).map((item) => {
                    return {
                        day: item.value,
                        hour: item.hour
                    }
                });
            } else if(this.task_schedule.type == 'monthly') {
                task_schedule.items = this.task_schedule.months;
            } else if (this.task_schedule.type == 'yearly') {
                task_schedule.items = this.task_schedule.years;
            }

            delete task_schedule.days;
            delete task_schedule.months;
            delete task_schedule.years;

            if (typeof this.task_schedule.id != "undefined") {
                return axios.put(route('api.task-schedules.update' , {
                    task_schedule: this.task_schedule.id
                }) , task_schedule);
            }
            return axios.post(route('api.task-schedules.store') , task_schedule);
        },

        setForm(task_schedule) {
            this.task_schedule = {...this.task_schedule, ...task_schedule};
            this.task_schedule.days = [...this.days];
            this.task_schedule.months = [...this.months];
            this.task_schedule.years = [...this.years];

            if(Array.isArray(task_schedule.users)) {
                this.task_schedule.user_id = task_schedule.users.map((item) => item.user_id);
            }

            if(this.task_schedule.type == 'daily') {
                this.task_schedule.days = this.days.map((item) => {
                    item.checked = task_schedule.days.map(item => item.day).includes(item.value);
                    if(item.checked) {
                        let time = task_schedule.days.find((i) => i.day == item.value)
                        item.hour = time.hour;
                    }
                    return item;
                });
                this.task_schedule.months = this.months;
                this.task_schedule.years = this.years;
            } else if(this.task_schedule.type == 'monthly') {
                this.task_schedule.days = this.days;
                this.task_schedule.months = task_schedule.months;
                this.task_schedule.years = this.years;
            } else if (this.task_schedule.type == 'yearly') {
                this.task_schedule.days = this.days;
                this.task_schedule.months = this.months;
                this.task_schedule.years = task_schedule.years;
            }
            
        },

        resetForm() {
            this.task_schedule = {
                task_id: '',
                description: '',
                status: '',
                type: '',
                days: [...this.days],
                months: [...this.months],
                years: [...this.years],
            };
        }
        
    },

    mounted() {
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
    }
}
</script>