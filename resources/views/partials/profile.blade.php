

    <div class="col-md-5 col-lg-4">
        <div class="widget">
          <div class="widget-content border-bottom text-dark">
                <span class="pull-right text-muted">{{ Auth::user()->role }}</span>
                Featured Author
            </div>
            <div class="widget-image widget-image-sm ">
                <img src="{{asset ('assets/img/placeholders/photos/photo1@2x.jpg') }}" alt="image">
                <div class="widget-image-content text-center">
                    <img src="assets/img/placeholders/avatars/{{Auth::user()->avatar}}" alt="avatar" class="img-circle img-thumbnail img-thumbnail-transparent img-thumbnail-avatar-2x push">
                    <h2 class="widget-heading text-light"><strong>{{ Auth::user()->name }}</strong></h2>
                </div>
            </div>

            <div class="widget-content border-bottom">
              <h4>Change Profile Images</h4>
              <div class="row text-center">
                <form class="fieldset-form" action="{{ url('/profile')}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="col-xs-8 push-inner-top-bottom border-right">
                  <input type="file" name="avatar" accept="image/*" />
                  <input type="hidden" name="admin" value="{{Auth::user()->name}}">
                  </div>
                  <div class="col-xs-4 push-inner-top-bottom">
                  <input type="submit" class="btn btn-inline btn-primary pull-right" name="submit" value="SUBMIT" />
                  </div>
                </form>
            </div>
            </div>            
            <div class="widget-content border-bottom">
                <h4>About<i class="gi gi-settings pull-right" data-toggle="modal" data-target="#edit-profile"></i></h4>
                <span>{{ Auth::user()->deskripsi }}</span>
            </div>
            <div class="widget-content widget-content-full border-bottom">
                <div class="row text-center">

                    <div class="col-xs-6 push-inner-top-bottom border-right">
                        <h3 class="widget-heading"><i class="gi gi-heart text-danger push"></i> <br><small><strong>1.5k</strong> Favorites</small></h3>
                    </div>
                    <div class="col-xs-6 push-inner-top-bottom">
                        <h3 class="widget-heading"><i class="gi gi-group themed-color-social push"></i> <br><small><strong>58.6k</strong> Followers</small></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
