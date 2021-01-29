<template>
   <div class="container mt-5">
       <div class="row">
           <div class="col-md-12">
               <b-alert :show="isAddedValue"

                        variant="success"

               >Se ha pagado exitoxamente

               </b-alert>
               <b-alert :show="notWasAdded"

                        variant="success"

               >No se aprobó su pago

               </b-alert>
           </div>

        <div class="col-md-8">
      <b-card>


       <b-form id="pay" name="pay" @submit="submitForm" ref="myForm">
           <!--<b-form-group
                   id="label_description"
                   label="Descripción"
                   label-for="description"

           >
               <b-form-input
                       id="description"
                       type="text"
                       name="description"
                       required
                       placeholder="Item Seleccionado"

               ></b-form-input>
           </b-form-group>-->
           <!--<b-form-group
                   id="label_transaction_amount"
                   label="Monto a pagar"
                   label-for="transaction_amount"

           >
               <b-form-input
                       id="transaction_amount"

                       type="text"
                       name="transaction_amount"
                       required
                       placeholder="Monto a pagar"
                       v-model="totalPrice"

               ></b-form-input>
           </b-form-group>-->
           <b-form-group
                   id="label_cardNumber"
                   label="Número de la tarjeta"
                   label-for="cardNumber"

           >
               <b-form-input
                       id="cardNumber"

                       type="text"
                       name="cardNumber"
                       required
                       placeholder="xxxx-xxxx-xxxx"

                       v-model="form.card"
                       @keyup="guessPaymentMethod($event)"
                       @change="guessPaymentMethod($event)"
                       data-checkout="cardNumber"


               ></b-form-input>
           </b-form-group>


               <b-form-row class="mb-3">
                   <b-col>
                       <label for="cardExpirationMonth">Mes de Vencimiento</label>
                       <b-form-select
                           id="cardExpirationMonth"
                           name="cardExpirationMonth"
                           type="text"
                           required
                           placeholder="mes de vencimiento"
                           data-checkout="cardExpirationMonth"
                           :options="months"




                   ></b-form-select></b-col>
                   <b-col>
                       <label for="cardExpirationYear">Año de Vencimiento</label>
                       <b-form-select
                           id="cardExpirationYear"
                           name="cardExpirationYear"
                           type="text"
                           required
                           placeholder="Año de vencimiento"
                           data-checkout="cardExpirationYear"
                            :options="years"
                           v-model="form.year"




                   ></b-form-select></b-col>
                   <b-col>
                       <label for="securityCode">Código de Seguridad</label>
                       <b-form-input
                               id="securityCode"
                               name="securityCode"
                               type="text"
                               required
                               placeholder="Código de Seguridad"
                               data-checkout="securityCode"
                               @copy.prevent
                               @paste.prevent
                               @cut.prevent
                               v-model="form.code"
                       ></b-form-input>

                   </b-col>
               </b-form-row>
           <b-form-group id="input-group-4">
               <b-form-checkbox-group  id="checkboxes-4">
                   <b-form-checkbox value="me" @change="isTheSameData()">Son mis datos</b-form-checkbox>

               </b-form-checkbox-group>
           </b-form-group>
           <b-form-group
                   id="label_cardholderName"
                   label="Nombre y apellido"
                   label-for="cardholderName"

           >
               <b-form-input
                       id="cardholderName"

                       type="text"
                       name="cardholderName"
                       required
                       placeholder="Su Nombre y Apellidos"
                       data-checkout="cardholderName"

                      v-model="form.userName"


               ></b-form-input>
           </b-form-group>

               <!--<b-form-group
                       id="label_installments"
                       label="Cuotas"
                       label-for="installments"

               >
                   <b-form-select
                           id="installments"
                           name="installments"

                           required
                           ref="installments"

                   ></b-form-select>
               </b-form-group>-->



                       <input type="hidden" name="transaction_amount" id="transaction_amount" :value="totalPrice"/>
                       <input type="hidden" name="description" id="description" value="test description"/>
                       <input type="hidden" name="installments" id="installments" data-checkout="installments"/>
                       <input type="hidden" name="docType" id="docType" data-checkout="docType"/>
                       <input type="hidden" name="docNumber" id="docNumber" data-checkout="docNumber"/>

                <b-form-group
                       id="label_email"
                       label="Correo Eléctronico"
                       label-for="email"

               >
                   <b-form-input
                           id="email"
                           name="email"
                           type="text"
                           required
                           placeholder="Correo Eléctronico"
                           v-model="form.email"
                   ></b-form-input>
               </b-form-group>
           <input type="hidden" name="payment_method_id" id="payment_method_id" v-model="paymentMethod"/>
           <b-button type="submit" class="float-right" variant="primary">Pagar</b-button>

       </b-form>
      </b-card>





        </div>
           <complement-checkout></complement-checkout>


    </div>
       <div>
           <b-img src="img/Visa-MasterCard-1024x393.png" fluid alt="Responsive image" width="99%"></b-img>
       </div>
</div>


</template>

<script>
    import complementCheckout from "./complementCheckout";
    import {mapGetters, mapActions} from  'vuex'
    import * as types from "../modules/types";
    import router from "../routes";

    window.Mercadopago.setPublishableKey("TEST-088e0f9e-bb64-49bc-ab64-610b368b1130");
    export default {

        name: "checkoutComponent",
        components:{'complement-checkout': complementCheckout},
        data() {
            return {
                months: [{
                    text:'Seleccione',
                    value: null
                },
                {
                    text: 'Enero',
                    value: '01'
                },
                {
                    text: 'Febrero',
                    value: '02'
                },
                {
                    text: 'Marzo',
                    value: '03'
                },
                {
                    text: 'Abril',
                    value: '04'
                },
                ],
                years: ['Seleccione','2020', '2021', '2022'],
                form: {
                    card:'',
                    month: '',
                    year: 'Seleccione',
                    code: '',
                    username: '',
                    email:''



                },

                paymentMethod: '',
                transactionAmount:'',
                doSubmit: false,
                userName:'',
                email:'',
                isAddedValue: false,
                notWasAdded: false


            }
        },
        computed:{
            ...mapGetters({
                totalPrice: types.TOTAL_PRICE,
                userNameGetter: types.USER_NAME,
                emailGetter: types.USER_EMAIL,
                usersCourses: types.ALL_USER_COURSES,
                isLogin: types.IS_LOGIN



            }),
        },
        beforeRouteEnter(to, from, next){
            console.log('i am here on checkout');
            next(vm=>{

                if(!vm.isLogin){

                    router.push({ path: '/' })
                }

            })
        },

        mounted() {
            console.log('testing ref',this.$refs.installments);
            console.log(this.usersCourses);

            this.updateTotalPrice();


        },

        methods: {
            ...mapActions({
                updateTotalPrice: types.UPDATE_TOTAL_PRICE_ACTION,
                resetUsersCourses: types.RESET_USER_COURSES_ACTION,
                addUsersCoursesPayed: types.ADD_USER_COURSES_PAYED_ACTION


            }),
            guessPaymentMethod(e) {
                let bin = this.form.card.substring(0, 6)
                window.Mercadopago.getPaymentMethod({
                    "bin": bin
                }, this.setPaymentMethod);

            },
            setPaymentMethod(status, response) {
                if (status == 200) {
                    let paymentMethodId = response[0].id;


                    this.paymentMethod = paymentMethodId
                    this.getInstallments();
                } else {
                    console.dir(`payment method info error: ${response}`);
                }
            },
            getInstallments() {

                window.Mercadopago.getInstallments({
                    "payment_method_id": this.paymentMethod,
                    "amount": parseFloat(this.transactionAmount)

                }, function (status, response) {
                    if (status == 200) {
                      // document.getElementById('installments').options.length = 0;
                       // self.$el.getElementById('installments').options.length = 0;
                        response[0].payer_costs.forEach(installment => {
                           /* let opt = document.createElement('option');
                            opt.text = installment.recommended_message;
                            opt.value = installment.installments;
                            document.getElementById('installments').appendChild(opt);*/
                            document.getElementById('installments').value=installment.installments
                        });
                    } else {
                        alert(`installments method info error: ${response}`);
                    }
                });

            },
            submitForm(evt){
                evt.preventDefault();
                this.doPay()

            },
            doPay(){
                if(!this.doSubmit){
                   console.log(this.$refs.myForm)
                    window.Mercadopago.createToken(this.$refs.myForm, this.sdkResponseHandler);

                    return false;

                }

            },
            sdkResponseHandler(status, response){
                if (status != 200 && status != 201) {
                    alert("verify filled data");
                }else{
                    let form = this.$refs.myForm;
                    let card = document.createElement('input');
                    card.setAttribute('name', 'token');
                    card.setAttribute('type', 'hidden');
                    card.setAttribute('value', response.id);
                    form.appendChild(card);
                    this.doSubmit=true;
                   // form.submit();

                    let jsonData = this.transformFormData(form)


                    this.paymentRequest(jsonData);

                }

            },
            paymentRequest(data){

                this.axios.post('/payment',data)
                    .then(response=>{
                        console.log(response.data.data);
                        if(response.data.data === 'approved'){
                            this.isAddedValue = true;
                            setTimeout(()=>{
                                this.isAddedValue = false;
                            }, 3000);


                            this.usersCourses.forEach(userCourse=>{
                                this.updateIsPayed(userCourse.id);

                            })



                        }
                    })
            },
            transformFormData(form){
                let data= new FormData(form);
                let jsonData = {};
                data.forEach(function (value, key) {
                    jsonData[key]= value;
                })
                return  jsonData
            },
            isTheSameData(){
                console.log('i am cheking checkbox')
                this.form.username = this.userNameGetter;
                this.form.email = this.emailGetter
            },
            resetFormAndData(){
                this.form.username= '';
                this.form.email= '';
                this.form.code = '';
                this.form.year= 'Seleccione';
                this.form.month= null;

                this.resetUsersCourses();
                this.updateTotalPrice();

            },
            updateIsPayed(id){
                this.axios.put(`/api/user_courses/${id}`, {
                    isPayed: true
                })
                .then(response=>{
                    console.log(response);

                    this.addUsersCoursesPayed(this.emailGetter)
                    this.resetFormAndData();
                }).catch(e=>{
                    console.log(e.message)
                })
            }
        }
    }


</script>

<style scoped>

</style>