require('./bootstrap');

import Vue from 'vue/dist/vue.js'
//import 'app.css';


import input from 'bootstrap-vue/src/components/form-input';
import form from 'bootstrap-vue/src/components/form';
import button from 'bootstrap-vue/src/components/button';
import alert2 from 'bootstrap-vue/src/components/alert';
import table from 'bootstrap-vue/src/components/table';
import navbar from 'bootstrap-vue/src/components/dropdown';
import dropdown from 'bootstrap-vue/src/components/navbar';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';


Vue.use(form)
Vue.use(button)
Vue.use(alert2)
Vue.use(input)
Vue.use(table)
Vue.use(dropdown)
Vue.use(navbar)

import index from './components/App.vue';

export default new Vue({
    el: '#app',
    render: h => h(index)    
});




//index.$mount('#app');