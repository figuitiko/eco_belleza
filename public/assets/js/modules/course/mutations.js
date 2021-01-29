import * as types from '../types'

const getDefaultState = ()=> {
    return {
        courses: []
    }
}


export default {
    [types.MUTATE_ADD_COURSE]: (state,payload) => {
        state.courses = payload
    },
    [types.MUTATE_RESET_COURSES]: (state)=>{

        Object.assign(state, getDefaultState());

    },
    [types.MUTATE_COURSES_CURRENT_PAGE]: (state,payload) => {
        state.currentPage = payload
    },
    [types.MUTATE_COURSE_TOTAL_ITEMS]: (state,payload) => {
        state.totalItems = payload
    },
    [types.MUTATE_SEARCH_RESULTS_COURSES]: (state,payload) => {
        state.searchResult = payload
    },

}