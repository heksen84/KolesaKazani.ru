require('./bootstrap');

import Vue from 'vue';
import basefilter from './views/components/filters/baseFilter'
import legkovoyfilter from './views/components/filters/transport/legkovoy'

export default new Vue ({
  
  el: '#app',

  components: {
    basefilter,
    legkovoyfilter
  },

  data () { return {} },

  created() {
    document.getElementById("spinner").style.display = "none";
  },

  methods: {
  
  // Вернуться на предыдущую страницу
  closeAndReturn() {
    //window.history.back();
    window.location="/";
  }

  
  }
});