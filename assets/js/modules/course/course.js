import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";



const state = {
    courses: [],
    currentPage: 1,
    searchResult: [],

    totalItems: 0
}

export  default {
    state,
    getters,
    mutations,
    actions
}