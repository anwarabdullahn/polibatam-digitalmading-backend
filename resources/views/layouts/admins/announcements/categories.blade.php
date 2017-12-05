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
                                        <h1>Kategori Pengumuman</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <button class="btn btn-rounded btn-warning pull-right" data-toggle="modal" data-target="#tambah-kategori"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
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
                                            <th class="text-center" style="width: 50px;">NO</th>
                                            <th>Nama</th>
                                            <th class="text-center" style="width: 280px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($categories as $index=> $category)
                                          <tr>
                                            <td class="text-center" style="width: 50px;"> {{ $index+1 }} </td>
                                            <td> {{ $category->name }} </td>
                                            <td class="text-center" style="width: 230px;"><div class="btn-group pull-right" role="group">
                                            <button type="button" class="edit-kategori btn btn-inline btn-primary" data-toggle="modal" data-target="#edit-kategori" data-edit-id="{{$category->id}}" data-edit-name="{{$category->name}}"><i class="fa fa-edit" ></i>Ubah</button>
                                            <button type="button" class="hapus-kategori btn btn-inline btn-danger" data-toggle="modal" data-target="#hapus-kategori" data-hapus-id="{{$category->id}}" data-hapus-name="{{$category->name}}" ><i class="fa fa-trash"></i>Hapus</button>
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
            <div class="modal fade" id="tambah-kategori">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <div class="modal-body">
              <form class="fieldset-form" action="{{ url('/announcement/category')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                        <fieldset>
                          <legend class="text-center" style="color: #33577A; font-size: 21px !important;">TAMBAH KATEGORI</legend>
                                @foreach ($errors->add->all() as $error)
                                  <div class="alert alert-danger display-show">
                                    {{ $error }}
                                  </div>
                                  @break
                                @endforeach
                          <div class="form-group">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Kategori"  value="{{old('title')}}">
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
            <div class="modal fade" id="edit-kategori">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <div class="modal-body">
              <form class="fieldset-form" action="{{ url('/announcement/category/update')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                        <fieldset>
                          <legend class="text-center" style="color: #33577A; font-size: 21px !important;">UBAH KATEGORI</legend>
                                @foreach ($errors->edit->all() as $error)
                                  <div class="alert alert-danger display-show">
                                    {{ $error }}
                                  </div>
                                  @break
                                @endforeach
                          <div class="form-group">
                            <label class="form-label">Nama Kategori</label>
                            <input id="input-edit-name" type="text" class="form-control" name="editname" placeholder="Nama Kategori"  value="{{old('editname')}}">
                            <input id="input-edit-id" type="hidden" class="form-control" name="edit_id">
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

            <div class="modal fade" id="hapus-kategori">
              <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-body">
                  <form class="fieldset-form" action="{{ url('/announcement/category/delete')}}" method="post">
                    {{ csrf_field() }}
                            <fieldset>
                              <legend class="text-center" style="color: #33577A; font-size: 21px !important;">HAPUS KATEGORI</legend>
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
        <script type="text/javascript"> $('#tambah-kategori').modal('show');</script>
      @endif

      @if (count($errors->edit) > 0)
        <script type="text/javascript"> $('#edit-kategori').modal('show');</script>
      @endif

      <script type="text/javascript">
        $(document).on('click' , '.edit-kategori', function(){
          $('#input-edit-id').val($(this).data('edit-id'));
          $('#input-edit-name').val($(this).data('edit-name'));
        });
      </script>

      <script type="text/javascript">
        $(document).on('click' , '.hapus-kategori', function(){
          $('#input-hapus-id').val($(this).data('hapus-id'));
          $('#input-hapus-name').html($(this).data('hapus-name'));

          console.log($(this).data('hapus-name'));
        });
      </script>


    </body>
</html>
