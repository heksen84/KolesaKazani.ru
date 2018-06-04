require('./bootstrap');

import Vue from 'vue';
import welcome from './views/welcome.vue';
import home from './views/home.vue';
import profile from './views/profile.vue';
import search from './views/search.vue';
import results from './views/results.vue';
import create from './views/create.vue';
import passwordreset from './views/auth/passwordreset.vue';
import login from './views/auth/login.vue';
import register from './views/auth/register.vue';


// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';
import layout from 'bootstrap-vue/src/components/layout';
import form from 'bootstrap-vue/src/components/form';
import form_input from 'bootstrap-vue/src/components/form-input';
import form_group from 'bootstrap-vue/src/components/form-group';
import form_textarea from 'bootstrap-vue/src/components/form-textarea';
import form_checkbox from 'bootstrap-vue/src/components/form-checkbox';
import form_select from 'bootstrap-vue/src/components/form-select';
import button from 'bootstrap-vue/src/components/button';
import carousel from 'bootstrap-vue/src/components/carousel';
import table from 'bootstrap-vue/src/components/table';
import link from 'bootstrap-vue/src/components/link';

Vue.use(layout);
Vue.use(form);
Vue.use(form_input);
Vue.use(form_group);
Vue.use(form_checkbox);
Vue.use(form_textarea);
Vue.use(form_select);
Vue.use(button);
Vue.use(carousel);
Vue.use(table);
Vue.use(link);

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
      register,
      search,
      results,
      create
  }
});
