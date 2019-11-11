"use strict";

require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import newad from './views/newad.vue';

Vue.use(Vuex);

// --------------------------------------
// Хранилище
// --------------------------------------
const store = new Vuex.Store({

  state: {          
    price: "", 
    required_info: false,
    info_label_description: "",
    placeholder_info_text:  "Введите описание",      
    show_final_fields: false,
    show_common_transport: false,
    deal_selected: false,    
    str_realestate_area_label_text: ""    
  },

  mutations: {

    SetDealSelected( state, value ) {
      state.deal_selected=value;
    },

    // установить заголовок для площади в недвижимости
    SetRealEstateAreaLabelText( state, text ) {
      text=="default"?state.str_realestate_area_label_text = "Площадь (кв.м.):":state.str_realestate_area_label_text = text;
    },

    // установить заголовок доп. информации / текста объявления
    SetInfoLabelDescription( state, text ) {
      text=="default"?state.info_label_description = "Текст объявления":state.info_label_description = text;
    },

    // установить текст подсказки в поле описание
    SetPlaceholderInfoText(state, text) {
      state.placeholder_info_text = text;
    },

    // сбросить содержимое поля
    ResetField(state, field_name) {
      switch(field_name) {
        case "price": state.price=""; break;
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

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({
  
  data () {     
    return { 
      advert_data: {} // глобальный объект объявления
    }
  },
  store,
  el: '#app',
  components: { newad }

});