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
        <li class="active">
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
        <li>
        @endif
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
            <h1>Pengumuman</h1>
          </div>
        </div>
        <div class="col-sm-6 hidden-xs">
          <div class="header-section">
            <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-announcement"><i class="fa fa-plus-circle"></i> Tambah Pengumuman</button>
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
        <table id="announcementtable" class="table table-borderless table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 20px;">NO</th>
              <th style="width: 280px">Judul</th>
              <th class="text-center" style="width: 100px;">Penerbit</th>
              <th class="text-center" style="width: 100px;">Kategori</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-center" style="width: 150px;">Tanggal diterbitkan</th>
              <th class="text-center" style="width: 200px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($announcements as $index=> $announcement)
              <tr>
                <td class="text-center" style="width: 20px;"> {{ $index+1 }} </td>
                <td style="width: 280px"> {{ $announcement->title }} </td>
                <td class="text-center" style="width: 100px;"> {{ $announcement->user->name }} </td>
                <td class="text-center" style="width: 100px;"> {{ $announcement->category->name }} </td>
                <td class="text-center" style="width: 100px;"> {{ $announcement->status }} </td>
                <td class="text-center" style="width: 150px;"> {{ $announcement->created_at  }} </td>
                <td class="text-center" style="width: 200px;"><div class="btn-group pull-right" role="group">
                  <button type="button" class="edit-announcement btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-announcement" data-edit-id="{{$announcement->id}}" data-edit-title="{{$announcement->title}}" data-edit-description="{{$announcement->description}}" data-edit-category="{{$announcement->category->id}}" data-edit-image="{{$announcement->image}}" data-edit-status="{{$announcement->status}}" data-edit-penerbit="{{$announcement->user->name}}" ><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Ubah Pengumuman"></i></button>
                  <button type="button" class="hapus-announcement btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-announcement" data-hapus-id="{{$announcement->id}}" data-hapus-title="{{$announcement->title}}" data-hapus-image="{{$announcement->image}}" data-hapus-penerbit="{{$announcement->user->name}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus Pengumuman"></i></button>
                  <button type="button" class="view-announcement btn btn-inline btn-success" data-toggle="modal" data-target="#view-announcement" data-view-id="{{$announcement->id}}"  data-view-image="{{$announcement->image}}" data-view-admin="{{ $announcement->user->name }}" data-view-title="{{ $announcement->title }}" data-view-created-at="{{ $announcement->created_at}}" data-view-description="{{ $announcement->description }}" data-view-file="{{$announcement->file}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Lihat Pengumuman"></i></button>
                  @if (Auth::user()->role == 'super')
                    <button type="button" class="status-announcement btn btn-inline btn-warning" data-toggle="modal" data-target="#status-announcement" data-status-id="{{$announcement->id}}" data-status-title="{{ $announcement->title }}" data-edit-status="{{$announcement->status}}"><i class="gi gi-iphone_exchange" data-toggle="tooltip" data-placement="top" title="Status Pengumuman"></i></button>
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
<!-- END Page Container -->
<div class="modal fade" id="tambah-announcement">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/announcement')}}" method="post" enctype="multipart/form-data">
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
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" placeholder="Judul Pengumuman"  value="{{old('title')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Kategori</label>
                <select id="id_category" name="id_category" value="{{ old('id_category') }}" class="form-control">
                  <option value="" selected>Pilih Kategori</option>
                  @foreach ($categories as $indexKey => $category)
                    <option value="{{ $category->id }}"
                      @if (old('id_category') == $category->id)
                        selected
                      @endif>
                      {{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Thumbnail <small style="font-style: italic; text-decoration: underline;">ukuran gambar square (sama sisi (400px x 400px))</small></label>
                  <input type="file" name="image" accept="image/*" />
                </div>
                <div class="form-group">
                  <label class="form-label">File <small style="font-style: italic; text-decoration: underline;">silahkan isi jika ada, tinggalkan jika tidak ada (pdf only)</small></label>
                  <input type="file" name="file" accept="application/pdf"/>
                </div>
                <div class="form-group">
                  <label class="form-label">Description</label>
                  <textarea class="form-control ckeditor" contenteditable rows="3" name="description" placeholder="Type your description..." value="">{{old('description')}}</textarea>
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
  <div class="modal fade" id="edit-announcement">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <form class="fieldset-form" action="{{ url('/announcement/update')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <fieldset>
                <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH PENGUMUMAN</legend>
                @foreach ($errors->edit->all() as $error)
                  <div class="alert alert-danger display-show">
                    {{ $error }}
                  </div>
                  @break
                @endforeach
                <div class="form-group">
                  <label class="form-label">Judul</label>
                  <input type="text" id="input-title-edit" class="form-control" name="edittitle" value="{{old('edittitle')}}" >
                </div>
                <div class="form-group">
                  <label class="form-label">Kategori</label>
                  <select id="id_categoryedit" name="id_categoryedit" value="{{ old('id_categoryedit') }}" class="form-control">
                    <option value="" selected>Pilih Kategori</option>
                    @foreach ($categories as $indexKey => $category)
                      <option value="{{ $category->id }}"
                        @if (old('id_categoryedit') == $category->id)
                          selected
                        @endif>
                        {{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Thumbnail <small style="font-style: italic; text-decoration: underline;">ukuran gambar square (sama sisi (400px x 400px))</small></label>
                    <input type="file" name="editimage" accept="image/*"/>
                  </div>
                  <div class="form-group">
                    <label class="form-label">File <small style="font-style: italic; text-decoration: underline;">silahkan isi jika ada, tinggalkan jika tidak ada (pdf only)</small></label>
                    <input type="file" name="editfile" accept="application/pdf"/>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Description</label>
                    <p id="input-description-edit">
                    </p>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Edit Description</label>
                    <textarea class="form-control ckeditor" rows="3" name="editdescription">{{old('editdescription')}}</textarea>
                  </div>
                  <input type="hidden" id="input-edit-id" name="edit_id" value="{{old('edit_id')}}">
                  <input type="hidden" id="input-edit-penerbit" name="editpenerbit" value="{{old('edit_penerbit')}}">
                  <input type="hidden" id="input-image-edit" name="editimagefordelete">
                  <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                  <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="hapus-announcement">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-body">
              <form class="fieldset-form" action="{{ url('/announcement/delete')}}" method="post">
                {{ csrf_field() }}
                <fieldset>
                  <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS PENGUMUMAN</legend>
                  <div class="col-md-12">
                    <span>Apakah Anda Ingin Menghapus "<span id="input-hapus-title"></span>"</span>
                  </div>
                  <br /><br />
                  <input type="hidden" id="input-hapus-id" name="hapus_id" value="{{old('hapus_id')}}">
                  <input type="hidden" id="input-hapus-image" name="hapusimage" value="{{old('hapusimage')}}">
                  <input type="hidden" id="input-hapus-penerbit" name="hapuspenerbit" value="{{old('edit_penerbit')}}">
                  <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-inline btn-secondary pull-right" >HAPUS</button>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="view-announcement">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-body">
              <form class="fieldset-form">
                <fieldset>
                  <legend class="text-center" style="color: #33577A; font-size: 21px !important;">VIEW PENGUMUMAN</legend>
                  <!-- Start Post -->
                  <div class="panel panel-default">
                    <div class="panel-body status">
                      <div class="who clearfix">
                        <span class="name"><b><span id="input-view-admin"></span></b> posted an "<i><span id="input-view-title"></span></i>"</span>
                        <span class="from"><b><span id="input-view-created-at"></span></b></span>
                      </div><br />
                      <div class="image" style="margin:auto;"><center><img id="something" alt="img" style="width:400px;height:400px;"></div> </center>
                      <br />
                      {{-- @if ($condition) --}}
                      <ul class="comments">
                        <a id="files" download><span id="input-view-file"></span></a>
                      </ul>
                      {{-- @endif --}}
                      <ul class="comments">
                        <span id="input-view-description"></span>
                      </ul>
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

    <div class="modal fade" id="status-announcement">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-body">
              <form class="fieldset-form form-horizonta" action="{{ url('/announcement/status')}}" method="post">
                {{ csrf_field() }}
                <fieldset>
                  <legend class="text-center" style="color: #33577A; font-size: 21px !important;">STATUS PENGUMUMAN</legend>
                  <!-- Start Post -->
                  <div class="panel panel-default">
                    <div class="panel-body status">
                      <div class="col-md-12">
                        <strong><span>Ubah Status Pengumuman "<span style="font-style:italic;" id="input-status-title"></span>"</span></strong>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label form-label">Status</label>
                        <div class="col-sm-10 radio radio-warning">
                          <input type="hidden" id="input-status-id" name="status_id" value="">
                          <input type="radio" name="editstatus" id="input-announcement-status-false" value="0" checked  @if (old('status') == '0') checked @endif><label for="input-radio-1">Hide</label>
                            <br />
                            <input type="radio" name="editstatus" id="input-announcement-status-true" value="1"  @if (old('status') == '1') checked @endif><label for="input-radio-2">Show</label>
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
            <script type="text/javascript"> $('#tambah-announcement').modal('show');</script>
          @endif

          @if (count($errors->edit) > 0)
            <script type="text/javascript"> $('#edit-announcement').modal('show');</script>
          @endif

          <script src="{{asset ('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>

          <script type="text/javascript">
          $(document).on('click' , '.edit-announcement', function(){
            $('#input-title-edit').val($(this).data('edit-title'));
            $('#input-image-edit').val($(this).data('edit-image'));
            $('#input-description-edit').html($(this).data('edit-description'));
            // console.log($(this).data('edit-description'));
            $('#input-edit-id').val($(this).data('edit-id'));
            $('#input-edit-penerbit').val($(this).data('edit-penerbit'));
            $('select[name=id_categoryedit]').val($(this).data('edit-category'))
            if ($(this).data('edit-status') == "Show") {
              $("#input-banner-status-true").prop("checked", true);
            }else {
              $("#input-banner-status-false").prop("checked", true);
            }
          });
          </script>

          <script type="text/javascript">
          $(document).on('click' , '.hapus-announcement', function(){
            $('#input-hapus-title').html($(this).data('hapus-title'));
            $('#input-hapus-id').val($(this).data('hapus-id'));
            $('#input-hapus-image').val($(this).data('hapus-image'));
            $('#input-hapus-penerbit').val($(this).data('hapus-penerbit'));
          });
          </script>

          <script type="text/javascript">
          $(document).on('click' , '.status-announcement', function(){
            $('#input-status-title').html($(this).data('status-title'));
            $('#input-status-id').val($(this).data('status-id'));
            if ($(this).data('edit-status') == "Show") {
              $("#input-announcement-status-true").prop("checked", true);
            }else {
              $("#input-announcement-status-false").prop("checked", true);
            }
          });
          </script>

          <script type="text/javascript">
          $(document).on('click' , '.view-announcement', function(){
            $('#input-view-title').html($(this).data('view-title'));
            $('#input-view-description').html($(this).data('view-description'));
            $('#input-view-admin').html($(this).data('view-admin'));
            $('#input-view-created-at').html($(this).data('view-created-at'));
            $('#input-view-image').html($(this).data('view-image'));
            var file = '/file/'+$(this).data('view-file');
            console.log($(this).data('view-file'));
            $("#files").attr('href', file);

            if (($(this).data('view-file') == null) || (($(this).data('view-file')) == "") ) {
              $('#input-view-file').html('Download File Not Available');
            }else {
              $('#input-view-file').html('Download File Available');
            }
            // console.log($(this).data('view-file'));
            // var images = $('#input-view-image').html($(this).data('view-image'));
            // console.log($(this).data('view-image'));
            var urls      = window.location.href+'/images/'+$(this).data('view-image');
            // console.log(urls);
            $("#something").attr('src', urls);
          });
          </script>


        </body>
        </html>
