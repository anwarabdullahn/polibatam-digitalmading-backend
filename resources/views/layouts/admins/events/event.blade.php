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
                <h1>Event</h1>
              </div>
            </div>
            <div class="col-sm-6 hidden-xs">
              <div class="header-section">
                <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-event"><i class="fa fa-plus-circle"></i>Tambah Event</button>
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
            <table id="example"  class="table table-borderless table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">NO</th>
                  <th tyle="width: 280px;">Judul</th>
                  <th class="text-center" style="width: 100px;">Penerbit</th>
                  <th class="text-center" style="width: 80px;">Status</th>
                  <th class="text-center" style="width: 150px;">Tanggal</th>
                  <th class="text-center" style="width: 200px;"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($events as $index=> $event)
                  <tr>
                    <td class="text-center" style="width: 50px;"> {{ $index+1 }} </td>
                    <td tyle="width: 280px;"> {{ $event->title }} </td>
                    <td class="text-center" style="width: 100px;"> {{ $event->user->name }} </td>
                    <td class="text-center" style="width: 80px;"> {{ $event->status }} </td>
                    <td class="text-center" style="width: 150px;"> {{ $event->date  }} </td>
                    <td class="text-center" style="width: 200px;"><div class="btn-group pull-right" role="group">
                      <button type="button" class="edit-event btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-event" data-edit-id="{{$event->id}}" data-edit-title="{{$event->title}}" data-edit-user="{{$event->user->name}}" data-edit-penerbit="{{$event->user->id}}" data-edit-description="{{$event->description}}" data-edit-date="{{$event->date}}"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Ubah Event"></i></button>
                      <button type="button" class="hapus-event btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-event" data-hapus-id="{{$event->id}}" data-hapus-title="{{$event->title}}" data-hapus-user="{{$event->user->name}}" data-hapus-image="{{$event->image}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus Event"></i></button>
                      <button type="button" class="view-event btn btn-inline btn-success" data-toggle="modal" data-target="#view-event" data-view-id="{{$event->id}}"  data-view-image="{{$event->image}}" data-view-admin="{{ $event->user->name }}" data-view-title="{{ $event->title }}" data-view-created-at="{{ $event->created_at}}" data-view-description="{{ $event->description }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Lihat Event"></i></button>
                      @if (Auth::user()->role == 'super')
                        <button type="button" class="status-event btn btn-inline btn-warning" data-toggle="modal" data-target="#status-event" data-status-id="{{$event->id}}" data-status-title="{{ $event->title }}" data-edit-status="{{$event->status}}"><i class="gi gi-iphone_exchange" data-toggle="tooltip" data-placement="top" title="Status Pengumuman"></i></button>
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
<div class="modal fade" id="tambah-event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/event')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">TAMBAH EVENT</legend>
              @foreach ($errors->add->all() as $error)
                <div class="alert alert-danger display-show">
                  {{ $error }}
                </div>
                @break
              @endforeach
              <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" placeholder="Judul Event" value="{{old('title')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="text" class="form-control input-datepicker" name="date" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" value="{{old('date')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Thumbnail <small style="font-style: italic; text-decoration: underline;">ukuran gambar square (sama sisi)</small></label>
                <input type="file" name="image" accept="image/*" />
              </div>
              <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-control ckeditor" rows="3" name="description" >{{old('description')}}</textarea>
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
<div class="modal fade" id="edit-event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/event/update')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH EVENT</legend>
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
                <label class="form-label">Tanggal</label>
                <input type="text" id="input-date-edit" class="form-control input-datepicker" name="editdate" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" value="{{old('date')}}">
              </div>
              <div class="form-group">
                <label class="form-label">Thumbnail <small style="font-style: italic; text-decoration: underline;">ukuran gambar square (sama sisi)</small></label>
                <input type="file" name="editimage" accept="image/*" id="input-image-edit"/>
              </div>
              <div class="form-group">
                <label class="form-label">Description</label>
                <p id="input-description-edit"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Edit Description</label>
                <textarea class="form-control ckeditor" rows="3" name="editdescription" placeholder="Type your description..." contenteditable>{{old('editdescription')}}</textarea>
              </div>
              <input type="hidden" id="input-edit-id" name="edit_id" value="{{old('edit_id')}}">
              <input type="hidden" id="input-edit-penerbit" name="editpenerbit" value="{{old('editpenerbit')}}">
              <input type="hidden" id="input-edit-user" name="edituser" value="{{old('edituser')}}">
              <button type="button" class="btn btn-inline btn-primary pull-right" data-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-inline btn-secondary pull-right" name="submit" value="UBAH" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hapus-event">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form" action="{{ url('/event/delete')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS EVENT</legend>
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
<div class="modal fade" id="view-event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form">
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">VIEW EVENT</legend>
              <!-- Start Post -->
              <div class="panel panel-default">
                <div class="panel-body status">
                  <div class="who clearfix">
                    <span class="name"><b><span id="input-view-admin"></span></b> posted an "<i><span id="input-view-title"></span></i>"</span>
                    <span class="from"><b><span id="input-view-created-at"></span></b></span>
                  </div><br />
                  <div class="image"><center><img id="something" alt="img" style="width:400px;height:400px;"></div> </center>
                  <br />
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
<div class="modal fade" id="status-event">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-body">
          <form class="fieldset-form form-horizonta" action="{{ url('/event/status')}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">STATUS EVENT</legend>
              <!-- Start Post -->
              <div class="panel panel-default">
                <div class="panel-body status">
                  <div class="col-md-12">
                    <strong><span>Ubah Status Event "<span style="font-style:italic;" id="input-status-title"></span>"</span></strong>
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
  <script type="text/javascript"> $('#tambah-event').modal('show');</script>
@endif

@if (count($errors->edit) > 0)
  <script type="text/javascript"> $('#edit-event').modal('show');</script>
@endif

<script src="{{asset ('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
$(document).on('click' , '.edit-event', function(){
  $('#input-title-edit').val($(this).data('edit-title'));
  $('#input-image-edit').val($(this).data('edit-image'));
  $('#input-description-edit').html($(this).data('edit-description'));
  $('#input-date-edit').val($(this).data('edit-date'));
  // $('#input-description-edit').html($(this).data('edit-description'));
  // var desc = CKEDITOR.instances['editdescription'].getData();
  console.log($(this).data('edit-date'));
  // $('#input-description-edit').ckeditor($(this).data('edit-description'));
  // console.log($(this).data('edit-description'));
  $('#input-edit-id').val($(this).data('edit-id'));
  $('#input-edit-user').val($(this).data('edit-user'));
  $('#input-edit-penerbit').val($(this).data('edit-penerbit'));

});
</script>

<script type="text/javascript">
$(document).on('click' , '.hapus-event', function(){
  $('#input-hapus-title').html($(this).data('hapus-title'));
  $('#input-hapus-id').val($(this).data('hapus-id'));
  $('#input-hapus-user').val($(this).data('hapus-user'));
  $('#input-hapus-image').val($(this).data('hapus-image'));
});
</script>

<script type="text/javascript">
$(document).on('click' , '.status-event', function(){
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
$(document).on('click' , '.view-event', function(){
  $('#input-view-title').html($(this).data('view-title'));
  $('#input-view-description').html($(this).data('view-description'));
  $('#input-view-admin').html($(this).data('view-admin'));
  $('#input-view-created-at').html($(this).data('view-created-at'));
  $('#input-view-image').html($(this).data('view-image'));
  // var images = $('#input-view-image').html($(this).data('view-image'));
  // console.log($(this).data('view-image'));
  var urls      = window.location.href+'/images/'+$(this).data('view-image');
  // console.log(urls);
  $("#something").attr('src', urls);
});
</script>
</body>
</html>
