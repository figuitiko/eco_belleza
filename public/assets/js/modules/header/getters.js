import * as types from '../types'



export  default {
    [types.USER_EMAIL]: state => {
        return state.user.email;
    },
    [types.USER_PASSWORD]: state => {
        return state.user.password;
    },
    [types.USER_NAME]: state => {
        return state.user.username;
    },
    [types.USER_COURSES]: state => {
        return state.user.courses;
    },
    [types.USER_IRI]: state => {
        return state.user.userIri;
    },
    [types.USER_ID]: state => {
        return state.user.userId;
    },

    [types.IS_LOGIN]: state =>{
        return state.isLogin;
    },
    [types.ERRORS_HEADERS_LOGIN]: state =>{
        return state.errorsHeader.login;
    },
    [types.ERRORS_HEADERS_REGISTER]: state =>{
        return state.errorsHeader.register;
    },
    [types.UPLOAD_COURSE_URL]: state =>{
        return state.courseUploadUrl;
    },
    [types.UPLOAD_LESSON_URL]: state =>{
        return state.lessonUploadUrl;
    },
    [types.UPLOAD_VIDEO_URL]: state =>{
        return state.lessonVideoUploadUrl;
    },

}