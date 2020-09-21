import * as types from '../types'

export default {
    [types.IS_LOGIN_ACTION]: ({commit})=>{
        commit(types.MUTATE_IS_LOGIN)
    },
    [types.ERRORS_HEADERS_LOGIN_ACTION]: ({commit },payload)=>{
        commit(types.MUTATE_ERRORS_HEADERS_LOGIN, payload)
    },
    [types.ERRORS_HEADERS_REGISTER_ACTION]: ({commit },payload)=>{
        commit(types.MUTATE_ERRORS_HEADERS_REGISTER, payload)
    },
    [types.UPDATE_USER_DATA_EMAIL]: ({commit}, payload)=>{

        commit(types.MUTATE_USER_DATA_EMAIL, payload)
    },
    [types.UPDATE_USER_DATA_PASSWORD]: ({commit}, payload)=>{

        commit( types.MUTATE_USER_DATA_PASSWORD, payload)
    },
    [types.UPDATE_USER_DATA_NAME]: ({commit}, payload)=>{

        commit( types.MUTATE_USER_DATA_NAME, payload)
    },
    [types.UPDATE_USER_DATA_IRI]: ({commit}, payload)=>{

        commit( types.MUTATE_USER_DATA_IRI, payload)
    },
    [types.UPDATE_USER_DATA_ID]: ({commit}, payload)=>{

        commit( types.MUTATE_USER_DATA_ID, payload)
    },

    [types.ADD_USER_COURSE]: ({commit}, payload)=>{
        if(payload !== null){
            commit( types.MUTATE_ADD_USER_COURSE, payload)
        }else {
            commit( types.MUTATE_RESET_USER_COURSE)
        }


    },

}