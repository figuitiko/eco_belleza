<template>
    <div>

        <transition-group name="page" tag="div">
            <course-list :courses="courses" :key="userId" ></course-list>
        </transition-group>



    </div>
</template>

<script>
    import courseListComponent from "./courseListComponent";

    import * as types from "../../modules/types";
    import {mapGetters, mapActions} from  'vuex';

    export default {

        components:{

            'course-list': courseListComponent,



        },
        name: "courseMainComponent",


        computed:{
            ...mapGetters({
                courses: types.ALL_COURSES,
                userCourses: types.USER_COURSES,
                isLogin: types.IS_LOGIN,
                userId: types.USER_ID,
                currentPage: types.COURSES_CURRENT_PAGE,
                userEmail: types.USER_EMAIL

            }),


        },
        watch: {
            currentPage: function (val) {
                this.getAllCourses();

            }


        },

        mounted() {
            this.$store.dispatch(types.ADD_COURSE, null)
            this.getAllCourses();



        },
        methods:{
            ...mapActions({
                userCoursesAction: types.ADD_USER_COURSES_ACTION
            }),
            getAllCourses(){
                this.axios.get(`/api/courses?page=${this.currentPage}`)
                    .then(response=>{
                        console.log(response.data);
                        this.$store.dispatch(types.UPDATE_COURSE_TOTAL_ITEMS,response.data['hydra:totalItems'] )
                        this.$store.dispatch(types.ADD_COURSE,response.data['hydra:member'] );
                       /* response.data['hydra:member'].forEach(course=>{
                            this.$store.dispatch(types.ADD_COURSE,course );
                        })*/
                        if(this.isLogin){



                            //this.getAllUsersCourses(userJson.email, )
                        }
                    })
            },

        }
    }
</script>

<style scoped>

</style>