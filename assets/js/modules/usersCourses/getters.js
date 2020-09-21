import * as types from '../types';
export  default {
    [types.ALL_USER_COURSES]: state => {
        return [...state.usersCourses];
    },
    [types.ALL_USER_COURSES_PAYED]: state => {
        return [...state.usersCoursesPayed];
    },
    [types.IS_ADDED_USER_COURSE]: state => {
        return state.userCourse.isAdded;
    },
    [types.IS_PAYED_USER_COURSE]: state => {
        return state.userCourse.isPayed;
    },
    [types.USER_COURSE_USER_IRI]: state => {
        return state.userCourse.user;
    },
    [types.USER_COURSE_COURSE_IRI]: state => {
        return state.userCourse.course;
    },
    [types.TOTAL_PRICE]: state => {
        return state.totalPrice;
    },


}