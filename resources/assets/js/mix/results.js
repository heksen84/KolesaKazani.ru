require('./bootstrap');

import Vue from 'vue';
import basefilter from './views/components/filters/baseFilter'
import transportfilter from './views/components/filters/transportFilter'

export default new Vue ({
  
  el: '#app',

  components: { 
    basefilter,
    transportfilter
  },

  methods: {}
});