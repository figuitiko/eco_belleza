<template>
    <div>
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Carrito de Compras</h1>
            </div>
        </section>

        <div class="container mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col"> Imagen</th>
                                <th scope="col">Producto</th>


                                <th scope="col" class="text-right">Precio</th>
                                <th ></th>

                            </tr>
                            </thead>


                            <transition-group tag="tbody" name="fade">
                            <tr v-for="userCourse in usersCourses" :key="userCourse.course.id">

                                <td><img :src="'uploads/images/courses/'+userCourse.course.image"  width="16px" height="16px"/></td>
                                <td>{{userCourse.course.title}}</td>
                                <td>{{userCourse.course.price}}</td>
                                <td class="text-right"><button class="btn btn-sm btn-danger" @click="removeUserCourse(userCourse.id)"><i class="fa fa-trash"></i> </button> </td>

                            </tr>
                            </transition-group>




                        </table>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="row">
                        <div class="col-sm-12  col-md-6">
                            <button class="btn btn-block btn-light" @click="goHome()" >Continua Comprando</button>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <button class="btn btn-lg btn-block btn-success text-uppercase" @click="showPayment()" :disabled="!isAvailable">{{isShowPayment? 'atras': 'Compra aqui'}}</button>
                        </div>
                    </div>
                    <transition name="fade">
                    <div v-if="isShowPayment">
                        <div class="row">
                            <div class="col-sm-12  col-md-6 offset-6 mb-1">
                                <button class="btn btn-block btn-mpay" @click="goMercadoPago()">Mercado Pago<img class="ml-1" src="img/mercado_pago.png" width="15%"></button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12  col-md-6 offset-6">
                                <button class="btn-ppay btn btn-block " @click="goPayPalUrl()" >Compra Paypal <img class="ml-1"  src="img/paypal.png" width="13%"> </button>
                            </div>

                        </div>
                    </div>
                    </transition>
                </div>



            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters ,mapActions} from  'vuex';

    import * as types from "../modules/types";
    import router from "../routes";
    import usersCourses from "../modules/usersCourses/usersCourses";

    export default {
        name: "cartComponent",

        data(){
            return{
                urlMercadoPago:'',
                urlPayPal:'',
                isShowPayment: false,
                usersCoursesId: [],
                preferenceId:'',
                paypalToken: '',
                isAvailable: false


            }
            },
        computed:{
            ...mapGetters({
                usersCourses: types.ALL_USER_COURSES,
                isLogin: types.IS_LOGIN,
                totalPrice: types.TOTAL_PRICE,
                userIri: types.USER_IRI
            }),

        },
        beforeRouteEnter(to, from, next){

            next(vm=>{
                console.log(from.name)
                if(!vm.isLogin || !from.name  ){

                    router.push({ path: '/' })
                }else{
                    vm.updateTotalPrice()
                    vm.askPreferenceInit();
                    vm.payPalRequestInit();
                }


            })


        },
        mounted() {
            console.log(this.usersCourses);
            if(this.usersCourses.length >0 ){
                this.isAvailable = true;
                this.usersCourses.forEach(userCourse =>{
                    this.usersCoursesId.push(userCourse['@id']);
                })
                console.log(this.usersCoursesId);
            }

        },





        methods:{
            ...mapActions({
                updateTotalPrice: types.UPDATE_TOTAL_PRICE_ACTION
            }),



            removeUserCourse(userCourseId){
                this.axios.delete(`/api/user_courses/${userCourseId}`)
                    .then(response=>{
                        console.log(response);
                        this.$store.dispatch(types.REMOVE_USER_COURSES_ACTION, userCourseId)
                        this.isAvailable = false;
                        this.isShowPayment = false;

                    })
            },
            goHome(){
                router.push('/')
            },
            goMercadoPago(){

               this.addOrder(true, false, '', this.preferenceId);

                window.open(this.urlMercadoPago);
            },
            goPayPalUrl(){
                this.addOrder(false, true, this.paypalToken, '');
                window.open(this.urlPayPal);
            },
            addOrder(mercadoPago, payPal,paypalToken, referenceId){
                this.axios.post('/api/orders',{
                    isPaypal: payPal,
                    isMercadoPago: mercadoPago,
                    price: this.totalPrice,
                    usersCourses: this.usersCoursesId,
                    tokenPayPal: paypalToken,
                    refIdMercado: referenceId,
                    user: this.userIri

                }).then(response=>{
                    console.log(response)
                })
            },
            showPayment(){
                this.isShowPayment = ! this.isShowPayment;
            },
            askPreferenceInit(){

                this.axios.post('/payment-pro', {
                    'transaction_amount': this.totalPrice,
                    'amount': this.usersCourses.length
                })
                .then(response=>{
                    console.log(response.data.url);
                    this.urlMercadoPago= response.data.url;
                    this.preferenceId= response.data.id;

                }).catch(e=>{
                    console.log(e.message)
                })

            },
            payPalRequestInit(){
                this.axios.post('/paypal-pro', {
                    'transaction_amount': this.totalPrice
                })
                .then(response=> {
                    console.log(response.data.url);
                    this.urlPayPal = response.data.url;
                    this.paypalToken = response.data.id;
                }).catch(e=>{
                    console.log(e.message)
                })
            }

        }


    }
</script>

<style scoped>

</style>