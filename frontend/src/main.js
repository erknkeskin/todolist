import Vue from 'vue'
import App from './App.vue'
import VueAlertify from 'vue-alertify';

import '@fortawesome/fontawesome-free/css/all.min.css';

Vue.use(VueAlertify);

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
