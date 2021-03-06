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
              <a class="active" href="{{url('/admin')}}">Admin</a>
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
        <a href="{{url('/banner')}}"><i class="fa fa-newspaper-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Banner</span></a>
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
            <h1>Admin</h1>
          </div>
        </div>
        @if (Auth::user()->role == 'admin'||Auth::user()->role == 'super')
        <div class="col-sm-6 hidden-xs">
          <div class="header-section">
            <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-mahasiswa"><i class="fa fa-plus-circle"></i> Tambah Admin</button>
          </div>
        </div>
        @endif
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
                <th class="text-center" style="width: 50px;">NO</th>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center" style="width: 100px;">No. Telp</th>
                <th class="text-center" style="width: 230px;"></th>
              </tr>
          </thead>
          <tbody>
            @foreach ($admins as $index=> $user)
              <tr>
                <td class="text-center" style="width: 50px;"> {{ $index+1 }} </td>
                <td> {{ $user->name }} </td>
                <td> {{ $user->email }} </td>
                <td class="text-center" style="width: 100px;"> {{ $user->notelpon }} </td>
                <td class="text-center" style="width: 280px;"><div class="btn-group pull-right" role="group">
                  <button type="button" class="edit-ormawa btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-ormawa" data-edit-name="{{$user->name}}" data-edit-email="{{$user->email}}" data-edit-notelpon="{{$user->notelpon}}" data-edit-id="{{$user->id}}" ><i class="fa fa-edit"></i>Ubah</button>
                  <button type="button" class="hapus-ormawa btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-ormawa" data-hapus-id="{{$user->id}}"
                    data-hapus-name="{{$user->name}}"><i class="fa fa-trash"></i>Hapus</button>
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
          <form class="fieldset-form" action="{{ url('/admin')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">TAMBAH DATA ADMIN</legend>
              @foreach ($errors->add->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">Nama Admin</label>
                <input type="text" class="form-control" name="nama" placeholder="Admin Contoh" value="{{old('nama')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="contoh@admin.com" value="{{old('email')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Confirm Email</label>
                <input type="text" class="form-control" name="confirm_email" placeholder="contoh@admin.com" value="{{old('confirm_email')}}">
              </div>
              <div class="form-group">
                <label class="form-label">No Telpon</label>
                <input type="text" class="form-control" name="notelpon" value="{{old('notelpon')}}" placeholder="-">
              </div>
              <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="*********">
              </div>
              <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="*********">
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
<div class="modal fade" id="edit-ormawa">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <form class="fieldset-form" action="{{ url('/admin/update')}}" method="post">
              {{ csrf_field() }}
              <fieldset>
                <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH DATA ADMIN</legend>
                @foreach ($errors->add->all() as $error)
                  <div class="alert alert-danger display-show">
                    {{ $error }}
                  </div>
                  @break
                @endforeach
                <div class="form-group">
                  <label class="form-label">Nama Admin</label>
                  <input type="text" class="form-control" name="editname" id=input-name-edit value="{{old('editnama')}}">
                </div>
                <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="text" class="form-control" name="editemail" id=input-email-edit value="{{old('editemail')}}">
                </div>
                <div class="form-group">
                  <label class="form-label">Confirm Email</label>
                  <input type="text" class="form-control" name="editconfirm_email" id=input-emailconfirm-edit value="{{old('editconfirm_email')}}">
                </div>
                <div class="form-group">
                  <label class="form-label">No Telpon</label>
                  <input type="text" id="input-notelpon-edit" class="form-control" name="editnotelpon" value="{{old('editnotelpon')}}">
                </div>
                <div class="form-group">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" name="editpassword" placeholder="*********">
                </div>
                <div class="form-group">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" name="editconfirm_password" placeholder="*********">
                </div>
                <input type="hidden" name="edit_id" id="input-edit-id">
                <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="hapus-ormawa">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-body">
              <form class="fieldset-form" action="{{ url('/admin/delete')}}" method="post">
                {{ csrf_field() }}
                <fieldset>
                  <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS DATA ADMIN</legend>
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

<script type="text/javascript">
  $(document).on('click' , '.edit-ormawa', function(){
    $('#input-edit-id').val($(this).data('edit-id'));
    $('#input-name-edit').val($(this).data('edit-name'));
    $('#input-email-edit').val($(this).data('edit-email'));
    $('#input-emailconfirm-edit').val($(this).data('edit-email'));
    $('#input-notelpon-edit').val($(this).data('edit-notelpon'));
  });
  </script>

  <script type="text/javascript">
  $(document).on('click' , '.hapus-ormawa', function(){
    $('#input-hapus-name').html($(this).data('hapus-name'));
    $('#input-hapus-id').val($(this).data('hapus-id'));
  });
  </script>

</body>
</html>
