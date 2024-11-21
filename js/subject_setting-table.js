$(document).ready(function(){
  dataTable = $("#subject_setting").DataTable({
    lengthChange: false,
    searching: false, 
    paging: false, 
    info: false,
    'columnDefs': [ {
      'targets': [all], /* column index */
      'orderable': false, /* true or false */
    }]
  });
})