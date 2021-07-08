<template>
  <div>
    <br>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="text-muted font-weight-bolder text-left mt-3 mb-3"><strong>Dashboard Summery</strong></h5>
    </div>
    <div class="row">
      <!--            <div class="col-md-4 single-card">-->
      <!--                Total Orders-->
      <!--            </div>-->

      <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-dark">
          <div class="inner">
            <h3 class="text-center"> {{ summery.total_customers }} </h3>
            <p class="text-muted"> Total Customers </p>
          </div>
          <div class="icon">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
          </div>
          <router-link to="/admin/customers" href="#" class="card-box-footer">View More <i
              class="fa fa-arrow-circle-right"></i></router-link>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-dark">
          <div class="inner">
            <h3 class="text-center"> {{ summery.recent_orders }} </h3>
            <p class="text-muted"> Orders In Last 30 Days </p>
          </div>
          <div class="icon">
            <i class="fa fa-money" aria-hidden="true"></i>
          </div>
          <router-link to="/admin/orders" class="card-box-footer">View More <i
              class="fa fa-arrow-circle-right"></i></router-link>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-dark">
          <div class="inner">
            <h3 class="text-center"> ${{ summery.recent_sales }} </h3>
            <p class="text-muted"> Sales In Last 30 Days </p>
          </div>
          <div class="icon">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
          </div>
          <router-link to="/admin/orders" class="card-box-footer">View More <i
              class="fa fa-arrow-circle-right"></i></router-link>
        </div>
      </div>
    </div>

  </div>
</template>

<script>

import {SITE_BASE_URL} from "../../../../../Api";

export default {
  name: "DashboardSummery",
  props: ['customers'],
  components: {},
  data() {
    return {
      summery: {
        total_customers: 0,
        total_orders: 0,
        recent_orders: 0,
        recent_sales: 0,
      }
    }
  },
  mounted() {
    this.getDashboardSummery();
  },
  watch: {},
  methods: {
    getDashboardSummery() {
      axios.post(`${SITE_BASE_URL}/api/dashboard/summery`, {
        email: this.$store.state.user.email,
      })
          .then(res => {
            this.summery = res.data;
          })
    }
  },
}
</script>

<style>
.card-box {
  position: relative;
  color: #fff;
  padding: 20px 10px 40px;
  margin: 20px 0px;
}

.card-box:hover {
  text-decoration: none;
  color: #f1f1f1;
}

/*.card-box:hover .icon i {*/
/*    font-size: 100px;*/
/*    transition: 1s;*/
/*    -webkit-transition: 1s;*/
/*}*/

.card-box .inner {
  padding: 5px 10px 0 10px;
}

.card-box h3 {
  font-size: 27px;
  font-weight: bold;
  margin: 0 0 8px 0;
  white-space: nowrap;
  padding: 0;
  text-align: left;
}

.card-box p {
  font-size: 15px;
}

.card-box .icon {
  position: absolute;
  top: auto;
  bottom: 5px;
  right: 5px;
  z-index: 0;
  font-size: 72px;
  color: rgba(0, 0, 0, 0.15);
}

.card-box .card-box-footer {
  position: absolute;
  left: 0px;
  bottom: 0px;
  text-align: center;
  padding: 3px 0;
  color: rgba(255, 255, 255, 0.8);
  background: rgba(0, 0, 0, 0.1);
  width: 100%;
  text-decoration: none;
}

.card-box:hover .card-box-footer {
  background: rgba(0, 0, 0, 0.3);
}

.bg-blue {
  background-color: #00c0ef !important;
}

.bg-green {
  background-color: #00a65a !important;
}

.bg-orange {
  background-color: #f39c12 !important;
}

.bg-red {
  background-color: #d9534f !important;
}

.bg-dark {
  background-color: #29292b !important;
  border: 1px solid #35353f;
}
</style>
