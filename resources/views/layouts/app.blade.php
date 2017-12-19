<!DOCTYPE html>
<html class="no-js" lang="en">
    @include('partials.head')
    <body>
        <!-- Full Background -->
        <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
        <img src="{{asset ('assets/img/placeholders/layout/lock_full_bg.jpg') }}" alt="Full Background" class="full-bg full-bg-bottom animation-pulseSlow">
        <!-- END Full Background -->

        <!-- Login Container -->
        <div id="login-container">
            <!-- Lock Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <i class="fa fa-cube"></i> <strong>DigitalMading</strong>
            </h1>
            <!-- Login Block -->
        </div>
        <!-- END Login Container -->
        @include('partials.footer')
        @include('sweetalert::cdn')
        @include('sweetalert::view')

        <script>
        $(document).ready(function() {
            swal({
            title: "Error",
            text: "wrong user or password",
            type: "error"
            },
            function(){
            window.close();
            });
        </script>

    </body>
</html>
