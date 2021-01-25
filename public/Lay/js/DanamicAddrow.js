
  $("#addRow").click(function() {
    var html = '';
    html += '<div id="inputFormRow">';
    html += '<div class="input-group mb-3">';
    html += '<input type="text" name="user_id[]" class="form-control m-input" placeholder="โปรดใส่ชื่องานย่อย" ความสำเร็จ aut="off">';
    html += '<div class="col-sm-4">';
    html += '<select class="form-control">';
    html += '<option value="" selected disabled>-- โปรดเลือก --</option>';
    html += '@foreach($Members as $val)';
    html += '<option value="$val->id">{{ $val->name_th}} {{ $val->lname_th }}</option>';
    html += '@endforeach';
    html += '</select>';
    html += '</div>';
    html += '<div class="input-group-append">';
    html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>';
    html += '</div>';
    html += '</div>';
    $('#newRow').append(html);
  });
  // remove row
  $(document).on('click', '#removeRow', function() {
    $(this).closest('#inputFormRow').remove();
  });
