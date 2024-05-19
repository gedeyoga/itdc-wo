<template>
    <div class="detail-work-order">
        <el-descriptions class="margin-top"  :column="1" size="small" border>
            <template slot="title">
                <div class="d-flex justify-content-around">
                    <span style="margin-right: 15px;">{{ workorder.name }}</span> 
                    <priority-component v-if="workorder.priority" :status="workorder.priority.name.toLowerCase()"></priority-component>
                </div>
            </template>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-user"></i>
                    Assignee
                </template>
                <el-tag
                    v-for="assignee in workorder.assignees"
                    :key="assignee.user_id"
                    type="primary"
                    style="margin-right: 8px;"
                    effect="plain">
                    <div class="d-flex align-items-center">
                        <el-avatar style="margin-right: 7px;" class="mr-3" :size="20" :src="assignee.user.default_profile" :shape="'circle'"></el-avatar>
                        <span>{{ assignee.user.name }}</span>
                    </div>
                </el-tag>
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-medal"></i>
                    Status
                </template>
                <status-component :status="workorder.status"></status-component>
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-date"></i>
                    Date
                </template>
                {{ workorder.date | formatDateTime }}
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-price-tag"></i>
                    Category
                </template>
                {{ workorder.task_category.name }}
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-location"></i>
                    Location
                </template>
                {{ workorder.location.name }}
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-user"></i>
                    Start
                </template>
                <div class="d-flex align-items-center" v-if="workorder.user_started">
                    <span>{{ workorder.start_at | formatDateTime }}</span>
                    <el-tag
                        type="primary"
                        style="margin-left: 8px;"
                        effect="plain">
                        <div class="d-flex align-items-center">
                            <el-avatar style="margin-right: 7px;" class="mr-3" :size="20" :src="workorder.user_started.default_profile" :shape="'circle'"></el-avatar>
                            <span>{{ workorder.user_started.name }}</span>
                        </div>
                    </el-tag>
                </div>
                <span v-else>-</span>
            </el-descriptions-item>
            <el-descriptions-item :labelStyle="{
                'width': '170px',
            }">
                <template  slot="label">
                    <i class="el-icon-user"></i>
                    Finish
                </template>
                <div class="d-flex align-items-center" v-if="workorder.user_finished">
                    <span>{{ workorder.finish_at | formatDateTime }}</span>
                    <el-tag
                        type="primary"
                        style="margin-left: 8px;"
                        effect="plain">
                        <div class="d-flex align-items-center">
                            <el-avatar style="margin-right: 7px;" class="mr-3" :size="20" :src="workorder.user_finished.default_profile" :shape="'circle'"></el-avatar>
                            <span>{{ workorder.user_finished.name }}</span>
                        </div>
                    </el-tag>
                </div>
                <span v-else>-</span>
            </el-descriptions-item>
        </el-descriptions>

        <el-tabs type="border-card" class="mt-5">
            <el-tab-pane label="Subtasks">
                <el-form :model="workorder_form" ref="workorderForm" class="demo-ruleForm">
                    <ul style="list-style: none; padding-left: 0;" >
                        <li class="border-bottom p-3 d-flex align-items-center justify-content-between" v-for="(item, key) in workorder_form.work_order_items" :key="key">
                            <div>
                                <el-form-item 
                                    v-if="workorder_form.status != 'pending'" 
                                    class="d-inline-block mb-0 mr-3" 
                                    :prop="'work_order_items.' + key + '.status'" 
                                    :rules="[
                                        {
                                            required: true,
                                            trigger: ['change', 'blur']
                                        },
                                        {
                                            validator: taskCompletedRule,
                                            trigger: ['change']
                                        }
                                    ]">
                                    <el-checkbox 
                                        :disabled="workorder_form.status == 'finish'" 
                                        size="medium" v-model="item.status" 
                                        true-label="finish" 
                                        false-label="progress"
                                        @change="(val) => {
                                            item.status = val
                                            updateTask(item)
                                        }">
                                    </el-checkbox>
                                    <span slot="error"><i class="el-icon-warning text-danger"></i></span>
                                </el-form-item>
                                <span style="margin-left: 15px;">{{ item.name }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <el-image
                                    v-if="item.media"
                                    class="d-flex align-items-center"
                                    style="width: 50px; height: 50px; margin-right: 15px;"
                                    :src="item.media.original_url"
                                    :preview-src-list="[item.media.original_url]"
                                    fit="fill">
                                    <div slot="error" class="image-slot">
                                        <i class="el-icon-picture-outline" style="font-size: 40px;"></i>
                                    </div>
                                </el-image>
                                <el-button 
                                    v-if="item.has_media == 1 && workorder_form.status == 'progress'" 
                                    icon="el-icon-picture-outline" 
                                    size="small" 
                                    type="primary"
                                    @click="$refs['uploadMediaWoRef'].openDialog(item)" 
                                    plain>
                                    Upload Image
                                </el-button>
                            </div>
                        </li>
                    </ul>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="History">
                <ul style="list-style: none; padding-left: 0;" >
                    <li class="border-bottom p-3 d-flex align-items-center" v-for="(item, key) in workorder_form.work_order_logs" :key="key">
                        <el-avatar :size="'small'" :src="item.user_created.default_profile"></el-avatar>
                        <div class="d-flex flex-column" style="margin-left: 15px;">
                            <span> <b>{{ item.user_created.name }}</b> {{ item.log }}</span>
                            <small><i>{{ item.created_at | formatDateTime}}</i></small>
                        </div>
                    </li>
                </ul>
            </el-tab-pane>
        </el-tabs>

        
        <div class="mt-5" v-if="workorder.work_order_attachments.length > 0">
            <h5>Attachments</h5>

            <div class="row">
                <div class="col-lg-6" v-for="(attachment, index) in workorder.work_order_attachments" :key="index">
                    <component 
                        :ref="'attachment-'+ index" 
                        :is="buildComponentAttachment(attachment)" 
                        :attachment="attachment" 
                        :key="index"
                        :canFill="workorder.status != 'finish' && workorder.status != 'pending'  "
                    ></component>
                </div>
            </div>

        </div>

        <upload-media-workorder-item 
            ref="uploadMediaWoRef"
            @uploadSuccess="uploadMediaSuccess"
        ></upload-media-workorder-item>
    </div>
</template>

<script>
import PriorityComponent from './PriorityComponent.vue'
import StatusComponent from './StatusComponent.vue'
import UploadMediaWorkorderItem from './UploadMediaWorkorderItem.vue'

export default {
    props: ['workorder'],
    components:{
        PriorityComponent,
        StatusComponent,
        UploadMediaWorkorderItem,
        'location-installation-attachment' : () => import("../../LocationInstallation/components/LocationInstallationAttachment.vue"),
    },
    data() {
        return {
            workorder_form: {},
        }
    },

    watch: {
        workorder: function(val) {
            this.workorder_form = {...this.workorder_form , ...val};
        }
    },

    methods: {
        updateTask(item) {
            const form = item;

            this.$emit('subtaskUpdating', true);
            axios
                .post(route('api.work-order.update-item', {work_order: this.workorder.id}), form)
                .then((response) => {
                    this.$emit('subtaskUpdating', false);
                })
                .catch((err) => {
                    this.$emit('subtaskUpdating', false);
                });
        },

        validate(callback){

            this.$refs["workorderForm"].validate(async (valid) => {
                let fields = this.$refs["workorderForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }

                    const prop = fields[i].prop.split('.');

                    if(prop.length > 1) {
                        if(this.workorder_form[prop[0]][prop[1]].has_media == 1) {
                            if(this.workorder_form[prop[0]][prop[1]].media == undefined || this.workorder_form[prop[0]][prop[1]].media == null) {
                                this.$refs['uploadMediaWoRef'].openDialog(this.workorder_form[prop[0]][prop[1]]);
                                return false;
                            }
                        }
                    }
                }

                let validateAttachment = [];

                await this.workorder_form.work_order_attachments.forEach(async (item , index) => {
                    let data = await this.$refs['attachment-'+index][0].validateForm();
                    validateAttachment.push(data ? 'valid' : 'not-valid');
                })

                if (valid && validateAttachment.filter((v) => v == 'valid').length == this.workorder_form.work_order_attachments.length) {
                    callback(valid);
                }
            })

        },

        uploadMediaSuccess(wo_item) {
            let workorder = {...this.workorder_form};
            let index = workorder.work_order_items.findIndex((item) => item.id == wo_item.id);
            workorder.work_order_items[index] = wo_item;

            this.$emit('update:workorder' , workorder);
        },

        taskCompletedRule(rule, value, callback) {
            if (value === 'progress') {
                callback(new Error('Please input the password'));
            } 
            callback();
        },

        buildComponentAttachment(attachment) {
            return attachment.attach_type.replace('_' , '-') + '-attachment';
        }
    },

    mounted() {
        this.workorder_form = {...this.workorder_form , ...this.workorder};
    }
}
</script>

<style>
.detail-work-order .el-checkbox__inner{
    padding: 10px;
    margin: 4px;
}
.detail-work-order .el-checkbox__inner::after{
    margin: 4px;
}
</style>