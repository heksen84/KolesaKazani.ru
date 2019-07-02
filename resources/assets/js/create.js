require('./bootstrap');

import data from './data';
import Vue from 'vue';
import create from './views/create.vue';

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
import link from 'bootstrap-vue/src/components/link';
import image from 'bootstrap-vue/src/components/image';
import radio from 'bootstrap-vue/src/components/form-radio';
import alert from 'bootstrap-vue/src/components/alert';
import modal from 'bootstrap-vue/src/components/modal';

Vue.use(layout);
Vue.use(form);
Vue.use(form_input);
Vue.use(form_group);
Vue.use(form_checkbox);
Vue.use(form_textarea);
Vue.use(form_select);
Vue.use(form_file);
Vue.use(button);
Vue.use(link);
Vue.use(image);
Vue.use(radio);
Vue.use(alert);
Vue.use(modal);

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
export default new Vue({
    el: '#app',
    store,
    data: data,
    components: { create }
});