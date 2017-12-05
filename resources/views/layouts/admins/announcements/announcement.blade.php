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
              @if (Auth::user()->role == 'admin')
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
                                <table id="example" class="table table-borderless table-hover">
                                  <thead>
                                        <tr>
                                            <th class="text-center" style="width: 20px;">NO</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center" style="width: 100px;">Penerbit</th>
                                            <th class="text-center" style="width: 100px;">Kategori</th>
                                            <th class="text-center" style="width: 150px;">Tanggal diterbitkan</th>
                                            <th class="text-center" style="width: 280px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($announcements as $index=> $announcement)
                                          <tr>
                                            <td class="text-center" style="width: 20px;"> {{ $index+1 }} </td>
                                            <td> {{ $announcement->title }} </td>
                                            <td> {{ $announcement->description }} </td>
                                            <td class="text-center" style="width: 100px;"> {{ $announcement->user->name }} </td>
                                            <td class="text-center" style="width: 100px;"> {{ $announcement->category->name }} </td>
                                            <td class="text-center" style="width: 150px;"> {{ $announcement->created_at  }} </td>
                                            <td class="text-center" style="width: 280px;"><div class="btn-group pull-right" role="group">
                                            <button type="button" class="edit-announcement btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-announcement" data-edit-id="{{$announcement->id}}" data-edit-title="{{$announcement->title}}" data-edit-description="{{$announcement->description}}" data-edit-category="{{$announcement->category->id}}" data-edit-image="{{$announcement->image}}"  data-edit-penerbit="{{$announcement->user->id}}" </button><i class="fa fa-edit"></i>Ubah</button>
                                            <button type="button" class="hapus-announcement btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-announcement" data-hapus-id="{{$announcement->id}}" data-hapus-title="{{$announcement->title}}" data-hapus-image="{{$announcement->image}}"><i class="fa fa-trash"></i>Hapus</button>
                                            <button type="button" class="view-announcement btn btn-inline btn-success" data-toggle="modal" data-target="#view-announcement" data-view-id="{{$announcement->id}}"  data-view-image="{{$announcement->image}}" data-view-admin="{{ $announcement->user->name }}" data-view-title="{{ $announcement->title }}" data-view-created-at="{{ $announcement->created_at}}" data-view-description="{{ $announcement->description }}"><i class="fa fa-eye"></i>Lihat</button>
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
              <div class="modal-dialog">
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
                            <label class="form-label">Thumbnail</label>
                            <input type="file" name="image" accept="image/*" />
                          </div>
                          <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" contenteditable rows="3" name="description" placeholder="Type your description..." value="">{{old('description')}}</textarea>
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
                <div class="modal-dialog">
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
                              <label class="form-label">Thumbnail</label>
                              <input type="file" name="editimage" accept="image/*"/>

                            </div>
                            <div class="form-group">
                              <label class="form-label">Description</label>
                              <textarea class="form-control" rows="3" name="editdescription" id="input-description-edit">{{old('editdescription')}}</textarea>
                            </div>
                            <input type="hidden" id="input-edit-id" name="edit_id" value="{{old('edit_id')}}">
                            <input type="hidden" id="input-edit-penerbit" name="edit_penerbit" value="{{old('edit_id')}}">
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
                              <input type="hidden" id="input-hapus-id" name="hapus_id" value="">
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
            <div class="modal fade" id="view-announcement">
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
                                    <span class="name"><b><span id="input-view-admin"></span></b> posted an "<i><span id="input-view-title"></span></i>"</span>
                                    <span class="from"><b><span id="input-view-created-at"></span></b></span>
                                  </div><br />
                                  <div class="image"><center><img id="something" alt="img" style="width:70%; height:70%"></div> </center>
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


        @include('partials.footer')

      @if (count($errors->add) > 0)
        <script type="text/javascript"> $('#tambah-announcement').modal('show');</script>
      @endif

      @if (count($errors->edit) > 0)
        <script type="text/javascript"> $('#edit-announcement').modal('show');</script>
      @endif

      <script type="text/javascript">
        $(document).on('click' , '.edit-announcement', function(){
          $('#input-title-edit').val($(this).data('edit-title'));
          $('#input-image-edit').val($(this).data('edit-image'));
          $('#input-description-edit').html($(this).data('edit-description'));
          // console.log($(this).data('edit-description'));
          $('#input-edit-id').val($(this).data('edit-id'));
          $('#input-edit-penerbit').val($(this).data('edit-penerbit'));
          $('select[name=id_categoryedit]').val($(this).data('edit-category'))

        });
      </script>

      <script type="text/javascript">
        $(document).on('click' , '.hapus-announcement', function(){
          $('#input-hapus-title').html($(this).data('hapus-title'));
          $('#input-hapus-id').val($(this).data('hapus-id'));
          $('#input-hapus-image').val($(this).data('hapus-image'));
        });
      </script>

      <script type="text/javascript">
        $(document).on('click' , '.view-announcement', function(){
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
