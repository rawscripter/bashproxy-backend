<template>
    <div class="col-md-2 m-0 p-0">
        <!-- Sidebar  -->
        <nav class="menu" tabindex="0">
            <div class="smartphone-menu-trigger"></div>
            <h3 class="text-white mt-5 font-weight-bolder">BASHPROXY</h3>
            <ul>
                <!--        <router-link tag="li" to="/dashboard" tabindex="0" class="icon-customers"><i-->
                <!--            class="fa fa-database"></i><span>Premium ISP</span>-->
                <!--        </router-link>-->
                <router-link to="/dashboard" tag="li" tabindex="0" class="icon-customers "><i
                    class="fa fa-home"></i><span>Residential</span>
                </router-link>

                <router-link to="/top-up" tag="li" tabindex="0" class="icon-customers "><i
                    class="fa fa-home"></i><span>Top Up</span>
                </router-link>
                <li @click="logout" tabindex="0" class="icon-customers"><i class="fa fa-user"></i><span>Log Out</span>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    methods: {
        logout() {
            this.$store.commit('USER_LOGOUT');
        },
    }
}
</script>

<style scoped>

</style>
