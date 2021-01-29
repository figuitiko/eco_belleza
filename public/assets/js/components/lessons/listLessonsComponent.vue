<template>
    <!-- Page -->
    <section class="realated-courses spad">
        <div class="course-warp">
            <h2 class="rc-title text-center">Clases</h2>


                <div class="col">

                    <div class="tabs">
                        <div class="tab" v-for="(lesson, index) of lessons" :key="lesson.id">
                            <input type="checkbox" :id="'chck'+index">
                            <label class="tab-label" :for="'chck'+index">{{index+1}}-{{lesson.title}}</label>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-11 border-right ">
                                        <h3>Descripcion</h3>
                                        {{lesson.description}}
                                    </div>
                                    <div class="col-md-1 actions-lesson">

                                                <h6 class="border-bottom">Ver</h6>

                                                <router-link :to ="{ name: 'lessonSingle', params: { id: lesson.id }}"><i class="fa fa-eye"></i></router-link>


                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>



          <!--  <div class="rc-slider owl-carousel">

                <lesson-single v-for="lesson of lessons" :key="lesson.id"
                               :title="lesson.title"
                                :description="lesson.description"
                                :imgUrl="lesson.imgUrl"></lesson-single>
            </div>-->

    </section>
</template>

<script>

    import {mapGetters} from  'vuex';
    import * as types from "../../modules/types";
    export default {
        name: "listLessonsComponent",
        props:['lessons'],

        computed: {
            ...mapGetters({
                lessonUploadUrl:  types.UPLOAD_LESSON_URL
            })
        }


    }
</script>

<style scoped>

</style>