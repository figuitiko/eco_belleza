import * as types from '../types'
import axios from 'axios';
export default {
    [types.ADD_COURSE]: ({commit}, payload)=>{
        if(payload !== null){
            commit( types.MUTATE_ADD_COURSE, payload)
        }else{
            commit(types.MUTATE_RESET_COURSES)
        }

    },
    [types.UPDATE_COURSE_CURRENT_PAGE]: ({commit}, payload)=>{
        commit(types.MUTATE_COURSES_CURRENT_PAGE, payload)
    },
    [types.UPDATE_COURSE_CURRENT_PAGE]: ({commit}, payload)=>{
        commit(types.MUTATE_COURSES_CURRENT_PAGE, payload)
    },

    [types.UPDATE_COURSE_TOTAL_ITEMS]: ({commit}, payload)=>{
        commit(types.MUTATE_COURSE_TOTAL_ITEMS, payload)
    },
    [types.UPDATE_SEARCH_RESULTS_COURSES]: ({commit}, {title,page})=>
        axios.get(`/api/courses?title=${title}&page=${page}`)
            .then(response =>{

                console.log(response.data)
                commit(types.MUTATE_COURSE_TOTAL_ITEMS, response.data['hydra:totalItems'])
                commit(types.MUTATE_SEARCH_RESULTS_COURSES, response.data['hydra:member'])
            }).catch((e)=>{
                console.log(e.message);
        })



}