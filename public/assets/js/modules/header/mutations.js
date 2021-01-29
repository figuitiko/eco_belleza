import * as types from '../types'




export default {
    [types.MUTATE_IS_LOGIN]:(state)=> {
        state.isLogin =  true;
    },
    [types.MUTATE_ERRORS_HEADERS_LOGIN]:(state, payload)=> {
        state.errorsHeader.login = payload ;
    },
    [types.MUTATE_ERRORS_HEADERS_REGISTER]:(state, payload)=> {
        state.errorsHeader.register = payload ;
    },
    [types.MUTATE_USER_DATA_EMAIL]: (state, payload)=>{
        state.user.email = payload;
    },
    [types.MUTATE_USER_DATA_PASSWORD]: (state, payload)=>{
        state.user.password = payload;

    },
    [types.MUTATE_USER_DATA_NAME]: (state, payload)=>{
        state.user.username = payload;

    },
    [types.MUTATE_USER_DATA_IRI]: (state, payload)=>{
        state.user.userIri = payload;

    },
    [types.MUTATE_USER_DATA_ID]: (state, payload)=>{
        state.user.userId = payload;

    },
    [types.MUTATE_ADD_USER_COURSE]: (state, payload)=>{
        state.user.courses.push(payload);

    },
    [types.MUTATE_RESET_COURSES]: (state)=>{
        state.user.courses.splice(0, state.user.courses.length);

    }


}