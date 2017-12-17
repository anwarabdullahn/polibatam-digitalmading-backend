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

                         <div class="col-md-7 col-lg-8">
                            <div class="block full">
                                <!-- Block Tabs Title -->
                                <div class="block-title">
                                    <div class="block-options pull-right">
                                    </div>
                                    <ul class="nav nav-tabs" data-toggle="tabs">
                                        <li class="active"><a href="#profile-activity">Activity</a></li>
                                    </ul>
                                </div>
                                <!-- END Block Tabs Title -->
                            </div>
                        </div>
                      @include('partials.profile')

                    </div>
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <div class="modal fade" id="edit-profile">
              <div class="modal-dialog modal-lg">
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
                            <label class="form-label">Description</label>
                            <textarea class="form-control" contenteditable rows="3" name="description" placeholder="Type your description..." value="">{{old('description')}}</textarea>
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
    </body>
</html>
