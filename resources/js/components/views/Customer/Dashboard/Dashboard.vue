<template>
    <div class="container-fluid m-0 p-0">
      <div id="spinner" v-if="this.$store.state.isLoading">
        <atom-spinner
            :animation-duration="1000"
            :size="60"
            color="#fff"
        />
      </div>
        <div class="row m-0 ">
            <Sidebar></Sidebar>
            <div class="col-md-10">
                <DashboardTopHeader :userData="userData"></DashboardTopHeader>
                <div class="row">
                    <PoxyTable></PoxyTable>
                    <PoxyRemainingChart :userData="userData"></PoxyRemainingChart>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
const axios = require('axios').default;
const qs = require('qs');
import 'bootstrap/dist/css/bootstrap.css'
import './dashboard.css';
import Sidebar from "../layouts/Sidebar";
import DashboardTopHeader from "./parts/DashboardTopHeader";
import PoxyTable from "./parts/PoxyTable";
import PoxyRemainingChart from "./parts/PoxyRemainingChart";
import {PROXY_SERVER_TOKEN, PROXY_SERVER_ALL_USERS} from "../../../../Api";
import {AtomSpinner} from 'epic-spinners'

export default {
    name: "Dashboard",
    data() {
        return {
            userData: {
                userId: null,
                totalPackage: 0,
                usedPackage: 0,
                remainingPackage: 0
            },
        }
    },
    components: {
        Sidebar, DashboardTopHeader, PoxyTable, PoxyRemainingChart, AtomSpinner
    },
    created() {
        this.$store.state.isLoading = true;
    },
    methods: {
        getUserFromBashPoxy() {
            const headers = {
                'Authorization': PROXY_SERVER_TOKEN
            }
            axios.get(PROXY_SERVER_ALL_USERS, {headers}).then(res => {
                let userArray = res.data.split("\n");
                let userID = this.$store.state.user.id;
                let userID = "874752536974872647";
                let userIndex = userArray.findIndex(user => {
                    return user.includes(userID)
                })
                if (userIndex !== -1) {
                    let userObj = userArray[userIndex];
                    this.$store.commit('SET_PROXY_USER', userObj);
                    userObj = userObj.split(',');
                    this.userData.remainingPackage = userObj[1];
                    this.userData.totalPackage = userObj[2];
                    this.userData.usedPackage = userObj[3];
                }
                this.$store.state.isLoading = false;
            }).catch(err => {
              this.$toast.error('Something Went Wrong. Please Login Again');
              let _this = this;
              setTimeout(function () {
                _this.$store.commit('USER_LOGOUT');
              }, 5000);
              console.log(err)
            })
        }
    },
    mounted() {
        if (this.$store.state.proxyUser.user_id) {
            this.userData = this.$store.state.proxyUser;
            this.$store.state.isLoading = false;
        } else {
            this.getUserFromBashPoxy();
        }
        let _this = this;

        if (!this.$store.state.isLoggedIn) {
            this.$store.commit('USER_LOGOUT');
        }

        // refresh data in every 1 min
        setTimeout(function () {
            setInterval(function () {
                _this.getUserFromBashPoxy();
            }, 1000 * 60);
        }, 1000 * 60);
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
    display: grid;
    align-items: center;
    text-align: center;
    justify-content: center;
    z-index: 9999 !important;
    height: 100vh;
}

</style>
