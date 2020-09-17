function open_task_modal(task_id, case_id, req_url, edit_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id, case_id: case_id
    },
    success: function (data) {


      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');

      editTaskDetails(task_id, edit_url);


    }
  });

}

function editTaskDetails(task_id, edit_url) {


  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: edit_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id
    },
    success: function (data) {

      // Parse the data as json
      var obj = JSON.parse(data)


      $('#title').val(obj.title);
      $('#description').val(obj.description);
      $('#status').val(obj.status);
      $('#task_assigned').val(obj.task_assigned);
      $('#due_date').val(obj.due_date);
      $('#task_id').val(task_id);


    }
  });

}

function open_emaillog_modal(task_id, task_title, req_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id, task_title: task_title
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');
    }
  });

}

function delete_task(task_id, delete_url) {

  var r = confirm("Are you sure you want to delete ?");
  if (r == true) {
    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: delete_url,
      dataType: 'html',
      data: {
        token: $('meta[name="csrf-token"]').attr('content'),
        task_id: task_id
      },
      success: function (html) {
        $('#myModal').modal('hide');
        location.reload();
      }
    });
  }
}


function open_class_linked_task__modal(task_id, req_url, edit_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id,
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');


    }
  });

}

function task_link_modal(task_id, req_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id,
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');


    }
  });

}

function case_link_incident_modal(case_id, req_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      case_id: case_id,
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');


    }
  });

}

function savecaseincidentdata(incidentIds, existingincidentIds, caseId, saveUrl) {
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: saveUrl,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      incidentIds: incidentIds, existingincidentIds: existingincidentIds, caseId: caseId,
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');
      location.reload(true);

    }
  });
}

function open_add_incident_modal(case_id, req_url) {

  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      case_id: case_id
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');


    }
  });

}

function open_change_status_task_modal(task_id, case_id, req_url, edit_url) {
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
      task_id: task_id, case_id: case_id
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');
    }
  });
}

function open_gragh_to_get_location(req_url) {
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: req_url,
    dataType: 'html',
    data: {// change data to this object
      token: $('meta[name="csrf-token"]').attr('content'),
    },
    success: function (data) {
      $('#sectorDetails').html(data);
      $('#modalBt').trigger('click');
    }
  });

}


