$(document).ready(function(){
  dataTable = $("#main_faculty_regular").DataTable({
    dom: 'Brtp',
    scrollX: true,
    pageLength: 10,
    buttons: [
      {
        remove: 'true',
      }
    ],
    'columnDefs': [ {
        'targets': [1,3,4,5,6,7,8], /* column index */
        'orderable': false, /* true or false */
    }]
  });

  var table = dataTable;
  var filter = createFilter(table, [1,2,3]);

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

  $('select#school_year').on('change', function(e){
    var status = $(this).val();
    dataTable.columns([7]).search(status).draw();
  });

  $('select#semester').on('change', function(e){
    var status = $(this).val();
    dataTable.columns([8]).search(status).draw();
  });
})


$(document).ready(function () {
  // Initialize DataTable
  dataTable = $("#main_faculty_visiting").DataTable({
    dom: 'Brtp',
    pageLength: 10,
    buttons: [
      {
        remove: 'true',
      }
    ],
    'columnDefs': [
      {
        'targets': [1, 3, 4, 5, 6, 7, 8], /* column index */
        'orderable': false, /* true or false */
      }
    ]
  });

  // Function to create filter input
  var table = dataTable;
  var filter = createFilter(table, [1, 2, 3]);

  function createFilter(table, columns) {
    var input = $('input#keyword').on("keyup", function () {
      table.draw();
    });

    $.fn.dataTable.ext.search.push(function (
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

  // Event handler for Bootstrap tab shown event
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    // Adjust DataTable columns when the tab becomes visible
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  });

  // Event handler for school year filter
  $('select#school_year').on('change', function (e) {
    var status = $(this).val();
    dataTable.columns([7]).search(status).draw();
  });

  // Event handler for semester filter
  $('select#semester').on('change', function (e) {
    var status = $(this).val();
    dataTable.columns([8]).search(status).draw();
  });
});
