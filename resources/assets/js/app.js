require('./bootstrap');

import data from './data';
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
import form_file from 'bootstrap-vue/src/components/form-file';
import button from 'bootstrap-vue/src/components/button';
import table from 'bootstrap-vue/src/components/table';
import link from 'bootstrap-vue/src/components/link';
import image from 'bootstrap-vue/src/components/image';
import radio from 'bootstrap-vue/src/components/form-radio';
import navbar from 'bootstrap-vue/src/components/navbar';
import modal from 'bootstrap-vue/src/components/modal';
import VueCarousel from 'vue-carousel';

import NumberInputSpinner from 'vue-number-input-spinner';
Vue.use(NumberInputSpinner);

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

import Vuex from 'vuex';
Vue.use(Vuex);

import Notifications from 'vue-notification'
Vue.use(Notifications)

import YmapPlugin from 'vue-yandex-maps'
Vue.use(YmapPlugin)

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
  },

  created() {

    //alert("app.js")
    // esc на результатах
    document.addEventListener('keyup', (event) => {
        if (event.key==="Escape") window.history.back();
    });

  }
});