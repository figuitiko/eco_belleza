<template>
    <div>
    <call-to-action v-if="!isLogin"></call-to-action>
    <footer class=" pb-0">

        <div class="footer-bottom">
            <div class="footer-warp">
                <ul class="footer-menu">
                    <li><a href="https://eco-belleza.com/privacy-policy/" target="_blank">Políticas de Privacidad</a></li>
                    <li><a href="#" v-b-modal.modal-2>Register</a></li>

                </ul>
                <div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy; {{date}}  Todos los Derechos Reservados  | Ecobelleza
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