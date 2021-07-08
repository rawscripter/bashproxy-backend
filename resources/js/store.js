let user = JSON.parse(window.localStorage.getItem('user'));
let proxy = window.localStorage.getItem('proxy') ?? [];
let proxyTextVersion = window.localStorage.getItem('proxyTextVersion') ?? '';
import {SITE_BASE_URL} from "./Api";

let store = {
    state: {
        isLoading: false,
        isLoggedIn: user !== null,
        user: user,
        proxy: proxy.length > 0 ? proxy.split(',') : proxy,
        proxyTextVersion: proxyTextVersion,
        proxyUser: {
            user_id: null,
            totalPackage: 0,
            usedPackage: 0,
            remainingPackage: 0
        }
    },
    mutations: {
        LOGIN_OR_REGISTER_USER(state, user) {
            axios.post(`${SITE_BASE_URL}/api/discord/callback`, user)
                .then(res => {
                    this.isLoggedIn = true;
                    state.user = user;
                    state.user.role = res.data.role;
                    window.localStorage.setItem('user', JSON.stringify(user));

                    if (res.data.role === 'customer') {
                        window.location = '/dashboard';
                    }
                    if (res.data.role === 'admin') {
                        window.location = '/admin/dashboard';
                    }

                }).catch(err => {
            })
        },
        LOGIN_SUCCESS(state, response) {
            state.token = response.access_token;
            state.isLoggedIn = true;
            window.localStorage.setItem('token', JSON.stringify(response.access_token));

        },
        SET_PROXY_USER(state, user) {
            let userObj = user.split(',');
            state.proxyUser.user_id = userObj[0];
            state.proxyUser.remainingPackage = parseInt(userObj[1]);
            state.proxyUser.totalPackage = parseInt(userObj[2]);
            state.proxyUser.usedPackage = parseInt(userObj[3]);
        },
        SET_USER_PROXY(state, proxy) {
            state.proxy = proxy;
            window.localStorage.setItem('proxy', proxy);
        },
        SET_USER_PROXY_TEXT_VERSION(state, proxy) {
            state.proxyTextVersion = proxy;
            window.localStorage.setItem('proxyTextVersion', proxy);
        },
        USER_LOGOUT(state) {
            state.isLoggedIn = false;
            state.token = null;
            state.user = null;
            state.proxy = [];
            state.proxyUser.user_id = null;
            state.proxyUser.totalPackage = 0;
            state.proxyUser.remainingPackage = 0;
            state.proxyUser.usedPackage = 0;

            window.localStorage.removeItem('proxyTextVersion');
            window.localStorage.removeItem('proxy');
            window.localStorage.removeItem('user');
            window.localStorage.removeItem('token');

            window.location.reload();
        }
    },
    getters: {}

}
export default store;
