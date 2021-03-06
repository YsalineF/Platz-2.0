/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// Import du router et du store
import router from './router.js'
import store from './store/store.js'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('menu-categories', require('./components/Menu.vue').default);
Vue.component('logo', require('./components/Logo.vue').default);
Vue.component('menu-filter', require('./components/MenuFilter.vue').default);
Vue.component('connexion', require('./components/Connexion.vue').default);
Vue.component('search-bar', require('./components/SearchBar.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router, store,
    created() {
      this.$store.dispatch('setRessources')
      this.$store.dispatch('setCategories')
      this.$store.dispatch('setUsers')
      this.$store.dispatch('setCommentaires')
      this.$store.dispatch('setConversations')
      // Inspîration : https://stackoverflow.com/questions/51892979/how-to-stay-logged-in-even-after-page-refresh-with-vuex
      // Vérifie si un item "connected" existe dans le sessionStorage (à check dans inspecteur >network > session storage)
      if(sessionStorage.getItem('connected')) {
        // Place l'item dans une variable car on doit obligatoirement la traduire en JSON
        let connected = sessionStorage.getItem('connected')
        // Creation d'un objet de type JSON
        let connectedInJson = JSON.parse(connected)
        this.$store.dispatch('loginUser', connectedInJson)
      }
    }
});
