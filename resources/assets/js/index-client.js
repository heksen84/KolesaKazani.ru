require('./bootstrap');

import Vue from 'vue/dist/vue.js'

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';

import input from 'bootstrap-vue/src/components/form-input';
import form from 'bootstrap-vue/src/components/form';
import button from 'bootstrap-vue/src/components/button';
import alert from 'bootstrap-vue/src/components/alert';
import table from 'bootstrap-vue/src/components/table';
import navbar from 'bootstrap-vue/src/components/dropdown';
import dropdown from 'bootstrap-vue/src/components/navbar';

Vue.use(form)
Vue.use(button)
Vue.use(alert)
Vue.use(input)
Vue.use(table)
Vue.use(dropdown)
Vue.use(navbar)

export default new Vue({
    el: '#app'   
});




//index.$mount('#app');