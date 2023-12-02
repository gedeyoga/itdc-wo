<template>
    <el-dialog
        class="upload-media-documentation"
        title="Upload Documentation"
        :visible.sync="show"
        width="50%"
        :close-on-click-modal="false"
        :append-to-body="true"
        v-loading="loading">

        <el-alert
            class="mb-3"
            type="info"
            :closable="false"
            show-icon>
            <span slot="title">Please upload a documentation of subtask <b>"{{ this.form.name }}"</b></span>
        </el-alert>

        <el-upload
            class="upload-demo w-100"
            drag
            :action="getUploadApi"
            :on-change="beforeAvatarUpload"
            accept="image/png, image/jpeg, image/gif"
            :auto-upload="false"
            :show-file-list="false"
        >
        <i class="el-icon-upload"></i>
        <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
        <div class="el-upload__tip" slot="tip">jpg/png files with a size less than 500kb</div>
        </el-upload>
    <span slot="footer" class="dialog-footer">
        <el-button :loading="loading" type="primary" @click="closeDialog">close</el-button>
    </span>
    </el-dialog>
</template>

<script>
export default {
    data() {
        return  {
            show: false,
            form: {},
            loading: false,
        }
    },

    computed: {
        getUploadApi()
        {
            if(this.form.hasOwnProperty('id')) {
                return route('api.work-order.update-item', {
                    work_order: this.form.work_order_id,
                });
            }

            return '';
        },
    },

    methods: {
        openDialog(wo_item) {
            this.form = {...this.form , ...wo_item};
            this.form.media = null;

            this.show = true;
        },
        closeDialog() {
            this.form = {}
            this.show = false;
        },

        

        beforeAvatarUpload(file) {
            this.loading = true;

            this.form.media = file.raw;
            const formData = new FormData();
            for (const key in this.form) {
                formData.append(key, this.form[key]);
            }

            axios.post(this.getUploadApi, formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
                this.loading = false;
                this.$notify({
                    title: "Pemberitahuan",
                    message: response.data.message,
                    type: "success",
                });
                this.$emit('uploadSuccess' , response.data.data);
                this.closeDialog();
            })
            .catch((err) => {
                this.loading = false;
            })
        }
    }
}
</script>

<style>
.upload-media-documentation .el-upload{
    width: 100%;
    display: block !important;
}
.upload-media-documentation .el-upload .el-upload-dragger{
    width: 100% !important;
}
</style>