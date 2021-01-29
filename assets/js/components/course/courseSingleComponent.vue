<template>

    <div class="mix col-lg-3 col-md-4 col-sm-6 finance">


        <div class="course-item">


            <div class="course-thumb set-bg"  v-bind:style ="{backgroundImage: imgUrlComplete}">
                <div class="price">Price: {{price}}</div>
            </div>
            <div class="course-info">
                <div class="course-text">
                    <h5>{{title}}</h5>




                </div>

            </div>
            <div class="view-it" @click="iViewIt(courseId)" >
                <span>Ver Detalles</span>


            </div>
            <div v-if="currentRoute" class="want-it" @click="iWantIt">
                <span>Lo quiero</span>


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


    </div>
</template>

<script>
    import {mapGetters} from  'vuex';
    import * as types from "../../modules/types";

    export default {
        name: "courseSingleComponent",
        props: ['price','imgUrl', 'title','description', 'studentsAmount','iriCourse','courseId' ],
        data(){
            return{
                duplicateError: false,
                isAddedValue: false


            }
        },
        computed:{
            ...mapGetters({
                email:types.USER_EMAIL,
                isLogin: types.IS_LOGIN,
                userIri: types.USER_IRI,
                courseAdded: types.IS_ADDED_USER_COURSE,
                courseUploadUrl: types.UPLOAD_COURSE_URL

            }),
            descriptionExcerpt(){
                let shortDescription = this.description;

                if(shortDescription.length > 200 ){
                    return shortDescription= shortDescription.substring(0,200)+'...';
                }
                return this.description;

            },
            currentRoute(){
                return this.$route.name !== 'my';

            },
            trimImgUrl(){
                return this.imgUrl.trim();
            },
            imgUrlComplete(){


                return `url(${this.courseUploadUrl}${encodeURIComponent(this.trimImgUrl)})`;


            }


        },
        mounted() {

            /*this.$store.dispatch(types.RESET_USER_COURSES_ACTION)
            this.getAllUsersCourses();*/
        },

        destroyed() {

        },
        methods: {
            iWantIt(){
                if(!this.isLogin){
                    this.$bvModal.show('modal-2')
                }else {
                let self = this;
                this.axios.get(`/api/user_courses?user.email=${this.email}&course.id=${this.courseId}`)
                    .then(response=>{
                        console.log(`/api/user_courses?user.email=${this.email}$course.id=${this.courseId}`)
                        console.log(response.data['hydra:totalItems']);
                        if(response.data['hydra:totalItems'] === 0){
                            this.isAddedValue = !this.isAddedValue;
                            setTimeout(()=>{
                                this.isAddedValue = !this.isAddedValue;
                            }, 3000)
                            self.addUserCourse();

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
            iViewIt(id){
                console.log(id);
            this.$router.push({ name: 'courseDetails', params: { id} })
            },

            addUserCourse(){
                let userCourse = {
                    isAdded: true,
                        user: this.userIri,
                    course:this.iriCourse

                }

                this.axios.post('/api/user_courses', userCourse)
                .then(response=>{


                    this.$store.dispatch(types.ADD_USER_COURSES_ACTION,this.email);
                    this.$store.dispatch(types.IS_ADDED_USER_COURSE_ACTION);
                }).catch(e=>{
                    console.log(e.messages)
                })
            },
            getAllUsersCourses(){

                this.axios.get(`/api/user_courses?user.email=${this.email}&course.id=${this.courseId}`)
                .then(response=>{
                    console.log(response.data['hydra:member']);
                    if(response.data['hydra:member'].length > 0){

                        console.log('i am here on single');
                        response.data['hydra:member'].forEach(item=>{

                            this.$store.dispatch(types.ADD_USER_COURSES_ACTION, item)
                        })
                    }else{
                        this.$store.dispatch(types.RESET_USER_COURSES_ACTION)
                    }

                })
            }

        }
    }
</script>

<style scoped>

</style>