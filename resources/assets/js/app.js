require('./bootstrap');

import data from './data';
import Vue from 'vue';

// Вьюшки ВьюДжеЭс
import index from './views/index.vue';
import cabinet from './views/cabinet.vue';
import profile from './views/profile.vue';
import search from './views/search.vue';
import results from './views/results.vue';
import create from './views/create.vue';
import fullinfo from './views/fullinfo.vue';
import sendemail from './views/auth/sendemail.vue';
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
import form_file from 'bootstrap-vue/src/components/form-file';
import button from 'bootstrap-vue/src/components/button';
import table from 'bootstrap-vue/src/components/table';
import link from 'bootstrap-vue/src/components/link';
import image from 'bootstrap-vue/src/components/image';
import radio from 'bootstrap-vue/src/components/form-radio';
import navbar from 'bootstrap-vue/src/components/navbar';
import modal from 'bootstrap-vue/src/components/modal';
import alert from 'bootstrap-vue/src/components/alert';
import VueCarousel from 'vue-carousel';

Vue.use(layout);
Vue.use(form);
Vue.use(form_input);
Vue.use(form_group);
Vue.use(form_checkbox);
Vue.use(form_textarea);
Vue.use(form_select);
Vue.use(form_file);
Vue.use(button);
Vue.use(table);
Vue.use(link);
Vue.use(image);
Vue.use(radio);
Vue.use(navbar);
Vue.use(VueCarousel);
Vue.use(modal);
Vue.use(alert);

import Vuex from 'vuex';
Vue.use(Vuex);

import Notifications from 'vue-notification'
Vue.use(Notifications)


// -----------------------------------
//
// ОСНОВНОЕ ХРАНИЛИЩЕ
//
// -----------------------------------
const store = new Vuex.Store({
    state: {
      show_other_fields: false  // дополнительные поля в объявлении (поле доп. информация, и.т.д.)
    },
    mutations: {
      showOtherFields (state) {
        state.show_other_fields=true;
      },
      hideOtherFields (state) {
        state.show_other_fields=false;
      }
    }
})

const app = new Vue({
    el: '#app',
    store,
    data: data,
    components: {
      index,
      profile,
      cabinet,
      sendemail,
      login,
      register,
      search,
      results,
      create,
      fullinfo,
  },

  created() {    
    // esc на результатах
    document.addEventListener('keyup', (event) => {
        if (event.key==="Escape") window.history.back();
    });
  }
});