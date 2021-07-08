<template>
    <div>
        <br>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-muted font-weight-bolder text-left mt-3 mb-3"><strong>Customer List
                ({{ customers.length }})</strong></h5>
            <div id="searchbox">
                <input type="text" v-model="searchCustomer" placeholder="Search Here" class="search">
            </div>
        </div>
        <div class="midel-wraper">
            <!-- <h3 class="text-center">No Results</h3> -->
            <!-- table  -->

            <div class="table-responsive custom-table-responsive">
                <table class="table custom-table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Discord ID</th>
                        <th scope="col">Total Orders</th>
                        <th scope="col">Joined At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr scope="row" v-for="(user) in pageOfItems" :key="user.id">
                        <td>
                            {{ user.id }}
                        </td>
                        <td>
                            {{ user.username }}
                        </td>
                        <td>
                            {{ user.email }}
                        </td>
                        <td>
                            {{ user.discord_id }}
                        </td>
                        <td>
                            {{ user.total_orders }}
                        </td>
                        <td>
                            {{ user.created_at }}
                        </td>
                    </tr>

                    <tr v-if="pageOfItems.length < 1" style="border: none !important;">
                        <td style="text-align: center" colspan="6">
                            No Data Found
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <jw-pagination :pageSize="10" :items="customerList" @changePage="onChangePage"></jw-pagination>

            <!-- Table  -->
        </div>
    </div>
</template>

<script>

import JwPagination from 'jw-vue-pagination';

export default {
    name: "CustomersTable",
    props: ['customers'],
    components: {
        JwPagination,
    },
    data() {
        return {
            pageOfItems: [],
            searchCustomer: ''
        }
    },
    computed: {
        customerList() {
            return this.customers;
        }
    },
    watch: {
        'searchCustomer'(val) {
            this.$emit('searchCustomer', val);
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
