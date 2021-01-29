<template>
    <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Su carrito</span>
            <span class="badge badge-secondary badge-pill">{{usersCourses.length}}</span>
        </h4>
        <ul class="list-group mb-3">

            <li v-for="userCourse of  usersCourses" :key="userCourse.course.id" class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">{{userCourse.course.title}}</h6>

                </div>
                <span class="text-muted">${{userCourse.course.price}}</span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span>Total (MXN)</span>
                <strong>${{totalPrice}}</strong>
            </li>
        </ul>


    </div>
</template>

<script>
    import {mapGetters} from  'vuex'
    import * as types from "../modules/types";

    export default {
        name: "complementCheckout",
        computed:{
            ...mapGetters({
                usersCourses: types.ALL_USER_COURSES,
                totalPrice: types.TOTAL_PRICE



            }),
        }
    }
</script>

<style scoped>

</style>