<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-10 border-right">
                {{trimVideoUrl}}
               <!-- <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" :src="'https://127.0.0.1:8000'+lessonVideoUploadUrl+theLesson.videoUrl" allowfullscreen></iframe>
                </div>-->

               <!-- <video width="720"  controls>
                    <source :src="lessonVideoUploadUrl+theLesson.videoUrl" type="video/mp4">
                </video>-->
                <vue-core-video-player :src="trimVideoUrl" :autoplay="false"></vue-core-video-player>
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
              videoUrl: ''
          }
        },
        computed: {
            ...mapGetters({
               lessonVideoUploadUrl:  types.UPLOAD_VIDEO_URL
            }),
            trimVideoUrl(){
                return this.lessonVideoUploadUrl+encodeURIComponent(this.theLesson.videoUrl)
            }

       },
        mounted() {
            this.getLesson();


        },
        methods: {
            getLesson(){
                this.axios.get(`/api/lessons/${this.$route.params.id}`)
                            .then(response=>{
                                console.log(response.data);
                                this.theLesson = response.data;
                                this.videoUrl = response.data.videoUrl;
                                response.data.course.lessons.map(item=>{
                                    console.log(item);
                                    if((typeof  item !== "object" ) && (item !==null) ){

                                        item = {...response.data}
                                        item.isActive = true;
                                        this.otherLessons.push(item);
                                    }else{
                                        item.isActive = false;
                                        this.otherLessons.push(item);
                                    }


                                })
                                console.log(this.otherLessons);



                            })
            }
        }
    }
</script>

<style scoped>

</style>