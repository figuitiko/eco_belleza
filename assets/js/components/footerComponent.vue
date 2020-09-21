<template>
    <div>
    <call-to-action v-if="!isLogin"></call-to-action>
    <footer class=" pb-0">

        <div class="footer-bottom">
            <div class="footer-warp">
                <ul class="footer-menu">
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Privacy</a></li>
                </ul>
                <div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy; {{date}}  All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
            </div>
        </div>
    </footer>
    </div>
</template>

<script>
    import callToActionComponent from "./course/callToActionComponent";
    import * as types from "../modules/types";
    import {mapGetters} from  'vuex';

    export default {
        name: "footerComponent",
        components: { 'call-to-action': callToActionComponent},

        data(){
           return  {
                 date: new Date().getFullYear()
            }
        },
        computed:{
            ...mapGetters({
                email: types.USER_EMAIL,
                isLogin: types.IS_LOGIN,
                userIri: types.USER_IRI,
                userEmail: types.USER_EMAIL,
                courseAdded: types.IS_ADDED_USER_COURSE,
                courses: types.ALL_COURSES

            })
        },
        mounted() {





        },
        /*watch: {
            isLogin: function (val) {

                if(val){
                    this.$store.dispatch(types.ADD_COURSE, null);
                    this.getAllCourses()
                }


            },
        },*/

        methods:{

        }
    }
</script>

<style scoped>

</style>