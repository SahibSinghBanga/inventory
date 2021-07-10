require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'

import { routes } from './routes';
Vue.use(VueRouter)

import User from './Helpers/User';
window.User = User;

const router = new VueRouter({
  routes,
  mode: 'history'
})

const app = new Vue({
    el: '#app',
    router
});
