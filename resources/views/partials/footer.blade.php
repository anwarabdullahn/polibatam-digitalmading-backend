<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="{{asset ('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="{{asset ('assets/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{asset ('assets/js/plugins.js') }}"></script>
<script src="{{asset ('assets/js/app.js') }}"></script>
<script src="{{asset ('assets/lib/js/jquery.dataTables.min.js') }}"></script>
{{-- <script src="{{asset ('assets/js/pages/readyLogin.js') }}"></script> --}}
{{-- <script>$(function(){ ReadyLogin.init(); });</script> --}}
<script>
$(function() {
  $('#announcementtable').DataTable({
    "order": [[ 5, "desc" ]]
  } );
});
$(function() {
  $('#eventtable').DataTable({
    "order": [[ 4, "desc" ]]
  } );
});
$(function() {
  $('#mahasiswatable').DataTable({
    "order": [[ 4, "desc" ]]
  } );
});
$(function() {
  $('#kuesionertable').DataTable();
$(function() {
  $('#bannertable').DataTable({
    "order": [[ 4, "asc" ]]
  } );
});
$(function() {
  $('#example').DataTable();
});
</script>
