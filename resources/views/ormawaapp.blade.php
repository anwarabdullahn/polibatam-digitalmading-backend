<!DOCTYPE html>
<html class="no-js" lang="en">
@include('partials.head')
<body>
  <div id="page-wrapper" class="page-loading">
    <div class="preloader">
      <div class="inner">
        <div class="preloader-spinner themed-background hidden-lt-ie10"></div>
        <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
      </div>
    </div>
    <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
      @include('partials.asideormawa')
    </div>
    <!-- Main Container -->
    <div id="main-container">
      <header class="navbar navbar-inverse navbar-fixed-top">
        <!-- Left Header Navigation -->
        <ul class="nav navbar-nav-custom">
          <!-- Main Sidebar Toggle Button -->
          <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
              <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
              <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
          </li>
          <!-- END Main Sidebar Toggle Button -->
        </ul>
        <!-- END Left Header Navigation -->

      </header>
      <!-- END Header -->

      <!-- Page content -->
      <div id="page-content">
        <div class="col-lg-12">
          @if (session('info'))
            <div class="row">
              <div class="alert alert-success display-show" class="close" data-dismiss="alert">
                {{session('info')}}
              </div>
            </div>
          @elseif (session('gagal'))
            <div class="row">
              <div class="alert alert-danger display-show" class="close" data-dismiss="alert">
                {{session('gagal')}}
              </div>
            </div>
          @endif
        </div>
        <div class="row">
          {!! Charts::styles() !!}
          <div class="col-md-7 col-lg-8">
            <div class="row">
              <div class="col-sm-6 col-lg-6">
                <a href="javascript:void(0)" class="widget">
                  <div class="widget-content themed-background-social clearfix">
                    <div class="widget-icon pull-right">
                      <i class="fa fa-pencil text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-light"><span data-toggle="counter" data-to="{{$announcement}}"></span></h2>
                    <span class="text-light-op">PENGUMUMAN</span>
                  </div>
                </a>
              </div>
              <div class="col-sm-6 col-lg-6">
                <a href="javascript:void(0)" class="widget">
                  <div class="widget-content themed-background-flat clearfix">
                    <div class="widget-icon pull-right">
                      <i class="fa fa-gift text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-light"><span data-toggle="counter" data-to="{{$event}}"></span></h2>
                    <span class="text-light-op">EVENT</span>
                  </div>
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-lg-6">
                <a href="javascript:void(0)" class="widget">
                  <div class="widget-content themed-background-creme clearfix">
                    <div class="widget-icon pull-right">
                      <i class="fa fa-newspaper-o text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-light"><span data-toggle="counter" data-to="{{$banner}}"></span></h2>
                    <span class="text-light-op">BANNER</span>
                  </div>
                </a>
              </div>

              <div class="col-sm-6 col-lg-6">
                <a href="javascript:void(0)" class="widget">
                  <div class="widget-content themed-background-amethyst clearfix">
                    <div class="widget-icon pull-right">
                      <i class="gi gi-group text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-light"><span data-toggle="counter" data-to="{{$mahasiswa}}"></span></h2>
                    <span class="text-light-op">MAHASISWA</span>
                  </div>
                </a>
              </div>
            </div>
            <div class="block full">
              <!-- Block Tabs Title -->
              <div class="block-title">
                <div class="block-options pull-right">
                </div>
                <ul class="nav nav-tabs" data-toggle="tabs">
                  <li class="active"><a href="#profile-activity">Activity</a></li>
                </ul>
              </div>
              <!-- Main Application (Can be VueJS or other JS framework) -->
              <div class="app">
                <center>
                  {!! $chart->html() !!}
                </center>
              </div>
              <!-- End Of Main Application -->
              {!! Charts::scripts() !!}
              {!! $chart->script() !!}
              <!-- END Block Tabs Title -->
            </div>
          </div>
          @include('partials.profile')
        </div>
        <div class="row">

          <div class="col-lg-6">
            <div class="widget">
              <div class="widget-content widget-content-mini themed-background-dark-default text-light text-center">
                <i class="fa fa-bar-chart-o"></i> <strong> 5 Last Announcement</strong>
              </div>
              <div class="block full">
                <div class="table-responsive">
                  <table  class="table table-borderless table-hover">
                    <thead>
                      <tr>
                        <th style="width: 280px">Judul</th>
                        <th class="text-center" style="width: 100px;">Penerbit</th>
                        <th class="text-center" style="width: 100px;">Kategori</th>
                        <th class="text-center" style="width: 150px;">Tanggal diterbitkan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($lastAnnouncement as $index=> $announcement)
                        <tr>
                          <td style="width: 280px"> {{ $announcement->title }} </td>
                          <td class="text-center" style="width: 100px;"> {{ $announcement->user->name }} </td>
                          <td class="text-center" style="width: 100px;"> {{ $announcement->category->name }} </td>
                          <td class="text-center" style="width: 150px;"> {{ $announcement->created_at  }} </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="widget">
              <div class="widget-content widget-content-mini themed-background-dark-default text-light text-center">
                <i class="fa fa-bar-chart-o"></i> <strong> 5 Last Event</strong>
              </div>
              <div class="block full">
                <div class="table-responsive">
                  <table  class="table table-borderless table-hover">
                    <thead>
                      <tr>
                        <th tyle="width: 230px;">Judul</th>
                        <th class="text-center" style="width: 100px;">Penerbit</th>
                        <th class="text-center" style="width: 150px;">Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($lastEvent as $index=> $event)
                        <tr>
                          <td tyle="width: 230px;"> {{ $event->title }} </td>
                          <td class="text-center" style="width: 100px;"> {{ $event->user->name }} </td>
                          <td class="text-center" style="width: 150px;"> {{ $event->date  }} </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- END Page Content -->
    </div>
    <!-- END Main Container -->
  </div>
  <div class="modal fade" id="edit-profile">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <form class="fieldset-form" action="{{ url('/profile')}}" method="post">
              {{ csrf_field() }}
              <fieldset>
                <legend class="text-center" style="color: #33577A; font-size: 21px !important;">ABOUT</legend>
                @foreach ($errors->add->all() as $error)
                  <div class="alert alert-danger display-show">
                    {{ $error }}
                  </div>
                  @break
                @endforeach
                <div class="form-group">
                  <label class="form-label">Name</label>
                  <input type="text" id="input-name-edit" class="form-control" name="name" value="{{old('name')}}">
                </div>
                <div class="form-group">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" id="input-description-edit" contenteditable rows="3" name="description" placeholder="Type your description..." value="">{{old('description')}}</textarea>
                </div>
                <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
                <input type="hidden" name="admin" value="{{Auth::user()->name}}">
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="change-password">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <form class="fieldset-form" action="{{ url('/password')}}" method="post">
              {{ csrf_field() }}
              <fieldset>
                <legend class="text-center" style="color: #33577A; font-size: 21px !important;">CHANGE PASSWORD</legend>
                @foreach ($errors->edit->all() as $error)
                  <div class="alert alert-danger display-show">
                    {{ $error }}
                  </div>
                  @break
                @endforeach
                <div class="form-group">
                  <label class="form-label">OLD PASSWORD</label>
                  <input type="password" class="form-control" name="oldpassword" >
                </div>
                <div class="form-group">
                  <label class="form-label">NEW PASSWORD</label>
                  <input type="password" class="form-control" name="newpassword" >
                </div>
                <div class="form-group">
                  <label class="form-label">RETYPE NEW PASSWORD</label>
                  <input type="password" class="form-control" name="renewpassword" >
                </div>
                <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
                <input type="hidden" name="admin" value="{{Auth::user()->name}}">
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- END Page Container -->
</div>
@include('partials.footer')

@if (count($errors->edit) > 0)
  <script type="text/javascript"> $('#change-password').modal('show');</script>
@endif

<script src="{{asset ('assets/js/pages/readyDashboard.js') }}"></script>
<script>$(function(){ ReadyDashboard.init(); });</script>

<script type="text/javascript">
$(document).on('click' , '.edit-profile', function(){
  $('#input-name-edit').val($(this).data('edit-name'));
  $('#input-description-edit').html($(this).data('edit-deskripsi'));
});
</script>
</body>
</html>
