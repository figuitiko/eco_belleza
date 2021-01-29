import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";

const state = {
    user: {
        email: '',
        password: '',
        username:'',
        courses:[],
        userIri:'',
        userId: 0,


    },
    courseUploadUrl: '/uploads/images/courses/',
    lessonUploadUrl: '/uploads/images/lessons/',
    lessonVideoUploadUrl: '/uploads/videos/lessons/',
    isLogin: false,
    errorsHeader: {
      login:'',
      register:''
    }
}

export  default {
    state,
    getters,
    mutations,
    actions
}