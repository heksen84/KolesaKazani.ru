import data from './data';
import Vue from 'vue';

// Вьюшки ВьюДжеЭс
//import index from './views/index.vue';
import index from './components/App.vue';

// bootstrap
/*import layout from 'bootstrap-vue/src/components/layout';*/
//import modal from 'bootstrap-vue/src/components/modal';
//import form from 'bootstrap-vue/src/components/form';
//import navbar from 'bootstrap-vue/src/components/navbar';
//import button from 'bootstrap-vue/src/components/button';

/*Vue.use(layout);
Vue.use(form);
Vue.use(modal);
Vue.use(navbar);
Vue.use(button);

import Vuex from 'vuex';
Vue.use(Vuex);

// -----------------------------------
// Реактивное хранилище
// -----------------------------------
const store = new Vuex.Store({

    state: { 
      
      str_login: "",
      str_register: "",
      str_my_adverts: "",
      str_title: "",
      str_desc: "",
      str_search_placeholder: "",
      str_button_search: "",
      str_create_advert: "",
      str_my_adverts: "",
      str_location: "",     
      str_realestate_area_label_text: ""

    },

    mutations: {
      
      // установить язык
      SetLang (state, lang) {
        
        if (lang == "ru") { // русский
          state.str_title = "Дамеля"
          state.str_desc = "доска объявлений"
          state.str_search_placeholder = "поиск по объявлениям"
          state.str_button_search = "найти"
          state.str_create_advert = "подать объявление"
          state.str_my_adverts = "мои объявления"
          state.str_location = "расположение"          
        }                
        
        if (lang == "kz") { // казахский
          state.str_title = "Дамеля"
          state.str_desc = "хабарландыру тақтасы"
          state.str_search_placeholder = "хабарландыруларда іздеу"
          state.str_button_search = "іздеу"
          state.str_create_advert = "хабарландыру орналастырыңыз"
          state.str_my_adverts = "менің хабарландыруларым"
          state.str_location = "орналасқан"          
        }

      }

    }
})

// экземляр приложения vue
//const app = new Vue({
*/
/*export default new Vue({
    el: '#app'
});*/

/*export default new Vue({
   store,
    data: data,
    components: {
      index
  },
  render: h => h(index)
})*/;

export default new Vue({
  render: h => h(index)
});