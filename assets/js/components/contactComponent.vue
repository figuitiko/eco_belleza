<template>
    <section class="contact-page spad pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form-warp">
                        <div class="section-title text-white text-left">
                            <h2>Contactenos</h2>

                        </div>

                        <form @submit="onSubmit($event)" class="contact-form">
                            <div v-if="isReady" class="alert alert-success">
                                Su mensaje fue enviado <strong>Exitosamente!!</strong>
                            </div>
                            <div  v-if="isError" class="alert alert-danger">
                                Ha ocurrido un error al enviar <strong>Error!!</strong>
                            </div>

                            <input type="text"
                            placeholder="Su nombre"
                            v-model="name"
                            required
                           @input="$v.name.$touch()"
                           :class="{invalid: $v.name.$error}"
                            >
                            <input type="text"
                           placeholder="Su Correo Eléctronico"
                            v-model="emailValue"
                           required
                           @input="$v.emailValue.$touch()"
                           :class="{invalid: $v.emailValue.$error}"
                            >
                            <input type="text"
                               placeholder="Asunto"
                               v-model="subject"
                               required
                               @input="$v.subject.$touch()"
                               :class="{invalid: $v.subject.$error}"
                            >
                            <textarea
                            placeholder="Mensaje"
                            v-model="msg"
                            @input="$v.msg.$touch()"
                            :class="{invalid: $v.msg.$error}"

                            ></textarea>
                            <button :disabled="checkFormValid"  class="site-btn">{{sendText}}</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-area">
                        <div class="section-title text-left p-0">
                            <h2>Informacion de Contacto</h2>

                        </div>
                        <!--<div class="phone-number">
                            <span>Direct Line</span>
                            <h2>+53 345 7953 32453</h2>
                        </div>-->
                        <ul class="contact-list">

                            <li>info@eco-belleza.com</li>
                        </ul>
                        <div class="social-links">
<!--                            <a href="#"><i class="fa fa-pinterest"></i></a>-->
                            <a href="https://www.facebook.com/ecobelleza.class" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.youtube.com/channel/UCJuzwAt7uChAPtomYwXLbjQ" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="https://www.instagram.com/ecobelleza.coach/" target="_blank"><i class="fa fa-instagram"></i></a>
<!--                            <a href="#"><i class="fa fa-twitter"></i></a>-->
                            <!--<a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-behance"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    import {required, email, maxLength, numeric, minLength, sameAs} from 'vuelidate/lib/validators';
    export default {
        name: "contactComponent",
        data(){
            return{
                name:'',
                emailValue: '',
                subject:'',
                msg:'',
                isReady: false,
                isError: false
            }
        },
        validations:{
            emailValue:{
                email,
                required
            },
            name:{
                required
            },
            subject:{
                required
            },
            msg:{
                required
            },
        },
        computed:{
            checkFormValid(){

                return (this.$v.emailValue.$invalid
                    || this.$v.name.$invalid
                    || this.$v.subject.$invalid
                    || this.$v.msg.$invalid
                    );

            },
            sendText(){

                return this.isReady? 'Enviado': 'enviar';
            }

        },
        methods:{
            onSubmit(e){
                e.preventDefault();

                this.axios.post('/api/contact_data/email',{
                    name:this.name,
                    email: this.emailValue,
                    subject: this.subject,
                    msg: this.msg

                }).then(response=>{

                   this.isReady = true;
                   setTimeout(()=>{
                       this.isReady = false;
                       this.name = '';
                       this.emailValue = '';
                       this.subject = '';
                       this.msg = '';
                   }, 2000)

                }).catch(e=>{
                    console.log(e.msg)
                    this.isError = true;
                    setTimeout(()=>{
                        this.isError= false;
                    }, 2000)
                })

            }
        }

    }
</script>

<style scoped>

</style>