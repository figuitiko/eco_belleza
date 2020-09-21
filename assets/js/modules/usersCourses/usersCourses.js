import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";

const getDefaultState = ()=> {
    return {
        usersCourses: [],
        usersCoursesPayed:[],
        userCourse: {
            user: '',
            course: '',
            isAdded: false,
            isPayed: false,
        },
        totalPrice:0
    }
}

const state = getDefaultState();



export  default {
    state,
    getters,
    mutations,
    actions
}