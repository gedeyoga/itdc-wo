<template>
    <div>
        <!-- <router-view></router-view> -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <side-bar></side-bar>

                <div class="layout-page">
                    <navbar></navbar>

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                           <router-view></router-view>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

require("../../mixins.js");
require("../../components.js");

export default {
    data() {
        return {
            input: null,
        };
    },
};
</script>