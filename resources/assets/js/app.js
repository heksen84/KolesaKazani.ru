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
import detailed from './views/detailed.vue';
import sendemail from './views/auth/sendemail.vue';
import passwordreset from './views/auth/passwordreset.vue';
import login from './views/auth/login.vue';
import register from './views/auth/register.vue';
import adminpanel from './views/panels/admin.vue';


// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)


/*import layout from 'bootstrap-vue/src/components/layout';
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
import pagination from 'bootstrap-vue/src/components/pagination';


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
Vue.use(modal);
Vue.use(alert);
Vue.use(pagination); */

import Vuex from 'vuex';
Vue.use(Vuex);

import Notifications from 'vue-notification'
Vue.use(Notifications)

// -----------------------------------
// Реактивное хранилище
// -----------------------------------
const store = new Vuex.Store({

    state: { 
            
      required_info: false,       // обязательное поле дополнительной информации
      price: "",      
      info_label_description: "",
      placeholder_info_text:  "",      
      show_final_fields: false,
      show_common_transport: false,
      deal_selected: false,

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
      
       SetDealSelected( state, value ) {
        state.deal_selected=value;
      },

      // установить заголовок для площади в недвижимости
      SetRealEstateAreaLabelText( state, text ) {
        if (text=="default") 
          state.str_realestate_area_label_text = "Площадь (кв.м.):"
        else
          state.str_realestate_area_label_text = text;
      },

      // установить заголовок доп. информации / текста объявления
      SetInfoLabelDescription( state, text ) {
        if (text=="default") 
          state.info_label_description = "Текст объявления"
        else
          state.info_label_description = text;
      },

      // установить текст подсказки в поле описание
      SetPlaceholderInfoText(state, text) {
        if (text=="default") 
          state.placeholder_info_text = "Введите текст объявления"
        else
          state.placeholder_info_text = text;
      },

      // сбросить содержимое поля
      ResetField(state, field_name) {
        switch(field_name) {
          case "price": state.price=""; break;
        }
      },
      
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

      },

      SetRequiredInfo (state, value) {
        state.required_info=value;
      },

      ShowFinalFields (state, value) {
        state.show_final_fields=value;
      },

      ShowCommonTransport (state, value) {
        state.show_common_transport=value;
      }

    }
})

// экземляр приложения vue
//const app = new Vue({
export default new Vue({
    el: '#app',
    store,
    data: data,
    components: {
      index,
      profile,
      cabinet,
      sendemail,
      passwordreset,
      login,
      register,
      search,
      results,
      create,
      detailed,
      adminpanel
  },

  created() {    
    // esc на результатах
    /*document.addEventListener('keyup', (event) => {
        if (event.key==="Escape") window.history.back();
    });*/
  }
});