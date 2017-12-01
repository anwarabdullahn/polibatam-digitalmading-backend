<!DOCTYPE html>
<html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        @include('partials.head')
    <body>
        <!-- Login Container -->
        <div id="login-container">
            <!-- Login Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <i class="fa fa-cube"></i> <strong>DigitalMading</strong>
            </h1>
            <!-- END Login Header -->

            <!-- Login Block -->
            <div class="block animation-fadeInQuickInv">
                <!-- Login Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="{{ route('password.request') }}" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Forgot your password?"><i class="fa fa-exclamation-circle"></i></a>                        
                    </div>
                    <h2>Please Login</h2>
                </div>
                <!-- END Login Title -->

                <!-- Login Form -->
                <form id="form-login" method="POST" action="{{ route('login')}}" class="form-horizontal">
                  {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                          <input id="email" type="email" class="form-control" placeholder="Your Email" name="email" value="{{ old('email') }}" required autofocus>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                          <input id="password" type="password" placeholder="Your Password" class="form-control" name="password" required>

                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8">
                            <label class="csscheckbox csscheckbox-primary">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span></span>
                            </label>
                            Remember Me?
                        </div>
                        <div class="col-xs-4 text-right">
                            <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Let's Go</button>
                        </div>
                    </div>
                </form>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="https://www.facebook.com/anwarabdullahn" target="_blank">Author</a></small>
            </footer>
            <!-- END Footer -->
        </div>
        @include('partials.footer')
    </body>
</html>
