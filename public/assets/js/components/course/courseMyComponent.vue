<template>
    <div>


        <course-list :courses="coursesPayed"></course-list>


    </div>
</template>

<script>

    import courseListComponent from "./courseListComponent";
    import router from "../../routes";

    import * as types from "../../modules/types";
    import {mapGetters, mapActions} from  'vuex';
    import usersCourses from "../../modules/usersCourses/usersCourses";

    export default {

        components:{

            'course-list': courseListComponent,


        },
        name: "courseMyComponent",
        data(){
            return {
             coursesPayed: []
            }
        },

        computed:{
            ...mapGetters({
                courses: types.ALL_COURSES,
                userCourses: types.USER_COURSES,
                isLogin: types.IS_LOGIN,
                userCoursesPayed: types.ALL_USER_COURSES_PAYED,
                userEmail: types.USER_EMAIL,
                currentPage: types.COURSES_CURRENT_PAGE,
            }),

        },
        watch: {
            userCoursesPayed: function () {
                if(this.userCoursesPayed.length>0){
                    this.userCoursesPayed.forEach(item =>{
                        this.coursesPayed.push(item.course)

                    })
                }

            },
            currentPage: function (val) {
                this.userCoursesPayed(this.userEmail, this.currentPage);
            }
        },

        beforeRouteEnter(to, from, next){

            next(vm=>{

                if(!vm.isLogin || !from.name ){

                    router.push({ path: '/' })
                }

            })
        },
        mounted() {

            this.updateCurrentPage(1);
            console.log(this.userEmail, this.currentPage);

      this.updateUserCoursesPayed({
          email: this.userEmail,
          page: this.currentPage
      });




        },
        methods: {
            ...mapActions({
                updateUserCoursesPayed: types.ADD_USER_COURSES_PAYED_ACTION,
                updateCurrentPage: types.UPDATE_COURSE_CURRENT_PAGE

            }),



        }
    }
</script>

<style scoped>

</style>