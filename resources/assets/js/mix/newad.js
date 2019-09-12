"use strict";

require('./bootstrap');

import Vue from 'vue';
import newad from './views/newad.vue';

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({
  el: '#app',
  components: { newad }
});