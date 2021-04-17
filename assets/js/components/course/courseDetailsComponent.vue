<template>
    <div>
    <section class="single-course spad pb-0 mt-5">
        <div class="container">
            <div class="course-meta-area">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
<!--                        <div class="course-note">Featured Course</div>-->
                        <h3>{{course.title}}</h3>
                        <div class="course-metas">
                            <!--<div class="course-meta">
                                <div class="course-author">
                                    <div class="ca-pic set-bg" data-setbg="img/authors/2.jpg"></div>
                                    <h6>Teacher</h6>
                                    <p>William Parker, <span>Developer</span></p>
                                </div>
                            </div>-->

                            <div class="course-meta">
                                <div class="cm-info">
                                    <h6>Estudiantes</h6>
<!--                                    <p>{{amountStudents}} Estudiantes Registrados</p>-->
                                </div>
                            </div>
                            <!--<div class="course-meta">
                                <div class="cm-info">
                                    <h6>Reviews</h6>
                                    <p>2 Reviews <span class="rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star is-fade"></i>
									</span></p>
                                </div>
                            </div>-->
                        </div>
                        <a href="#" class="site-btn price-btn">Precio: {{course.price}}</a>
                        <a  class="site-btn buy-btn" @click="iWantIt" v-if="!areLessons">Agregar al Carrito</a>

                    </div>
                </div>
            </div>
            <transition name="fade">
            <b-alert :show="duplicateError"

                     variant="danger"

            >Ya los has agregado

            </b-alert>
            </transition>

                <transition name="fade">

            <b-alert :show="isAddedValue"

                     variant="success"

            >has agregado Un course

            </b-alert>
                </transition>
            <img src="img/courses/single.jpg" alt="" class="course-preview">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 course-list">
                    <div class="cl-item">
                        <h4>Descripción del Curso</h4>
                        <div v-html="course.description"></div>




                    </div>
                   <!-- <div class="cl-item">
                        <h4>Certification</h4>
                        <p>Phasellus sollicitudin et nunc eu efficitur. Sed ligula nulla, molestie quis ligula in, eleifend rhoncus ipsum. Donec ultrices, sem vel efficitur molestie, massa nisl posuere ipsum, ut vulputate mauris ligula a metus. Aenean vel congue diam, sed bibendum ipsum. Nunc vulputate aliquet tristique. Integer et pellentesque urna. Lorem ipsum dolor sit amet, consectetur. Phasellus sollicitudin et nunc eu efficitur. Sed ligula nulla, molestie quis ligula in, eleifend rhoncus ipsum. Donec ultrices, sem vel efficitur molestie, massa nisl posuere ipsum.</p>
                    </div>
                    <div class="cl-item">
                        <h4>The Instructor</h4>
                        <p>Sed ligula nulla, molestie quis ligula in, eleifend rhoncus ipsum. Donec ultrices, sem vel efficitur molestie, massa nisl posuere ipsum, ut vulputate mauris ligula a metus. Aenean vel congue diam, sed bibendum ipsum. Nunc vulputate aliquet tristique. Integer et pellentesque urna. Lorem ipsum dolor sit amet, consectetur. Phasellus sollicitudin et nunc eu efficitur. Sed ligula nulla, molestie quis ligula in, eleifend rhoncus ipsum. Donec ultrices, sem vel efficitur molestie, massa nisl posuere ipsum, ut vulputate mauris ligula a metus. </p>
                    </div>-->
                </div>
            </div>
        </div>
    </section>
        <list-lessons :lessons="lessons" v-if="areLessons"></list-lessons>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import * as types from "../../modules/types";
    import listLessonsComponent from "../lessons/listLessonsComponent";
    import router from "../../routes";
    import HtmlPreview from 'vue-html-viewer';

    export default {
        name: "courseDetailsComponent",
        components: {'list-lessons':listLessonsComponent }  ,
        data(){
            return{
                course:{

                },
               amountStudents: 0,
                duplicateError: false,
                isAddedValue: false,
                lessons:[],
                courseIri: ''
            }
        },
        computed: {
            ...mapGetters({
                email: types.USER_EMAIL,
                isLogin: types.IS_LOGIN,
                userIri: types.USER_IRI,
                courseAdded: types.IS_ADDED_USER_COURSE

            }),
           areLessons(){
               return this.lessons.length > 0;

           }

        },
        beforeRouteEnter(to, from, next){

            next(vm=>{
                console.log(from.name);
                if( !from.name  ){

                    router.push({ path: '/' })
                }else{

                    vm.getCourse();
                }


            })


        },
        mounted() {
            console.log(this.course['@id']);

        },
        methods:{
            getCourse(){
                this.axios.get(`/api/courses/${this.$route.params.id}`)
                    .then(response=>{
                        console.log(response.data);
                        console.dir(response.data.userCourses );
                        this.courseIri = response.data['@id'];


                        this.course= response.data;
                        this.amountStudents = response.data.userCourses.length;
                        if(response.data.userCourses.length > 0){
                            response.data.userCourses.forEach(item =>{
                                console.log(item);

                                if(this.isLogin){
                                    if((item.course === response.data['@id'])&&(item.user === this.userIri)){

                                         let lessons= response.data.lessons.filter(lesson => lesson.isVisible === true);
                                            this.lessons = lessons;

                                    }
                                }

                            })


                        }

                    })
            },
            iWantIt(){
                if(!this.isLogin){
                    this.$bvModal.show('modal-2')
                }else {
                    let self = this;
                    this.axios.get(`/api/user_courses?user.email=${this.email}&course.id=${this.$route.params.id}`)
                        .then(response=>{

                            console.log(response.data['hydra:totalItems']);
                            if(response.data['hydra:totalItems'] === 0){
                                this.isAddedValue = !this.isAddedValue;
                                setTimeout(()=>{
                                    this.isAddedValue = !this.isAddedValue;
                                }, 3000)
                                self.addUserCourse();
                                this.$store.dispatch(types.ADD_USER_COURSES_ACTION)

                            }else{
                                this.duplicateError = !this.duplicateError;
                                setTimeout(()=>{
                                    this.duplicateError = !this.duplicateError;
                                }, 3000)
                            }
                        }).catch(e=>{
                        console.log(e.message);
                    })


                }
            },
            addUserCourse(){
                let userCourse = {
                    isAdded: true,
                    user: this.userIri,
                    course: this.courseIri

                }

                this.axios.post('/api/user_courses', userCourse)
                    .then(response=>{


                        this.$store.dispatch(types.ADD_USER_COURSES_ACTION,this.email);
                        this.$store.dispatch(types.IS_ADDED_USER_COURSE_ACTION);
                    }).catch(e=>{
                    console.log(e.messages)
                })
            },

        },
        filters:{
            escapeHtml: function (value) {
                if(!value) return '';
                value.toString();
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };

                return value.replace(/[&<>"']/g, function(m) { return map[m]; });
            }
        }

    }
</script>

<style scoped>

</style>