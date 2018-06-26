require('./bootstrap');

import Vue from 'vue';

// views
import welcome from './views/welcome.vue';
import home from './views/home.vue';
import profile from './views/profile.vue';
import search from './views/search.vue';
import results from './views/results.vue';
import create from './views/create.vue';
import fullinfo from './views/fullinfo.vue';
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
import table from 'bootstrap-vue/src/components/table';
import link from 'bootstrap-vue/src/components/link';
import image from 'bootstrap-vue/src/components/image';

import VueCarousel from 'vue-carousel';

Vue.use(layout);
Vue.use(form);
Vue.use(form_input);
Vue.use(form_group);
Vue.use(form_checkbox);
Vue.use(form_textarea);
Vue.use(form_select);
Vue.use(button);
Vue.use(table);
Vue.use(link);
Vue.use(image);

Vue.use(VueCarousel);

const app = new Vue({
    el: '#app',
    data: () => ({
    
     // dealtype: ["покупка","продажа","обмен","частичный обмен","отдам даром","сдача в аренду"];

      options_sdelka: [
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },
        { value: '3', text: 'Частичный обмен' },
        { value: '4', text: 'Отдам даром' },
        { value: '5', text: 'Сдача в аренду' }
      ],

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
      create,
      fullinfo
  }
});