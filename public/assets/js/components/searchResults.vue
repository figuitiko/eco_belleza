<template>
   <course-list :courses="courseSearchResult"></course-list>
</template>

<script>

   import courseListComponent from "./course/courseListComponent";
   import * as types from  "../modules/types"
   import {mapGetters, mapActions} from  'vuex';

    export default {
        name: "searchResults",
        components: {
            'course-list': courseListComponent,
        },
        data(){
            return{
                courseSearchResult:[]
            }
        },
       computed:{
          ...mapGetters({

             currentPage: types.COURSES_CURRENT_PAGE,
             searchResultsCourses: types.SEARCH_RESULTS_COURSES
          }),


       },
       watch: {
          searchResultsCourses: function(val){
             this.courseSearchResult = val
          },
          currentPage: function (val) {
             this.searchResults({title: this.$route.query.title, page: val})
          }
       },
       mounted() {
           this.searchResults({title: this.$route.query.title, page: this.currentPage})
       },
       methods:{
           ...mapActions({
              searchResults: types.UPDATE_SEARCH_RESULTS_COURSES
           }),
           getSearchCourses(){
            this.axios.get(`/api/courses?title=${this.$route.query.title}`)
               .then(response=>{

                  this.courseSearchResult = response.data['hydra:member'];

               }).catch(e=>{
                  console.log(e.message)
            })
           }
       }
    }
</script>

<style scoped>

</style>