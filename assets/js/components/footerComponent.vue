<template>
    <footer class=" pb-0">

        <div class="footer-bottom">
            <div class="footer-warp">
                <ul class="footer-menu">
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Privacy</a></li>
                </ul>
                <div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy; {{date}}  All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "footerComponent",
        data(){
           return  {
                 date: new Date().getFullYear()
            }
        }
    }
</script>

<style scoped>

</style>