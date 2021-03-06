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
      @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
        @include('partials.asideadmin')
        <li class="sidebar-separator">
          <i class="fa fa-ellipsis-h"></i>
        </li>
        @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
          <li>
            <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-pencil sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Pengumuman</span></a>
            <ul>
              <li>
                <a href="{{url('/announcement')}}">Pengumuman</a>
              </li>
              <li>
                <a href="{{url('/announcement/category')}}">Kategori</a>
              </li>
            </ul>
          </li>
        @endif
        <li >
          <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-gift sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Management Event</span></a>
          <ul>
            <li>
              <a href="{{url('/event')}}">Event</a>
            </li>
          </ul>
        </li>
        @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
          <li>
            <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-group sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Management Akun</span></a>
            <ul>
                @if (Auth::user()->role == 'super')
                <li>
                  <a href="{{url('/admin')}}">Admin</a>
                </li>
                @endif
                <li>
                  <a href="{{url('/ormawa')}}">Ormawa</a>
                </li>
                <li>
                  <a href="{{url('/mahasiswa')}}">Mahasiswa</a>
                </li>
            </ul>
          </li>
        @endif
        <li>
          <a class="active" href="{{url('/banner')}}"><i class="fa fa-newspaper-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Banner</span></a>
        </li>
        @if (Auth::user()->role == 'super')
        <li>
          <a href="{{url('/kuesioner')}}"><i class="fa fa-tasks sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Kuesioner</span></a>
        </li>
        @endif
        <li>
          <a href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="hi hi-off sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
    <!-- END Sidebar Navigation -->
  </div>
  <!-- END Sidebar Content -->
</div>
<!-- END Wrapper for scrolling functionality -->
@else @include('partials.asideormawa')
@endif
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
    <div class="content-header">
      <div class="row">
        <div class="col-sm-6">
          <div class="header-section">
            <h1>Banner</h1>
          </div>
        </div>
        <div class="col-sm-6 hidden-xs">
          <div class="header-section">
            <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-banner"><i class="fa fa-plus-circle"></i>Tambah Banner</button>
          </div>
        </div>
      </div>
    </div>
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
    <div class="block full">
      <div class="table-responsive">
        <table id="bannertable" class="table table-borderless table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">NO</th>
              <th style="width: 300px;">Judul</th>
              <th class="text-center" style="width: 180px;">Penerbit</th>
              <th class="text-center" style="width: 140px;">Tanggal dibuat</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-center" style="width: 180px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($banners as $index=> $banner)
              <tr>
                <td class="text-center" style="width: 50px;"> {{ $index+1 }} </td>
                <td style="width: 300px;"> {{ $banner->title }} </td>
                <td class="text-center" style="width: 180px;">{{ $banner->user->name }}</td>
                <td class="text-center" style="width: 140px;"> {{ $banner->created_at }} </td>
                <td class="text-center" style="width: 100px;"> {{ $banner->status }} </td>
                <td class="text-center" style="width: 180px;"><div class="btn-group pull-right" role="group"><button type="button" class="edit-banner btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-banner" data-edit-id="{{$banner->id}}" data-edit-title="{{$banner->title}}" data-edit-user="{{$banner->user->name}}" data-edit-penerbit="{{$banner->user->id}}" data-edit-image="{{$banner->image}}"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Ubah Banner"></i></button>
                  <button type="button" class="hapus-banner btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-banner" data-hapus-id="{{ $banner->id }}" data-hapus-title="{{ $banner->title }}" data-hapus-user="{{$banner->user->name}}" data-hapus-image="{{$banner->image}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus Banner"></i></button>
                  <button type="button" class="view-banner btn btn-inline btn-success" data-toggle="modal" data-target="#view-banner" data-view-image="{{$banner->image}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Lihat Banner"></i></button>
                  @if (Auth::user()->role == 'super')
                    <button type="button" class="status-banner btn btn-inline btn-warning" data-toggle="modal" data-target="#status-banner" data-status-id="{{$banner->id}}" data-status-title="{{ $banner->title }}" data-edit-status="{{$banner->status}}"><i class="gi gi-iphone_exchange" data-toggle="tooltip" data-placement="top" title="Status Banner"></i></button>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- END Page Content -->
</div>
<!-- END Main Container -->
</div>
<div class="modal fade" id="tambah-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form form-horizontal" action="{{ url('/banner')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">TAMBAH BANNER</legend>
              @foreach ($errors->add->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title">
              </div>
              <div class="form-group">
                <label class="form-label">Banner <small style="font-style: italic; text-decoration: underline;">ukuran gambar square (sama sisi (400px x 400px))</small></label>
                <input type="file" name="image" accept="image/*" />
              </div>
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="TAMBAH" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form form-horizontal" action="{{ url('/banner/update')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH BANNER</legend>
              @foreach ($errors->edit->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="col-sm-2 control-label form-label">Judul</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="input-banner-title" name="edittitle">
                  <input type="hidden" id="input-edit-id" name="edit_id">
                  <input type="hidden" id="input-edit-user" name="edituser">
                  <input type="hidden" id="input-edit-penerbit" name="editpenerbit">
                  <input type="hidden" id="input-edit-image" name="editimagefordelete">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label form-label">Banner</label>
                <div class="col-sm-10">
                  <p class="form-control-static">
                    <input type="file" name="editimage" accept="image/*" />
                  </p>
                </div>
              </div>
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Page Container -->
<div class="modal fade" id="hapus-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/banner/delete')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS BANNER</legend>
              <div class="col-md-12">
                <span>Apakah Anda Ingin Menghapus "<span id="input-hapus-title"></span>"</span>
              </div>
              <br /><br />
              <input type="hidden" id="input-hapus-id" name="hapus_id" value="">
              <input type="hidden" id="input-hapus-user" name="hapususer" value="">
              <input type="hidden" id="input-hapus-image" name="hapusimage" value="">
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-inline btn-secondary pull-right" >HAPUS</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="view-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form">
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">VIEW ANOUNCEMENT</legend>
              <!-- Start Post -->
              <div class="panel panel-default">
                <div class="panel-body status">
                  <div class="who clearfix">
                  </div><br />
                  <div class="image" style="margin:auto;"><center><img id="something" alt="img" style="width:400px;height:400px;"></div> </center>
                  <br />
                </div>
              </div>
              <!-- End Post -->
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="status-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form form-horizonta" action="{{ url('/banner/status')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">STATUS BANNER</legend>
              <!-- Start Post -->
              <div class="panel panel-default">
                <div class="panel-body status">
                  <div class="col-md-12">
                    <strong><span>Ubah Status Banner "<span style="font-style:italic;" id="input-status-title"></span>"</span></strong>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label form-label">Status</label>
                    <div class="col-sm-10 radio radio-warning">
                      <input type="hidden" id="input-status-id" name="status_id" value="">
                      <input type="radio" name="editstatus" id="input-banner-status-false" value="0" checked  @if (old('status') == '0') checked @endif><label for="input-radio-1">Hide</label>
                        <br />
                        <input type="radio" name="editstatus" id="input-banner-status-true" value="1"  @if (old('status') == '1') checked @endif><label for="input-radio-2">Show</label>
                        </div>
                      </div>
                    </div>
                    <!-- End Post -->
                  </fieldset>
                  <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                  <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('partials.footer')

      @if (count($errors->add) > 0)
        <script type="text/javascript"> $('#tambah-banner').modal('show');</script>
      @endif

      @if (count($errors->edit) > 0)
        <script type="text/javascript"> $('#edit-banner').modal('show');</script>
      @endif

      <script type="text/javascript">
      $(document).on('click' , '.edit-banner', function(){

        $('#input-banner-title').val($(this).data('edit-title'));
        // $('#input-banner-status').val($(this).data('edit-status'));
        console.log($(this).data('edit-status'));
        $('#input-edit-id').val($(this).data('edit-id'));
        $('#input-edit-user').val($(this).data('edit-user'));
        $('#input-edit-penerbit').val($(this).data('edit-penerbit'));
        $('#input-edit-image').val($(this).data('edit-image'));
        if ($(this).data('edit-status') == "Show") {
          $("#input-banner-status-true").prop("checked", true);
        }else {
          $("#input-banner-status-false").prop("checked", true);
        }
      });
      </script>

      <script type="text/javascript">
      $(document).on('click' , '.status-banner', function(){
        $('#input-status-title').html($(this).data('status-title'));
        $('#input-status-id').val($(this).data('status-id'));
        if ($(this).data('edit-status') == "Show") {
          $("#input-banner-status-true").prop("checked", true);
        }else {
          $("#input-banner-status-false").prop("checked", true);
        }

      });
      </script>

      <script type="text/javascript">
      $(document).on('click' , '.hapus-banner', function(){
        $('#input-hapus-id').val($(this).data('hapus-id'));
        $('#input-hapus-image').val($(this).data('hapus-image'));
        $('#input-hapus-user').val($(this).data('hapus-user'));
        $('#input-hapus-title').html($(this).data('hapus-title'));

      });
      </script>

      <script type="text/javascript">
      $(document).on('click' , '.view-banner', function(){
        var urls      = window.location.href+'/images/'+$(this).data('view-image');
        $("#something").attr('src', urls);
      });
      </script>


    </body>
    </html>
