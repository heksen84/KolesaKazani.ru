import data from './data';
import Vue from 'vue/dist/vue.js'

// bootstrap
import layout from 'bootstrap-vue/src/components/layout';
import modal from 'bootstrap-vue/src/components/modal';
//import navbar from 'bootstrap-vue/src/components/navbar';
import form from 'bootstrap-vue/src/components/form';
import button from 'bootstrap-vue/src/components/button';

Vue.use(layout);
Vue.use(modal);
//Vue.use(navbar);
Vue.use(form);
Vue.use(button);

//import index from './components/App.vue';
import index from './views/index.vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// -----------------------------------
// Реактивное хранилище
// -----------------------------------
const store = new Vuex.Store({})

export default new Vue({
  store,
  render: h => h(index)
});