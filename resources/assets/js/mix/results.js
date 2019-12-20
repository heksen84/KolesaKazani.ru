require('./bootstrap');

import Vue from 'vue';
import basefilter from './views/components/filters/baseFilter'

export default new Vue ({
  el: '#app',
  components: { basefilter },
  methods: {}
});