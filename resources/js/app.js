

require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import VueRouter from 'vue-router';
import {routes} from './routes';
import vuetify from './plugin/vuetify'
import Index from './components/Index.vue'

Vue.use(VueRouter)


const router = new VueRouter({
    mode:'history',
    routes
})


const app = new Vue({
    el: '#app',
    router,
    vuetify,
    components:{
        'index':Index
    }
});
