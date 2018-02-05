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
      @include('partials.asideadmin')
      <li class="sidebar-separator">
        <i class="fa fa-ellipsis-h"></i>
      </li>
      @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
        <li>
          <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-pencil sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Pengumuman</span></a>
          <ul>
            <li>
              <a class="active" href="{{url('/announcement')}}">Pengumuman</a>
            </li>
            <li>
              <a href="{{url('/announcement/category')}}">Kategori</a>
            </li>
          </ul>
        </li>
      @endif
      <li>
        <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-gift sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Management Event</span></a>
        <ul>
          <li>
            <a href="{{url('/event')}}">Event</a>
          </li>
        </ul>
      </li>
      @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
        <li class="active">
          <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-group sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Management Akun</span></a>
          <ul>
            @if (Auth::user()->role == 'super')
              <li>
                <a href="{{url('/ormawa')}}">Ormawa</a>
              </li>
            @endif
            <li>
              <a  class="active" href="{{url('/mahasiswa')}}">Mahasiswa</a>
            </li>
          </ul>
        </li>
      @endif
      <li>
        <a href="{{url('/banner')}}"><i class="fa fa-newspaper-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Banner</span></a>
      </li>
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
            <h1>Mahasiswa</h1>
          </div>
        </div>
        <div class="col-sm-6 hidden-xs">
          <div class="header-section">
            <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-mahasiswa"><i class="fa fa-plus-circle"></i> Tambah Mahasiswa</button>
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
        <table id="mahasiswatable" class="table table-borderless table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 20px;">NO</th>
              <th style="width: 100px">NIM</th>
              <th class="text-center" style="width: 100px;">Nama</th>
              <th class="text-center" style="width: 100px;">Email</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-center" style="width: 200px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($mahasiswas as $index=> $mahasiswa)
              <tr>
                <td class="text-center" style="width: 20px;"> {{ $index+1 }} </td>
                <td style="width: 100px"> {{ $mahasiswa->nim }} </td>
                <td class="text-center" style="width: 100px;"> {{ $mahasiswa->name }} </td>
                <td class="text-center" style="width: 100px;"> {{ $mahasiswa->email }} </td>
                <td class="text-center" style="width: 100px;"> {{ $mahasiswa->verified }} </td>
                <td class="text-center" style="width: 200px;"><div class="btn-group pull-right" role="group">
                  <button type="button" class="edit-mahasiswa btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-mahasiswa" data-edit-value={{$mahasiswa->verified}} data-edit-id={{$mahasiswa->id}}><i class="fa fa-edit"></i>Ubah</button>
                  <button type="button" class="hapus-mahasiswa btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-mahasiswa" data-hapus-id="{{$mahasiswa->id}}" data-hapus-name="{{$mahasiswa->name}}"><i class="fa fa-trash"></i>Hapus</button>
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
<!-- END Page Container -->
<div class="modal fade" id="tambah-mahasiswa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/mahasiswa')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">TAMBAH PENGUMUMAN</legend>
              @foreach ($errors->add->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">NIM</label>
                <input type="text" class="form-control" name="nim" placeholder="Nomor Induk Mahasiswa"  value="{{old('nim')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" placeholder="Nama Mahasiswa"  value="{{old('name')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email Mahasiswa"  value="{{old('email')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Re-type Email</label>
                <input type="text" class="form-control" name="reemail" placeholder="Re-type Email Mahasiswa"  value="{{old('reemail')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
              </div>
              <div class="form-group">
                <label class="form-label">Re-type Password</label>
                <input type="password" class="form-control" name="repassword">
              </div>
              <div class="form-group">
                <label class="form-label">Status</label>
                <select name="verified" class="form-control">
                  <option value="" selected>Please select</option>
                  <option value="true">Activated</option>
                  <option value="false">NotActivated</option>
                </select>
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
<div class="modal fade" id="edit-mahasiswa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/mahasiswa/update')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH MAHASISWA</legend>
              @foreach ($errors->edit->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">Status</label>
                <select name="editstatus" value="{{ old('editstatus') }}" class="form-control">
                  <option value="" selected>Please select</option>
                  <option value="Activated">Activated</option>
                  <option value="NotActivated">NotActivated</option>
                </select>
              </div>
              <input type="hidden" id="input-edit-id" name="edit_id" value="{{old('edit_id')}}">
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hapus-mahasiswa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/mahasiswa/delete')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS MAHASISWA</legend>
              <div class="col-md-12">
                <span>Apakah Anda Ingin Menghapus "<span id="input-hapus-name"></span>"</span>
              </div>
              <br /><br />
              <input type="hidden" id="input-hapus-id" name="hapus_id" value="">
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-inline btn-secondary pull-right" >HAPUS</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@include('partials.footer')

@if (count($errors->add) > 0)
  <script type="text/javascript"> $('#tambah-mahasiswa').modal('show');</script>
@endif

@if (count($errors->edit) > 0)
  <script type="text/javascript"> $('#edit-mahasiswa').modal('show');</script>
@endif

<script src="{{asset ('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
$(document).on('click' , '.edit-mahasiswa', function(){
  $('#input-edit-id').val($(this).data('edit-id'));
  $('select[name=editstatus]').val($(this).data('edit-value'));
  console.log($(this).data('edit-id'));
});
</script>

<script type="text/javascript">
$(document).on('click' , '.hapus-mahasiswa', function(){
  $('#input-hapus-name').html($(this).data('hapus-name'));
  $('#input-hapus-id').val($(this).data('hapus-id'));
});
</script>

</body>
</html>
