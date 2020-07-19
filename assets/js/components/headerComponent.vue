<template>
    <div>
        <div id="preloder">
            <div class="loader"></div>
        </div>

        <!-- Header section -->
        <header class="header-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="site-logo">
                            <img src="img/logo.png" alt="">
                        </div>
                        <div class="nav-switch">
                            <i class="fa fa-bars"></i>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">



                        <button  type="button"  class="site-btn-register header-btn" data-toggle="modal" data-target="#exampleModal">Register</button>
                        <button  class="site-btn header-btn">Login</button>
                        <nav class="main-menu">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="courses.html">Courses</a></li>
                                <li><a href="blog.html">News</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page info -->
        <div class="page-info-section set-bg" data-setbg="img/page-bg/1.jpg" >
            <div class="container">
                <div class="site-breadcrumb">
                    <a href="#">Home</a>
                    <span>Courses</span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "headerComponent"
    }
</script>

<style scoped>

</style>