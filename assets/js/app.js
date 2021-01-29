/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//<![CDATA[

//]]>

import '../css/app.css';

import $ from 'jquery';
import 'jquery.easing'
import 'bootstrap';
import 'datatables.net'
import 'datatables.net-bs4/js/dataTables.bootstrap4'
import 'bootstrap/js/dist/util';
import 'bootstrap/js/dist/dropdown';

import Vue from 'vue';
import axios from 'axios';
import VueAxios from "vue-axios";
import store from './store/store'
import homeComponent from "./components/homeComponent";
import courseMainComponent from "./components/course/courseMainComponent";
import headerComponent from "./components/headerComponent";
import footerComponent from "./components/footerComponent";
import lessonSingleComponent from "./components/lessons/lessonSingleComponent";

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Vuelidate from "vuelidate/src";
import VueLodash from 'vue-lodash';
import lodash from 'lodash';
import Routes from './routes'
import VueRouter from "vue-router";
import contactComponent from "./components/contactComponent";
import cartComponent from "./components/cartComponent";
import approvedComponent from "./components/approvedComponent";
import courseDetailsComponent from "./components/course/courseDetailsComponent";
import searchResults from "./components/searchResults";
import registerComponent from "./components/form/registerComponent";


import VueCoreVideoPlayer from 'vue-core-video-player'
import vueVimeoPlayer from 'vue-vimeo-player'
import profileComponent from "./components/profile/profileComponent";







Vue.component('course-main',courseMainComponent );
Vue.component('course-detail',courseDetailsComponent );
Vue.component('my-header', headerComponent );
Vue.component('my-footer',footerComponent );
// Vue.component('check-out',checkoutComponent );
Vue.component('home',homeComponent );
Vue.component('approved',approvedComponent );
Vue.component('contact',contactComponent );
Vue.component('cart',cartComponent );
Vue.component('lesson-single',lessonSingleComponent);
Vue.component('search-results',searchResults);
Vue.component('the-profile', profileComponent)
Vue.component('register-component', registerComponent)




Vue.use(VueCoreVideoPlayer)
Vue.use(vueVimeoPlayer)


Vue.use(VueAxios,axios);
axios.defaults.headers.common['Content-Type'] = 'application/ld+json';
Vue.use(VueLodash, { name: 'custom' , lodash: lodash })

// Install BootstrapVue

Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(Vuelidate);
Vue.use(VueRouter);


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


document.addEventListener('DOMContentLoaded', () => {
    document.cookie = '_d2id=13529453-597e-4399-ad32-8a72388ab593-n; SameSite=None; Secure';
    document.cookie = '_d2id=80e2dc03-9f8b-45b7-9219-197051139f8a-n; SameSite=None; Secure';
    if (document.getElementById("app")) {
        const app = new Vue({
            el: '#app',
            router: Routes,
            store
        });


    }




});


$(document).ready(function() {
    $('#dataTable').DataTable();



});