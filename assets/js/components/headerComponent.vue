<template>
    <div>
        <div id="preloder">
            <div class="loader"></div>
        </div>
        <div id="preloder-1"  v-if="isLoader">
            <div class="loader"></div>
        </div>

        <!-- Header section -->
        <header class="header-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center"> <span style=" color:white" v-if="isLogin" > Estas logeado  como {{userName}}</span></div>
                    <div class="col-lg-3 col-md-3">
                        <div class="site-logo">
                            <router-link to="/"><img src="img/logo_new.png" alt="" width="60%"></router-link>

                        </div>
                        <div class="nav-switch" v-display-menu>
                            <i class="fa fa-bars"></i>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 ">
                        <nav class="main-menu">
                            <ul>
                                <li> <router-link to="/">Inicio</router-link></li>
<!--                                <li><a href="#">About us</a></li>-->
                                <li v-if="isLogin">
                                <router-link to="/my-courses">Mis Cursos</router-link>
                                </li>
                                <li v-if="isLogin">
                                    <router-link to="/profile">Mi Perfil</router-link>
                                </li>
                                <li> <router-link to="/contact">Contáctenos</router-link></li>
                                <li v-if="isLogin" class="buy-car">
                                    <router-link to="/cart" class=" d-sm-none d-none d-md-block">

                                        <span>{{usersCourses.length}}</span>
                                        <i  class="fa fa-shopping-cart" aria-hidden="true"></i>


                                    </router-link>
                                    <router-link to="/cart" class="d-md-none d-sm-block">

                                        Carrito de compra


                                    </router-link>

                                </li>
                            </ul>
                        </nav>

                    </div>

                    <div class="col-lg-2 col-md-2 d-flex flex-row header-btn-position">
                        <router-link to="/cart" class="  d-md-none">

                            <span>{{usersCourses.length}}</span>
                            <i  class="fa fa-shopping-cart" aria-hidden="true"></i>


                        </router-link>

                        <template v-if="!isLogin">
                            <b-button    class="site-btn-register " v-b-modal.modal-2  >Registrarse</b-button>
                            <b-button  class="site-btn  " v-b-modal.modal-1 >Entrar</b-button>
                        </template>
                        <template v-else>
                            <b-button @click="logOut"    class=" logout-btn "   >Salir</b-button>

                        </template>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page info -->
        <div class="page-info-section set-bg" data-setbg="img/page-bg/bg_irina_new.jpg" >
            <div class="container">
                <div class="site-breadcrumb">

                    <router-link to="/">Inicio</router-link>
                    <transition name="fade"><span>{{currentRoute}}</span></transition>
                </div>
            </div>
        </div>

                <b-modal id="modal-1" title="login" >

                    <div v-if="errors" class="alert alert-danger">
                        {{errors}}
                    </div>

                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1" :class="{invalidLabel: $v.emailValue.$error}">Correo Eléctronico</label>
                            <input v-model="emailValue"
                                   type="email"
                                   class="form-control"
                                   id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder="Entre su Correo"
                                   @input="$v.emailValue.$touch()"
                                   :class="{invalid: $v.emailValue.$error}">
                            <small class="alert-danger" v-if="!$v.emailValue.required">El Correo Eléctronico es requerido</small>
                            <small class="alert-danger" v-if="!$v.emailValue.email">Entre una dirección de Correo Eléctronico  válida</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" :class="{invalidLabel: $v.passwordValue.$error}">Contraseña</label>
                            <input v-model="passwordValue"
                                   type="password"
                                   class="form-control"
                                   id="exampleInputPassword1"
                                   placeholder="Password"
                                   @input="$v.passwordValue.$touch()"
                                   :class="{invalid: $v.passwordValue.$error}">
                        </div>
                        <small class="alert-danger" v-if="!$v.passwordValue.required">La contraseña de usuario es requerido</small>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"  v-model="rememberMe">
                            <label class="form-check-label" for="exampleCheck1">Recordar contraseña</label>
                        </div>

                    </form>
                    <template v-slot:modal-footer="{  cancel }">

                        <!-- Emulate built in modal footer ok and cancel button actions -->
                        <b-button size="sm" class="my-register" variant="success" @click="jsonLogin()" :disabled="checkFormValid">
                            Entrar
                        </b-button>
                        <b-button size="sm" variant="danger" class="my-reset" @click="cancel()">
                            Cancel
                        </b-button>
                        <!-- Button with custom close trigger value -->

                    </template>
                </b-modal>

                <b-modal id="modal-2" title="Registrarste" ok-only ok-variant="secondary" ok-title="Cancel">

                <register-component :method="'post'"></register-component>
                </b-modal>

        <search-box></search-box>

    </div>
</template>

<script>
    import {mapGetters} from  'vuex'
    import * as types from '../modules/types';

    import {required, email, maxLength, numeric, minLength, sameAs} from 'vuelidate/lib/validators';
    import searchBoxComponent from "./course/searchBoxComponent";
    import {mapActions} from 'vuex';

    export default {

        name: "headerComponent",
        components:{  'search-box': searchBoxComponent},
        data(){
            return {
                rememberMe: false,
                isLoader: false
            }

        },
        directives:{
            'display-menu': {
                bind(el, binding, vnode){
                    el.addEventListener('click', function () {
                        let mainMenu = document.querySelector('.main-menu');
                        if(mainMenu.style.display === 'none'){
                            mainMenu.style.display="block";
                        }else {
                            mainMenu.style.display="none";
                        }
                    })

                },
                unbind(el, binding, vnode){
                    el.removeEventListener('click');

                }

            }
        },
        computed: {
            ...mapGetters({
                errors: types.ERRORS_HEADERS_LOGIN,
                isLogin: types.IS_LOGIN,
                userName: types.USER_NAME,
                userEmail: types.USER_EMAIL,
                usersCourses: types.ALL_USER_COURSES,
                courses: types.ALL_COURSES,
                currentPage: types.COURSES_CURRENT_PAGE
            }),
            emailValue: {
                get() {

                    return this.$store.getters[types.USER_EMAIL];
                },
                set(value) {

                       return this.$store.dispatch( types.UPDATE_USER_DATA_EMAIL, value);
                }
            },
            passwordValue: {
                get() {
                    return this.$store.getters[types.USER_PASSWORD];
                },
                set(value) {
                    return this.$store.dispatch(types.UPDATE_USER_DATA_PASSWORD, value);
                }
            },
            checkFormValid(){

                return (this.$v.emailValue.$invalid
                    || this.$v.passwordValue.$invalid
                    );

            },
            currentRoute(){
                switch (this.$route.name) {
                    case 'main':
                        return '';
                    case 'my':
                        return 'Mis cursos';
                    case 'search':
                        return 'Busqueda';
                    case 'lessonSingle':
                        return 'Clases';
                    case 'contact':
                        return 'Contacto';
                    case 'cart':
                        return 'Carrito de compra';
                    case 'courseDetails':
                        return 'Detalles del Curso';
                }

               /* if(this.$route.name === 'main'){
                    return ''
                }
                if(this.$route.name === 'my'){
                    return 'Mis cursos'
                }
                if(this.$route.name === 'search'){
                    return 'Busqueda'
                }
                if(this.$route.name === 'lessonSingle'){
                    return 'Clases'
                }
                if(this.$route.name === 'contact'){
                    return 'Contacto'
                }
                if(this.$route.name === 'cart'){
                    return 'Carrito de compra'
                }
                if(this.$route.name === 'courseDetails'){
                    return 'Detalles del Curso'
                }*/

            }
        },
        watch: {
            currentPage: function (val) {
                console.log('i am on watcher');
                this.isLoader = true;
            setTimeout(()=>{
                this.isLoader = false;
            },300)

            }


        },


        validations:{
            emailValue:{
                email,
                required
            },
            passwordValue:{
                required,

            },
        },


        methods: {
            ...mapActions({
                updateUsername: types.UPDATE_USER_DATA_NAME,
                updateUserEmail: types.UPDATE_USER_DATA_EMAIL,
                updateUserIri: types.UPDATE_USER_DATA_IRI,
                updateUserId: types.UPDATE_USER_DATA_ID,
                addUsersCoursesPayed: types.ADD_USER_COURSES_PAYED_ACTION,
                userCoursesAction: types.ADD_USER_COURSES_ACTION

            }),

            jsonLogin(){

                this.axios.post('/json_login',{
                    email: this.$store.getters[types.USER_EMAIL],
                    password: this.$store.getters[types.USER_PASSWORD],
                    _remember_me: this.rememberMe
                    }
                )
                .then(response => {
                    //console.log(response.headers.location);

                    this.$store.dispatch(types.IS_LOGIN_ACTION);
                    this.$bvModal.hide('modal-1');
                    this.$router.push('/').catch(()=>{});

                    this.axios.get(response.headers.location)
                                .then(response=>{
                                    console.log(response.data)

                                    this.updateUsername(response.data.name)
                                    //this.$store.dispatch(types.UPDATE_USER_DATA_NAME,response.data.name);
                                    this.updateUserEmail(response.data.email);
                                    //this.$store.dispatch(types.UPDATE_USER_DATA_EMAIL,response.data.email);
                                    this.updateUserIri(response.data['@id']);
                                    //this.$store.dispatch(types.UPDATE_USER_DATA_IRI,response.data['@id']);
                                    this.updateUserId(response.data.id);

                                    this.userCoursesAction(response.data.email)



                                   // this.$store.dispatch(types.UPDATE_USER_DATA_ID,response.data.id);
                                   /* if( response.data.courses.length >0){
                                        response.data.courses.forEach(course =>{
                                            this.$store.dispatch(types.ADD_USER_COURSE,course);
                                        })
                                    }else {

                                        this.$store.dispatch(types.ADD_USER_COURSE, null);
                                    }*/
                                 /*   if(this.isLogin){


                                        this.courses.forEach(course=>{
                                            this.getAllUsersCourses(this.userEmail, course.id)
                                        })
                                        this.addUsersCoursesPayed(this.userEmail);
                                        //this.getAllUsersCourses(userJson.email, )
                                    }*/

                                })
                    })
                    .catch(err=>{

                       if(err.response.data.error){

                              this.$store.dispatch(types.ERRORS_HEADERS_LOGIN_ACTION, err.response.data.error)

                       }else {

                            this.$store.dispatch(types.ERRORS_HEADERS_LOGIN_ACTION, 'Error Desconocido')
                       }
                    })
            },
            openMenu(){
               let mainMenu = document.querySelector('.main-menu');
               console.log(mainMenu);

               if(mainMenu.style.display === 'none'){
                   mainMenu.style.display="block";
               }else {
                   mainMenu.style.display="none";
               }
            },
            logOut(){
                location.href= '/logout'
            }

        }
    }
</script>

<style scoped>

</style>