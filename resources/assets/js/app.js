require('./bootstrap');

import 'bootstrap/dist/css/bootstrap-grid.min.css'

import Vue from 'vue'
import layout from 'bootstrap-vue/src/components/layout'
import welcome from './views/welcome.vue'
import home from './views/home.vue'
import profile from './views/profile.vue'
import passwordreset from './views/auth/passwordreset.vue'
import login from './views/auth/login.vue'
import register from './views/auth/register.vue'



Vue.use(layout);

const app = new Vue({
    el: '#app',
    data: () => ({
    }),
    components: {
      welcome,
      profile,
      home,
      passwordreset,
      login,
      register }
});
