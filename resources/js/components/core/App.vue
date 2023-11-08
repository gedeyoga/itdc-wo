<template>
    <div>
        <component :is="component"></component>
    </div>
</template>

<script>
import LayoutFull from "../layouts/LayoutFull.vue";
import LayoutAdmin from "../layouts/LayoutAdmin.vue";

export default {
    components: {
        LayoutFull,
        LayoutAdmin,
    },
    data() {
        return {
            input: null,
        };
    },

    computed: {
        component() {
            if (this.$route.meta) {
                if (this.$route.meta.layout == "full") {
                    return "layout-" + this.$route.meta.layout;
                }
            }
            return "layout-admin";
        },
    },
};
</script>