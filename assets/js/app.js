/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
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
import courseMainComponent from "./components/course/courseMainComponent";
import headerComponent from "./components/headerComponent";
import footerComponent from "./components/footerComponent";





Vue.component('course-main',courseMainComponent );
Vue.component('my-header',headerComponent );
Vue.component('my-footer',footerComponent );

Vue.use(VueAxios,axios);
axios.defaults.headers.common['Content-Type'] = 'application/json';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

document.addEventListener('DOMContentLoaded', () => {

    if (document.getElementById("app")) {
        const app = new Vue({
            el: '#app',
            store
        });
    }


});


$(document).ready(function() {
    $('#dataTable').DataTable();
});