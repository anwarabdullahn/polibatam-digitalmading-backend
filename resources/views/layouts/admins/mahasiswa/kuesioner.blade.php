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
        <a class="active" href="{{url('/kuesioner')}}"><i class="fa fa-tasks sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Kuesioner</span></a>
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
            <h1>Kuesioner</h1>
          </div>
        </div>
        <div class="col-sm-6 hidden-xs">
          <div class="header-section">
          <button class="btn btn-rounded btn-info pull-right" data-toggle="modal" data-target="#lihat-kuesioner"><i class="fa fa-question-circle"></i> Lihat Pertanyaan </button>
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
        <table id="kuesionertable" class="table table-borderless table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 20px;">NO</th>
              <th style="width: 100px">Nama Mahasiswa</th>
              <th class="text-center" style="width: 100px;">Jawaban Pertama</th>
              <th class="text-center" style="width: 100px;">Jawaban Kedua</th>
              <th class="text-center" style="width: 100px;">Jawaban Ketiga</th>
              <th class="text-center" style="width: 100px;">Jawaban Keempat</th>
              {{-- <th class="text-center" style="width: 100px;">Waktu Submit</th> --}}
              <th class="text-center" style="width: 50px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kuesioners as $index=> $kuesioner)
              <tr>
                <td class="text-center" style="width: 20px;"> {{ $index+1 }} </td>
                <td style="width: 280px"> {{ $kuesioner->mahasiswa->name }} </td>
                <td class="text-center" style="width: 100px;"> {{ $kuesioner->jawaban1 }} </td>
                <td class="text-center" style="width: 100px;"> {{ $kuesioner->jawaban2 }} </td>
                <td class="text-center" style="width: 100px;"> {{ $kuesioner->jawaban3 }} </td>
                <td class="text-center" style="width: 100px;"> {{ $kuesioner->jawaban4 }} </td>
                {{-- <td class="text-center" style="width: 150px;"> {{ $kuesioner->created_at  }} </td> --}}
                <td class="text-center" style="width: 50px;"><div class="btn-group pull-right" role="group">
                  <button type="button" class="hapus-kuesioner btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-kuesioner" data-hapus-name=" {{ $kuesioner->mahasiswa->name }} " data-hapus-id=" {{ $kuesioner->id }} "><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus Pengumuman"></i> Hapus</button>
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
<div class="modal fade" id="lihat-kuesioner">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/kuesioner')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">DAFTAR PERTANYAAN</legend>
              @foreach ($errors->update->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">Pertanyaan Pertama</label>
                <input type="text" class="form-control" name="pertanyaan1" value="{{$pertanyaan->pertanyaan1}}">
              </div>
              <div class="form-group">
                <label class="form-label">Pertanyaan Kedua</label>
                <input type="text" class="form-control" name="pertanyaan2" value="{{$pertanyaan->pertanyaan2}}">
              </div>
              <div class="form-group">
                <label class="form-label">Pertanyaan Ketiga</label>
                <input type="text" class="form-control" name="pertanyaan3" value="{{$pertanyaan->pertanyaan3}}">
              </div>
              <div class="form-group">
                <label class="form-label">Pertanyaan Keempat</label>
                <input type="text" class="form-control" name="pertanyaan4" value="{{$pertanyaan->pertanyaan4}}">
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

<div class="modal fade" id="hapus-kuesioner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/kuesioner/delete')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS KUESIONER</legend>
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

@if (count($errors->update) > 0)
  <script type="text/javascript"> $('#lihat-kuesioner').modal('show');</script>
@endif

<script type="text/javascript">
  $(document).on('click' , '.hapus-kuesioner', function(){
    $('#input-hapus-name').html($(this).data('hapus-name'));
    $('#input-hapus-id').val($(this).data('hapus-id'));
  });
  </script>
</body>
</html>
