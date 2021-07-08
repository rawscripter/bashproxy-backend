<template>
    <div class="container-fluid m-0 p-0">
        <div id="spinner" v-if="this.$store.state.isLoading">
            <atom-spinner
                :animation-duration="1000"
                :size="60"
                color="#fff"
            />
        </div>
        <div class="row">
            <Sidebar></Sidebar>
            <div class="col-md-9 m-auto mt-4">
                <OrdersTable @searchOrder="searchOrder" :orders="orders"></OrdersTable>
            </div>
        </div>
    </div>
</template>
<script>
const axios = require('axios').default;
import 'bootstrap/dist/css/bootstrap.css'
import './adminDashboard.css';
import {AtomSpinner} from 'epic-spinners'
import Sidebar from "./layouts/Sidebar";
import OrdersTable from "./parts/OrdersTable";
import {SITE_BASE_URL} from "../../../../Api";

export default {
    name: "AdminProducts`",
    data() {
        return {
            orders: [],
            searchQuery: ''
        }
    },
    components: {
        Sidebar, AtomSpinner, OrdersTable
    },
    created() {
        this.$store.state.isLoading = true;
    },

    methods: {
        searchOrder(val) {
            this.searchQuery = val;
            this.getAllOrders();
        },
        getAllOrders() {
            axios.post(`${SITE_BASE_URL}/api/admin/orders`, {
                email: this.$store.state.user.email,
                searchData: this.searchQuery
            })
                .then(res => {
                    this.$store.state.isLoading = false;
                    this.orders = res.data.orders;
                    console.log(res.data)
                })
        }
    },
    mounted() {
        this.getAllOrders();
        if (!this.$store.state.isLoggedIn) {
            this.$store.commit('USER_LOGOUT');
        }
    },
}
</script>

<style scoped>
.title {
    margin-top: 50px;
    color: #ccc;
}

div#spinner {
    position: absolute;
    background: #12121247;
    width: 100%;
    height: 100vh;
    display: grid;
    align-items: center;
    text-align: center;
    justify-content: center;
    z-index: 9999 !important;
}

</style>
