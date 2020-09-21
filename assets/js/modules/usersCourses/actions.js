import * as types from '../types'
import Vue from 'vue';
import axios from 'axios';
import VueAxios from "vue-axios";

Vue.use(VueAxios,axios);
axios.defaults.headers.common['Content-Type'] = 'application/ld+json';

export default {
    /*[types.ADD_USER_COURSES_ACTION]: ({commit}, payload)=>{

        commit( types.MUTATE_ADD_USER_COURSES, payload)
    },*/
    [types.ADD_USER_COURSES_ACTION]: ({commit}, payload)=>{
      axios.get(`/api/user_courses?user.email=${payload}&isPayed=false`)
          .then(response=>{
              console.log(response.data);
              commit(types.MUTATE_COURSE_TOTAL_ITEMS, response.data['hydra:totalItems'])
              if(response.data["hydra:member"].length>0){
                  commit( types.MUTATE_ADD_USER_COURSES, response.data["hydra:member"])

              } else{
                  commit( types.MUTATE_RESET_USER_COURSES)
              }
          })

    },
    [types.ADD_USER_COURSES_PAYED_ACTION]: ({commit}, {email, page})=>{
            axios.get(`/api/user_courses?user.email=${email}&isPayed=true&page=${page}`)
                .then(response=>{
                    console.log(response.data["hydra:member"]);
                    commit(types.MUTATE_COURSE_TOTAL_ITEMS, response.data['hydra:totalItems'])
                    if(response.data["hydra:member"].length>0){
                        commit( types.MUTATE_ADD_USER_COURSES_PAYED, response.data["hydra:member"])

                    } else{
                        commit( types.MUTATE_RESET_USER_COURSE_PAYED)
                    }


                })

    },
    [types.RESET_USER_COURSES_ACTION]: ({commit})=>{

        commit( types.MUTATE_RESET_USER_COURSES)
    },

    [types.REMOVE_USER_COURSES_ACTION]:({commit}, payload)=>{
        commit(types.MUTATE_REMOVE_USER_COURSES, payload)
    },

    [types.IS_ADDED_USER_COURSE_ACTION]: ({commit})=>{
        commit(types.MUTATE_USER_COURSE_IS_ADDED)
    },
    [types.IS_PAYED_USER_COURSE_ACTION]: ({commit})=>{
        commit(types.MUTATE_USER_COURSE_IS_PAYED)
    },
    [types.ADD_USER_COURSE_ACTION_COURSE_IRI]: ({commit})=>{
        commit(types.MUTATE_USER_COURSE_COURSE_IRI)
    },
    [types.ADD_USER_COURSE_ACTION_USER_IRI]: ({commit})=>{
        commit(types.MUTATE_USER_COURSE_USER_IRI)
    },
    [types.UPDATE_TOTAL_PRICE_ACTION]: ({commit})=>{
        commit(types.MUTATE_TOTAL_PRICE)
    },



}