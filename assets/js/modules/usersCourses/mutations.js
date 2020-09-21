import * as types from '../types'
import usersCourses from "./usersCourses";

const getDefaultState = ()=> {
    return {
        usersCourses: [],
        userCourse: {
            user: '',
            course: '',
            isAdded: false,
            isPayed: false,
        }
    }
}
export default {
    [types.MUTATE_ADD_USER_COURSES]: (state,payload) => {

        state.usersCourses.push(payload)
    },
    [types.MUTATE_ADD_USER_COURSES]: (state,payload) => {

        state.usersCourses=payload
    },
    [types.MUTATE_RESET_USER_COURSES]: (state)=>{

       state.usersCourses = [];

    },
    [types.MUTATE_ADD_USER_COURSES_PAYED]: (state,payload) => {

        state.usersCoursesPayed = payload;
    },
    [types.MUTATE_RESET_USER_COURSE_PAYED]: (state) => {

        state.usersCoursesPayed = [];
    },
    [types.MUTATE_REMOVE_USER_COURSES]: (state, payload)=>{
        console.log(payload)
        const record = state.usersCourses.find(element => element.id === payload)
      state.usersCourses.splice(state.usersCourses.indexOf(record), 1);
       // this.$delete(state.usersCourses, state.usersCourses.indexOf(record));



    },

    [types.MUTATE_USER_COURSE_IS_ADDED]: (state)=>{
        state.userCourse.isAdded = !state.userCourse.isAdded;
    },
    [types.MUTATE_USER_COURSE_IS_PAYED]: (state)=>{
        state.userCourse.isAdded = !state.userCourse.isAdded;
    },
    [types.MUTATE_USER_COURSE_COURSE_IRI]: (state)=>{
        state.userCourse.isAdded = !state.userCourse.isAdded;
    },
    [types.MUTATE_USER_COURSE_USER_IRI]: (state)=>{
        state.userCourse.isAdded = !state.userCourse.isAdded;
    },
    [types.MUTATE_TOTAL_PRICE]: (state)=>{
        let totalPrice= 0;
        if(state.usersCourses.length>0){
            state.usersCourses.forEach(usersCourse=>{
                totalPrice += usersCourse.course.price
            })
            state.totalPrice = totalPrice;
        }
        state.totalPrice = totalPrice;
    },



}