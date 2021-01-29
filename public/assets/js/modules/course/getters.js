import * as types from '../types';
export  default {
    [types.ALL_COURSES]: state => {
        return [...state.courses];
    },
    [types.COURSES_CURRENT_PAGE]: state => {
        return state.currentPage;
    },
    [types.COURSES_TOTAL_ITEMS]: state => {
        return state.totalItems;
    },
    [types.SEARCH_RESULTS_COURSES]: state => {
        return state.searchResult;
    },
}