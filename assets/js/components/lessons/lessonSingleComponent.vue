<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-10 border-right">

               <!-- <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" :src="'https://127.0.0.1:8000'+lessonVideoUploadUrl+theLesson.videoUrl" allowfullscreen></iframe>
                </div>-->

               <!-- <video width="720"  controls>
                    <source :src="lessonVideoUploadUrl+theLesson.videoUrl" type="video/mp4">
                </video>-->
                <div v-if="embed" class="text-center">
                    <vimeo-player :video-id="embed"></vimeo-player>

                </div>

<!--                <vue-core-video-player :src="trimVideoUrl" :autoplay="false"></vue-core-video-player>-->
            </div>

            <div class="col-md-2 text-center">
                <ol class="single-lesson-list">
                    <li  v-for="lesson of otherLessons" :key="lesson.id" :class="{active: lesson.isActive}">

                        <router-link :to ="{ name: 'lessonSingle', params: { id: lesson.id }}">
                            {{lesson.title}}
                        </router-link>

                    </li>
                </ol>
            </div>


            <div class="col-md-10 text-center">
                <h6> contraseña del video: {{videoPassword}}</h6>
            </div>
            <div class="col-md-10 mt-5">
                <h3>Descripción de la Clase</h3>
                <p v-html="theLesson.description"></p>
            </div>
            <div class="col-md-10" v-if="attachments.length > 0">
                <div class="card">
                    <div class="card-header text-center">
                        Recursos
                    </div>
                    <div class="card-body">
                        <ul class="single-lesson-resource">
                            <li v-for="attachment of attachments" :key="attachment['@id']"><a :href="`${urlBaseLesson}${attachment.image}`" target="_blank">{{attachment.image}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import {mapGetters} from  'vuex';
    import * as types from "../../modules/types";





    export default {
        name: "lessonSingleComponent",
        props:['imgUrl', 'title', 'description'],

        data(){
          return{
              otherLessons:[],
              theLesson:{},
              videoUrl: '',
              embed: '',
              videoPassword: '',
              attachments: [],
              urlBaseLesson: '/uploads/files/lessons/'
          }
        },
        beforeRouteEnter(to, from, next){

            next(vm=>{



                if(!vm.isLogin){

                   vm.$router.push({ path: '/' });
                }

            })

        },
        computed: {
            ...mapGetters({
               lessonVideoUploadUrl:  types.UPLOAD_VIDEO_URL,
                isLogin: types.IS_LOGIN,
                usersCoursesPayed: types.ALL_USER_COURSES_PAYED
            }),
            trimVideoUrl(){
                return this.lessonVideoUploadUrl+encodeURIComponent(this.theLesson.videoUrl)
            },

        },


        beforeMount() {

        },
        mounted() {

        this.getLesson();

        },
        methods: {
            getLesson(){
                this.axios.get(`/api/lessons/${this.$route.params.id}`)
                            .then(response=>{
                                console.log(response);
                                this.theLesson = response.data;
                                this.videoUrl = response.data.videoUrl;
                                this.embed = response.data.embedCode;
                                this.videoPassword = response.data.videoPassword;
                                this.attachments = response.data.attachments

                                response.data.course.lessons.map(item=>{

                                    if((typeof  item !== "object" ) && (item !==null) ){

                                        item = {...response.data}
                                        item.isActive = true;
                                        if(item.isVisible){
                                            this.otherLessons.push(item);
                                        }

                                    }else{
                                        item.isActive = false;
                                        /*if(item.isVisible) {
                                            this.otherLessons.push(item);
                                        }*/

                                    }


                                })
                                console.log(this.otherLessons);



                            })
                .catch((e)=>{
                    this.$router.push('/')
                })
            },

        }

    }
</script>

<style scoped>

</style>