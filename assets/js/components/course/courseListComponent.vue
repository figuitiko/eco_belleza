<template>
    <div>
    <section class="course-section spad pb-0">
        <div class="course-warp">
            <div class="row">
                <div class="col-md-12 text-center mb-5 mt-5">
                    <h5 class="list-courses-title">{{dynamicTitle}}</h5>
                </div>
            </div>


            <div class="row course-items-area justify-content-center" v-if="courses.length >=1"  >

                <!-- course -->

                <course-single-component
                        v-for="course of courses"
                        :key="course.id"
                        :price="course.price"
                        :imgUrl="course.image"
                        :title="course.title"
                        :description="course.description"
                        :studentsAmount="course.users"
                        :iriCourse="course['@id']"
                        :courseId="course.id"

                            ></course-single-component>

            </div>
        <div class="row d-flex justify-content-center">
            <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="my-table"
            ></b-pagination>
        </div>


        </div>
    </section>
    </div>
</template>

<script>
    import courseSingleComponent from "./courseSingleComponent";
    import callToActionComponent from "./callToActionComponent";
    import {mapGetters} from  'vuex';
    import * as types from "../../modules/types";
    export default {
        name: "courseListComponent",
        components:{courseSingleComponent},
        props:['courses'],
        data(){
            return {
                perPage: 8,
                allCourses: []

            }
        },

        mounted() {
            console.log(this.rows)

        },


        computed:{

            ...mapGetters({
                totalCourses: types.COURSES_TOTAL_ITEMS,

            }),
            dynamicTitle(){
                if(this.$route.name === 'my'){
                    return 'Todos mis cursos'
                }
                else if(this.$route.name === 'search'){
                    return 'Resultados De la busqueda'
                }
                else {
                    return 'Todos los Cursos'
                }
            },
            rows(){
               return this.totalCourses;
            },
            currentPage: {
                get() {

                    return this.$store.getters[types.COURSES_CURRENT_PAGE];
                },
                set(value) {

                    return this.$store.dispatch( types.UPDATE_COURSE_CURRENT_PAGE, value);
                }
            }
        },




    }
</script>

<style scoped>

</style>