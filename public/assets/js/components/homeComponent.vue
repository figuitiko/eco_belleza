<template>
    <div>
        <my-header></my-header>

        <transition name="page" mode="out-in">
        <router-view :key="$route.fullPath"></router-view>
        </transition>

        <my-footer  :key="userId"></my-footer>
    </div>

</template>

<script>
    import * as types from "../modules/types";
    import {mapGetters} from  'vuex';
    export default {
        name: "homeComponent",
        props: ['user'],
        data(){
            return {
                userId: 0
            }
        },
        computed: {
            ...mapGetters({

                isLogin: types.IS_LOGIN,
                userEmail:types.USER_EMAIL


            })
        },

        mounted() {

            let userJson = JSON.parse(this.user);
            console.log(this.user);
            if( userJson){

                this.$store.dispatch(types.UPDATE_USER_DATA_NAME,userJson.name );
                this.$store.dispatch(types.UPDATE_USER_DATA_EMAIL,userJson.email );
                this.$store.dispatch(types.ADD_USER_COURSES_ACTION, userJson.email )
                this.$store.dispatch(types.UPDATE_USER_DATA_IRI,`/api/users/${userJson.id}` );
                /* userJson.courses.forEach(course=>{
                     this.$store.dispatch(types.ADD_USER_COURSE,course );
                 });*/
                this.$store.dispatch(types.IS_LOGIN_ACTION);


               // this.$store.dispatch(types.ADD_USER_COURSES_PAYED_ACTION, this.userEmail)


            }


        },
        methods:{


        }
    }
</script>

<style scoped>

</style>