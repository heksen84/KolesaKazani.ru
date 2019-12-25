require('./bootstrap');

import Vue from 'vue';
import basefilter from './views/components/filters/baseFilter'
import transportfilter from './views/components/filters/transportFilter'
import realestatefilter from './views/components/filters/realEstateFilter'

export default new Vue ({
  
  el: '#app',

  components: { 
    basefilter,
    transportfilter,
    realestatefilter
  },

  data () {   
    return {           
    }
  },

  created() {
    document.getElementById("spinner").style.display = "none";
  },

  methods: {
  
  // Вернуться на предыдущую страницу
  closeAndReturn() {
    window.history.back();
  }

  
  }
});