import Vue from 'vue';
import VueRouter from 'vue-router';

import courseListComponent from "./components/course/courseListComponent";
import courseMainComponent from "./components/course/courseMainComponent";


import courseMyComponent from "./components/course/courseMyComponent";
import contactComponent from "./components/contactComponent";
import cartComponent from "./components/cartComponent";
import approvedComponent from "./components/approvedComponent";
import courseDetailsComponent from "./components/course/courseDetailsComponent";
import lessonSingleComponent from "./components/lessons/lessonSingleComponent";
import searchResults from "./components/searchResults";
import profileComponent from "./components/profile/profileComponent";






const router = new VueRouter({
    mode:'history',
    routes:[
        {path:'/', name:'main', component:courseMainComponent},
        {path:'/course/:id', name:'courseDetails', component:courseDetailsComponent},
        {path:'/my-courses', name:'my', component:courseMyComponent},
        {path:'/search', name:'search', component:searchResults},
        {path: '/course/lesson/:id', name: 'lessonSingle', component: lessonSingleComponent },

        {path:'/contact', name:'contact', component:contactComponent},
        {path:'/cart', name:'cart', component:cartComponent},
        {path:'/profile', name:'profile', component:profileComponent},

    ]
});

export default router;