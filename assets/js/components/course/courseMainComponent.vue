<template>
    <div>
        <search-box></search-box>
        <course-list></course-list>
        <call-to-action></call-to-action>
    </div>
</template>

<script>
    import searchBoxComponent from "./searchBoxComponent";
    import courseListComponent from "./courseListComponent";
    import callToActionComponent from "./callToActionComponent";

    export default {
        components:{
            'search-box': searchBoxComponent,
            'course-list': courseListComponent,
            'call-to-action': callToActionComponent
        },
        name: "courseMainComponent"
    }
</script>

<style scoped>

</style>