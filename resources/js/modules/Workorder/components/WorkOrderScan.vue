<template>
    <div>
        <detail-task v-loading="loading" :task="task"></detail-task>
    </div>
</template>
<script>

import { mapState } from "vuex";
import DetailTask from '../../Task/components/DetailTask.vue';

export default {
    components:{
        DetailTask
    },

    data(){
        return {
            loading: false,
        }
    },
    computed: {
        ...mapState({
            task: (state) => state.Task.task,
        }),
    },
    async mounted() {
        this.loading = true;
        await this.$store.dispatch('findTask' , this.$route.query.task_id)

        this.loading = false;

        console.log(this.task);
    }
}
</script>