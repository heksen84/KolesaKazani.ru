require('./bootstrap');

import data from './data';
import Vue from 'vue';
import login from './views/auth/login.vue';

// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';
import layout from 'bootstrap-vue/src/components/layout';
import form from 'bootstrap-vue/src/components/form';
import form_input from 'bootstrap-vue/src/components/form-input';
import form_group from 'bootstrap-vue/src/components/form-group';
import form_checkbox from 'bootstrap-vue/src/components/form-checkbox';
import button from 'bootstrap-vue/src/components/button';
import link from 'bootstrap-vue/src/components/link';

Vue.use(layout);
Vue.use(form);
Vue.use(form_input);
Vue.use(form_group);
Vue.use(form_checkbox);
Vue.use(button);
Vue.use(link);

// экземляр приложения vue
export default new Vue({
    el: '#app',
    data: data,
    components: {
      login
  }
});