<template>
    <section class="search-section ss-other-page">
        <div class="container">
            <div class="search-warp">
                <div class="section-title text-white">
                    <h2><span>Buscar Cursos</span></h2>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8 d-flex justify-content-center">
                        <!-- search form -->
                        <form class="course-search-form">
                            <input type="text" placeholder="Curso" v-model="title">

                            <button class="site-btn btn-dark" @click.prevent="getSearch">Buscar Curso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "searchBoxComponent",
        data(){
            return {
                title: ''
            }
        },
        methods:{
            getSearch(){
                this.$router.push({ name: 'search', query: { title: this.title } })
            }
        }
    }
</script>

<style scoped>

</style>