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
    <!-- Reminder Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
      <i class="fa fa-cube"></i> <strong>DigitalMading</strong>
    </h1>
    <!-- END Reminder Header -->

    <!-- Reminder Block -->
    <div class="block animation-fadeInQuickInv">
      <!-- Reminder Title -->
      <div class="block-title">
        <h2>Set New Password</h2>
      </div>
      <!-- END Reminder Title -->

      <!-- Reminder Form -->
      <form action="{{ url('/forget')}}" method="post" class="form-horizontal">
        {{ csrf_field() }}
        @foreach ($errors->forget->all() as $error)
          <div class="alert alert-danger display-show">
            {{ $error }}
          </div>
          @break
        @endforeach
        <div class="form-group">
          <div class="col-xs-12">
            <input type="password" name="newpassword" class="form-control" placeholder="New Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input type="password" name="renewpassword" class="form-control" placeholder="retype - New Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input type="password" name="rerenewpassword" class="form-control" placeholder="retype - New Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input type="hidden" name="nim" class="form-control" value="{{$nim}}">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input type="hidden" name="code" class="form-control" value="{{$code}}">
          </div>
        </div>
        <div class="form-group form-actions">
          <div class="col-xs-12 text-right">
            <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Set Password</button>
          </div>
        </div>
      </form>
      <!-- END Reminder Form -->
    </div>
    <!-- END Reminder Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
      <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank">AppUI 2.7</a></small>
    </footer>
    <!-- END Footer -->
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
