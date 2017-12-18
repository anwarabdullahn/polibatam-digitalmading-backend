

    <div class="col-md-5 col-lg-4">
        <div class="widget">
          <div class="widget-content border-bottom text-dark">
                <span class="pull-right text-muted">{{ Auth::user()->role }}<i class="gi gi-settings pull-right edit-profile" data-toggle="modal" data-target="#edit-profile" data-edit-name="{{ Auth::user()->name}} " data-edit-deskripsi="{{Auth::user()->deskripsi}}"></i></span>
                Featured Author
            </div>
            <div class="widget-image widget-image-sm ">
                <img src="{{asset ('assets/img/placeholders/photos/photo1@2x.jpg') }}" alt="image">
                <div class="widget-image-content text-center">
                    <img src="{{asset ('public/assets/img/placeholders/avatars/') }}/{{Auth::user()->avatar}}" alt="avatar" class="img-circle img-thumbnail img-thumbnail-transparent img-thumbnail-avatar-2x push">
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
                <h4>About</h4>
                <span>{{ Auth::user()->deskripsi }}</span>
            </div>
        </div>
        <div class="col-md-12 col-lg-12">
          <div class="row">
            <a href="javascript:void(0)" class="widget" data-toggle="modal" data-target="#change-password">
              <div class="widget-content themed-background-danger clearfix">
                 <div class="widget-icon pull-right">
                     <i class="gi gi-keys text-light-op"></i>
                 </div>
                 <h2 class="widget-heading h3 text-light"><span class="text-light-op">CHANGE PASSWORD</span></h2>
             </div>
            </a>
            </div>
        </div>
    </div>
