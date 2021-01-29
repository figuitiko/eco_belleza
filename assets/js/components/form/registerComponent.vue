<template>

        <div>
            <b-alert v-if="isUpdated" variant="success" show>Datos actualizados</b-alert>
            <b-form @submit="onSubmit($event)" @reset="onReset"  >
                <b-form-group

                        id="input-group-1"
                        label="Email address:"
                        label-for="input-1"
                        :class="{invalidLabel: $v.emailValue.$error}"

                >

                    <b-form-input
                            id="input-1"
                            v-model="emailValue"
                            type="email"
                            required
                            placeholder="Entrar el  Correo Electrónico"
                            @change="debounceEmail"
                            @input="$v.emailValue.$touch()"
                            :class="{invalid: $v.emailValue.$error}"
                    ></b-form-input>
                    <small class="alert-danger" v-if="errors">El Correo Eléctronico está Duplicado</small>
                    <small class="alert-danger" v-if="!$v.emailValue.required">El Correo Eléctronico es requerido</small>
                    <small class="alert-danger" v-if="!$v.emailValue.email">Entre una dirección de Correo Eléctronico  válida</small>
                </b-form-group>

                <b-form-group id="input-group-2" label="Su nombre:" label-for="input-2"  :class="{invalidLabel: $v.usernameValue.$error}">
                    <b-form-input
                            id="input-2"
                            v-model="usernameValue"
                            required
                            placeholder="Entrar el  Nombre"
                            @input="$v.usernameValue.$touch()"
                            :class="{invalid: $v.usernameValue.$error}"
                    ></b-form-input>
                    <small class="alert-danger" v-if="!$v.usernameValue.required">El nombre de usuario es requerido</small>
                </b-form-group>
                <template v-if="changeIsOnMethod">
                <b-form-group id="input-group-3" label="Su contraseña" label-for="input-2" :class="{invalidLabel: $v.passwordValue.$error}">
                    <b-form-input
                            type="password"
                            id="input-3"
                            v-model="passwordValue"
                            required
                            placeholder="Entrar la contraseña"
                            @input="$v.passwordValue.$touch()"
                            :class="{invalid: $v.passwordValue.$error}"
                    ></b-form-input>
                    <small class="alert-danger" v-if="!$v.passwordValue.required">La contraseña de usuario es requerido</small>
                    <small class="alert-danger" v-if="!$v.passwordValue.minLength">Debe Tener al Menos 8 caracteres</small>
                </b-form-group>
                <b-form-group id="input-group-5" label="Repetir su contraseña" label-for="input-2" :class="{invalidLabel: $v.secondPassword.$error}">
                    <b-form-input
                            type="password"
                            id="input-4"
                            v-model="secondPassword"
                            required
                            placeholder="Entrar la contraseña"
                            @input="$v.secondPassword.$touch()"
                            :class="{invalid: $v.secondPassword.$error}"
                    ></b-form-input>
                    <small class="alert-danger" v-if="!$v.secondPassword.required">La contraseña de usuario es requerido</small>
                    <small class="alert-danger" v-if="!$v.secondPassword.sameAsPassword">No son iguales las contraseñas</small>
                </b-form-group>
                </template>
                <b-button v-if="method === 'put' "class="btn btn-primary" type="button" @click="enablePass()" variant="primary"> {{textOnPass}}</b-button>
                <b-button v-if="method === 'post' " class="my-register" type="submit" :disabled="checkFormValid" variant="primary">Registrar</b-button>
                <b-button v-if="method === 'put' "class="my-register" type="submit"  variant="primary">Actualizar</b-button>
                <b-button v-if="method === 'post' " class="my-reset" type="reset" variant="danger">Resetear</b-button>
            </b-form>

        </div>
    </template>


<script>
    import * as types from "../../modules/types";
    import {required, email, maxLength, numeric, minLength, sameAs} from 'vuelidate/lib/validators';
    import lodash from 'lodash';
    import {mapGetters} from  'vuex';

    export default {
        name: "registerComponent",
        props:['method'],
        data() {
            return {
               secondPassword: '',
                isUpdated: false,
                isVisiblePass: false

            }
        },
        computed:{
            ...mapGetters({
                errors: types.ERRORS_HEADERS_REGISTER,
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
                    return this.$store.dispatch( types.UPDATE_USER_DATA_PASSWORD, value);
                }
            },
            usernameValue: {
                get() {
                    return this.$store.getters[types.USER_NAME];
                },
                set(value) {
                    return this.$store.dispatch( types.UPDATE_USER_DATA_NAME, value);
                }
            },
            checkFormValid(){

                return (this.$v.emailValue.$invalid
                    || this.$v.usernameValue.$invalid
                    || this.$v.passwordValue.$invalid
                    || this.$v.secondPassword.$invalid
                    || (this.errors !== ''));

            },
            changeIsOnMethod(){
                if(this.method === 'post' || this.isVisiblePass ){

                    return true;
                }
            },
            textOnPass(){
                if(this.isVisiblePass){
                    return 'Ocultar Contraseña';
                }else{
                    return 'Cambiar Contraseña'
                }
            },

            ...mapGetters({
                userId: types.USER_ID,
            })
        },
        validations:{
            emailValue:{
                email,
                required
            },
            usernameValue:{
                required
            },
            passwordValue:{
                required,
                minLength: minLength(8)
            },
            secondPassword:{
                required,
                sameAsPassword: sameAs('passwordValue')

            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if(this.method === 'post'){
                    this.axios.post('/api/users', {
                        name: this.$store.getters[types.USER_NAME],
                        email: this.$store.getters[types.USER_EMAIL],
                        password: this.$store.getters[types.USER_PASSWORD]
                    }).then(response =>{
                        console.log(response);

                        this.$bvModal.hide('modal-2');
                        this.$store.dispatch(types.IS_LOGIN_ACTION);
                        this.$store.dispatch(types.UPDATE_USER_DATA_IRI, response.data['@id']);
                        this.$store.dispatch(types.UPDATE_USER_DATA_ID, response.data.id);

                    })
                }
                if(this.method === 'put'){
                    this.axios.put(`/api/users/${this.userId}`, {
                        name: this.$store.getters[types.USER_NAME],
                        email: this.$store.getters[types.USER_EMAIL],
                        password: this.$store.getters[types.USER_PASSWORD]
                    }).then(response =>{
                        console.log(response);
                        this.isUpdated = true;
                        setTimeout(()=>{
                            this.isUpdated = false
                        }, 2000)

                    })
                }

            },
            onReset() {
                this.$store.dispatch(types.ERRORS_HEADERS_REGISTER_ACTION, '');
                this.$store.dispatch(types.UPDATE_USER_DATA_NAME, '');
                this.$store.dispatch(types.UPDATE_USER_DATA_EMAIL, '');
                this.$store.dispatch(types.UPDATE_USER_DATA_PASSWORD, '');
                this.secondPassword = '';


            },

            debounceEmail: lodash.debounce(function (e) {
                console.log(e)
                this.checkEmail(e);
            },3000),
            checkEmail(email){
                this.axios.get(`/api/users?email=${email}&page=1`)
                        .then(response=>{
                            console.log(response);
                           // console.log(response.data['hydra:totalItems']);
                            if(response.data['hydra:totalItems'] !== 0){
                                this.$store.dispatch(types.ERRORS_HEADERS_REGISTER_ACTION, 'Este correo ya está registrado');

                            }else{
                                this.$store.dispatch(types.ERRORS_HEADERS_REGISTER_ACTION, '');
                            }
                        })


            },
            enablePass(){
                console.log('i am here');
                this.isVisiblePass = !this.isVisiblePass;
            }

        }
    }
</script>

<style scoped>

</style>