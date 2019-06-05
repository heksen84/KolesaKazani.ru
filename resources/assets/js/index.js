import data from './data';
import Vue from 'vue/dist/vue.js'

// Вьюшки ВьюДжеЭс
//import index from './views/index.vue';

// bootstrap
import layout from 'bootstrap-vue/src/components/layout';
import modal from 'bootstrap-vue/src/components/modal';
import form from 'bootstrap-vue/src/components/form';
import navbar from 'bootstrap-vue/src/components/navbar';
import button from 'bootstrap-vue/src/components/button';
import table from 'bootstrap-vue/src/components/table';

Vue.use(layout);
Vue.use(form);
Vue.use(modal);
Vue.use(navbar);
Vue.use(button);
Vue.use(table);

//import index from './components/App.vue';
import index from './views/index.vue';


import Vuex from 'vuex';
Vue.use(Vuex);

// -----------------------------------
// Реактивное хранилище
// -----------------------------------
const store = new Vuex.Store({

  
})



export default new Vue({
  store,
  render: h => h(index)
});