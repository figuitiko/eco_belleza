import Vue from  'vue';
import  Vuex from 'vuex';
import header from "../modules/header/header";
import course from "../modules/course/course";
import usersCourses from "../modules/usersCourses/usersCourses";

Vue.use(Vuex);
const store = new Vuex.Store({
    state:{

    },
    modules:{
        header,
        course,
        usersCourses
    }
});

export default  store;


