<template>
    <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar"
    >
        <div
            class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none"
        >
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div
            class="navbar-nav-right d-flex align-items-center"
            id="navbar-collapse"
        >
            <slot name="navbar-right">
                
            </slot>
            <!-- Search -->
            <!-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Search..."
                        aria-label="Search..."
                    />
                </div>
            </div> -->
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <!-- <li class="nav-item lh-1 me-3">
                    <a
                        class="github-button"
                        href="https://github.com/themeselection/sneat-html-admin-template-free"
                        data-icon="octicon-star"
                        data-size="large"
                        data-show-count="true"
                        aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                        >Star</a
                    >
                </li> -->

                <li>{{ user.name }}</li>
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a
                        class="nav-link dropdown-toggle hide-arrow"
                        href="javascript:void(0);"
                        data-bs-toggle="dropdown"
                    >
                        <div class="avatar avatar-online">
                            <img
                                :src="user.default_profile"
                                alt
                                class="w-px-40 h-auto rounded-circle"
                            />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img
                                                :src="user.default_profile"
                                                alt
                                                class="w-px-40 h-auto rounded-circle"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ user.name }}</span>
                                        <small class="text-muted" style="text-transform: capitalize;">{{ user.roles[0].name }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <span
                                    class="d-flex align-items-center align-middle"
                                >
                                    <i
                                        class="flex-shrink-0 bx bx-credit-card me-2"
                                    ></i>
                                    <span class="flex-grow-1 align-middle"
                                        >Billing</span
                                    >
                                    <span
                                        class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20"
                                        >4</span
                                    >
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a
                                class="dropdown-item"
                                href="#"
                                @click.prevent="dialogLogout"
                            >
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
</template>
<script>
import MainData from "../mixin/MainData";

export default {
    mixins:[
        MainData,
    ],
    methods: {
        logout() {
            axios
                .post(
                    route("logout"),
                    {},
                    {
                        headers: {
                            Accept: "application/json", //the token is a variable which holds the token
                        },
                    }
                )
                .then((response) => {
                    window.location.href = response.data.redirect;
                });
        },

        dialogLogout() {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal',
                type: 'warning'
            }).then(() => {
                this.logout();
            }).catch(() => {    
            });
        },

        handlePreviewWebsite() {
            window.open(this.$url, "_blank");
        },
    },
};
</script>
