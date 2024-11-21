$(document).ready(function(){
  dataTable = $("#main_profiling").DataTable({
    dom: 'Brtp',
    scrollX: true,
    pageLength: 10,
    buttons: [
      {
        remove: 'true',
      }
    ],
    'columnDefs': [ {
      'targets': [2,3,4,5,6,9], /* column index */
      'orderable': false, /* true or false */
    }]
  });

  var table = dataTable;
  var filter = createFilter(table, [1,2,7]);

  function createFilter(table, columns) {
    var input = $('input#keyword').on("keyup", function() {
      table.draw();
    });
    
    $.fn.dataTable.ext.search.push(function(
      settings,
      searchData,
      index,
      rowData,
      counter
    ) {
      var val = input.val().toLowerCase();
  
      for (var i = 0, ien = columns.length; i < ien; i++) {
        if (searchData[columns[i]].toLowerCase().indexOf(val) !== -1) {
          return true;
        }
      }
  
      return false;
    });
    
    return input;
  }

  $('select#acad_type').on('change', function(e){
    var status = $(this).val();
    dataTable.columns([3]).search(status).draw();
  });

  $('select#faculty_type').on('change', function(e){
    var status = $(this).val();
    dataTable.columns([6]).search(status).draw();
  });
})