import Vue from 'vue';

import layout from 'bootstrap-vue/src/components/layout';
import button from 'bootstrap-vue/src/components/button';
import modal from 'bootstrap-vue/src/components/modal';

Vue.use(layout);
Vue.use(button);
Vue.use(modal);

import index from './views/index_ssr';


export default new Vue({
    render: h => h(index)
});
