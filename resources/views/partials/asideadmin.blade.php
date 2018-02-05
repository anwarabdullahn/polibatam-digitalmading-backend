<!-- Alternative Sidebar -->
<div id="sidebar-alt" tabindex="-1" aria-hidden="true">
  <!-- Toggle Alternative Sidebar Button (visible only in static layout) -->
  <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>
</div>
<!-- END Alternative Sidebar -->
<!-- Main Sidebar -->
<div id="sidebar">
  <!-- Sidebar Brand -->
  <div id="sidebar-brand" class="themed-background">
    <a href="{{ url('/home') }}" class="sidebar-title">
      <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide">Digital<strong>Mading</strong></span>
    </a>
  </div>
  <!-- END Sidebar Brand -->
  <!-- Wrapper for scrolling functionality -->
  <div id="sidebar-scroll">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
      <!-- Sidebar Navigation -->
      <ul class="sidebar-nav">
        <li>
          <a href="{{ url('/home') }}" class="active"><i class="hi hi-home sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Admin</span></a>
        </li>
