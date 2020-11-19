import Vue from 'vue'
import App from './App.vue'
import router from './router'
import viewer from './plugins/viewer';
import vuetify from './plugins/vuetify';
import clipboard from './plugins/clipboard';
import count from './plugins/count';
import maps from './plugins/maps';
import axios from 'axios';
Vue.prototype.$axios = axios;
Vue.config.productionTip = false
new Vue({
  router,
  viewer,
  clipboard,
  maps,
  count,
  vuetify,
  render: h => h(App)
}).$mount('#app')
