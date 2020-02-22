require("./bootstrap");
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';


Vue.use(VModal);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.events = new Vue();

import VModal from 'vue-js-modal';
Vue.use(VModal);

Vue.component('new-project-modal', require('./components/NewProjectModal.vue').default)
Vue.component('dropdown', require('./components/DropDown.vue').default)

const app = new Vue({
    el: '#app'
});
