import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from "../components/views/Login";
import DiscordCallback from "../components/views/DiscordCallback";
import Dashboard from "../components/views/Customer/Dashboard/Dashboard";
import store from "../store";
import Topup from "../components/views/Customer/Topup/Topup";
import AdminDashboard from "../components/views/Admin/Dashboard/AdminDashboard";
import AdminCustomers from "../components/views/Admin/Dashboard/AdminCustomers";
import AdminOrders from "../components/views/Admin/Dashboard/AdminOrders";

Vue.use(VueRouter);
const routes = [
    {
        path: '/',
        component: Dashboard,
        meta: {
            requireAuth: true,
            requireAdmin: false,
        }
    }, {
        path: '/dashboard',
        component: Dashboard,
        meta: {
            requireAuth: true,
            requireAdmin: false,
        }
    },
    {
        path: '/top-up',
        component: Topup,
        meta: {
            requireAuth: true,
            requireAdmin: false,
        }
    },
    {
        path: '/admin/dashboard',
        component: AdminDashboard,
        meta: {
            requireAuth: true,
            requireAdmin: true,
        }
    }, {
        path: '/admin/customers',
        component: AdminCustomers,
        meta: {
            requireAuth: true,
            requireAdmin: true,
        }
    }, {
        path: '/admin/orders',
        component: AdminOrders,
        meta: {
            requireAuth: true,
            requireAdmin: true,
        }
    },
    {
        path: '/login',
        component: Login,
        meta: {
            requireAuth: false,
        }
    },
    {
        path: '/discord/callback',
        component: DiscordCallback,
        meta: {
            requireAuth: false,
        }
    },

];
const router = new VueRouter({
    routes,
    mode: 'history',
    hashbang: true
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requireAuth) && !to.matched.some(record => record.meta.requireAdmin)) {
        if (store.state.isLoggedIn && store.state.user.role === 'customer') {
            next();
        } else if (store.state.isLoggedIn && store.state.user.role === 'admin') {
            next({
                path: '/admin/dashboard',
            })
        } else {
            next({
                path: '/login',
            });
        }
    } else if (to.matched.some(record => record.meta.requireAuth) && to.matched.some(record => record.meta.requireAdmin)) {
        if (store.state.isLoggedIn && store.state.user.role === 'admin') {
            next();
        } else if (store.state.isLoggedIn && store.state.user.role === 'v') {
            next({
                path: '/dashboard',
            })
        } else {
            next({
                path: '/login',
            })
        }
    } else {
        next();
    }
})

export default router;

