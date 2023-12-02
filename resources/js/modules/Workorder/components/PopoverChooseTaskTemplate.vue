<template>
    <el-popover
        placement="bottom"
        title="Choose Template"
        width="300"
        trigger="click"
        v-model="visible">

        <el-form :model="form" :rules="rules" ref="taskForm" label-width="120px" label-position="top" class="demo-ruleForm">
            <el-form-item  prop="task_id" label="Template">
                <el-select class="w-100" v-model="form.task_id" placeholder="search task..">
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

            <el-button style="float: right" size="mini" type="primary" @click="submitTemplate">Use</el-button>
        </el-form>
        <el-button type="primary" plain size="mini" icon="el-icon-notebook-2" slot="reference">Use Template</el-button>
    </el-popover>
</template>

<script>

import { mapState  } from "vuex";
import PriorityComponent from './PriorityComponent.vue';

export default {
    components: {
        PriorityComponent,
    },
    data() {
        return {
            visible: false,
            form: {
                task_id: null,
            },
            rules: {
                task_id: null
            }
        }
    },

    methods: {
        submitTemplate(){
            this.$refs["taskForm"].validate((valid) => {
                let fields = this.$refs["taskForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.visible = false;
                    const task = this.tasks.find((item) => item.id == this.form.task_id);
                    this.$emit('handleTempalteUse' , task);
                }
            })
        }
    },

    computed:{
         ...mapState({
            tasks: (state) => state.Task.tasks,
        })
    },

    mounted() {
    }
}
</script>