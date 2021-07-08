<template>
    <div>
        <br>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-muted font-weight-bolder text-left mt-3 mb-3"><strong>Orders List
                ({{ orderList.length }})</strong></h5>
            <div id="searchbox">
                <input type="text" v-model="searchOrder" placeholder="Search Here" class="search">
            </div>
        </div>
        <div class="midel-wraper">
            <!-- <h3 class="text-center">No Results</h3> -->
            <!-- table  -->

            <div class="table-responsive custom-table-responsive">
                <table class="table custom-table">
                    <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">User</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Quota</th>
                        <th scope="col">Discord Code</th>
                        <th scope="col">Discord Amount</th>
                        <th scope="col">Paid Status</th>
                        <th scope="col">Paid Amount</th>
                        <th scope="col">Purchased At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr scope="row" v-for="(order) in pageOfItems" :key="order.id">
                        <td>
                            {{ order.id }}
                        </td>
                        <td>
                            <span class="d-block">{{ order.user.email }}</span>
                            <small class="d-block">Discord ID: {{ order.user.discord_id }}</small>
                            <small class="d-block">Username: {{ order.user.name }}</small>
                        </td>
                        <td>
                            {{ order.product_price / 100 }} {{ order.currency.toUpperCase() }}
                        </td>
                        <td>
                            {{ order.quantity / 1000 }}GB
                        </td>
                        <td>
                            {{ order.discount_code }}
                        </td>
                        <td>
                            {{ order.discount_amount / 100 }} {{ order.currency.toUpperCase() }}
                        </td>
                        <td>
                            {{ order.is_paid ? 'PAID' : "UNPAID" }}
                        </td>

                        <td>
                            {{ order.paid_amount / 100 }} {{ order.currency.toUpperCase() }}
                        </td>
                        <td>
                            {{ order.created_at }}
                        </td>
                    </tr>

                    <tr v-if="pageOfItems.length < 1" style="border: none !important;">
                        <td style="text-align: center" colspan="9">
                            No Data Found
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <jw-pagination :pageSize="10" :items="orderList" @changePage="onChangePage"></jw-pagination>

            <!-- Table  -->
        </div>
    </div>
</template>

<script>

import JwPagination from 'jw-vue-pagination';

export default {
    name: "OrdersTable",
    props: ['orders'],
    components: {
        JwPagination,
    },
    data() {
        return {
            pageOfItems: [],
            searchOrder: ''
        }
    },
    computed: {
        orderList() {
            return this.orders;
        }
    },
    watch: {
        'searchOrder'(val) {
            this.$emit('searchOrder', val);
        }
    },
    methods: {
        onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
    },
}
</script>

<style>
table, td, tr {
    text-align: left;
}

li.page-item.page-number.active a {
    color: #29292b !important;
    background: white !important;
}

.custom-cursor {
    cursor: copy;
}

.midel-wraper {
    background-color: #29292B;
    padding: 10px;
    min-height: 445px;
}

.border-0 {
    border: none !important;
}


input.search {
    padding: 5px;
    width: 300px;
    background: transparent;
    border: 1px solid #878787;
    border-radius: 4px;
    color: #ccc;
    font-weight: normal;
}

</style>
