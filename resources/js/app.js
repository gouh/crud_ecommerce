/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Notifications from 'vue-notification'
import VueSweetalert2 from 'vue-sweetalert2';
axios.defaults.baseURL = 'http://127.0.0.1:8000/';

Vue.use(Notifications)
Vue.use(VueSweetalert2)

Vue.component('comentarios', require('./components/Comentarios.vue').default);
Vue.component('listado-articulo', require('./views/ListadoArticulo.vue').default);
Vue.component('formulario-articulo', require('./views/FormularioArticulo.vue').default);
Vue.component('editar-articulo', require('./views/EditarArticulo.vue').default);

const app = new Vue({
    el: '#app',
});