/* global PhSettings, PhUtility, swal, KTUtil */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    var vName = $('#lstCode option:selected').text();
    $('#editId').val(0);
    $('#editName').val('');
    $('#editRem').val('');
    $('#editModalLabel').text(getLabel(PhSettings.Title) + ' >> ' + vName);
    $('#editModal').modal('show');
  });

  $('#lstCode').on('change', function () {
    refreshList();
  });

  $('#ph_edit_submit').on('click', function () {
    save();
  });
  refreshList();
});

function refreshALL() {
  $('#editId').val(0);
  $('#editName').val('');
  $('#editRem').val('');
  $('#editModal').modal('hide');
  refreshList();
}
function refreshList() {
  var vCode = $('#lstCode').val();
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-Codes-ListCodes",
      "code": vCode
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          var aColumns = [];
          var nIdx = 0;
          if (PhSettings.current.update) {
            aColumns[nIdx++] = {
              title: getLabel('Edit'),
              width: "5%",
              headerSort: false,
              formatter: function (cell, formatterParams) {
                return PhUtility.editButton();
              },
              cellClick: cellEditClick
            };
          }
          aColumns[nIdx++] = {
            title: getLabel('Name'),
            field: "Name",
            hozAlign: "left",
            headerFilter: "input"
          };
          aColumns[nIdx++] = {
            title: getLabel('Remarks'),
            field: "Rem",
            hozAlign: "left",
            headerFilter: "input"
          };
          if (PhSettings.current.delete) {
            aColumns[nIdx++] = {
              title: getLabel('Delete'),
              width: "5%",
              headerSort: false,
              formatter: function (cell, formatterParams) {
                return PhUtility.deleteButton();
              },
              cellClick: cellDeleteClick
            };
          }
          table = getTabulator(aColumns, res.Data);
          $('.toggle-all').on('click', function () {
            toggleAll($(this));
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
        }
      } catch (ex) {
      }
    },
    error: function (response) {
      try {
        var res = JSON.parse(response);
        swal.fire({
          text: res.Message,
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: getLabel('OK'),
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  if (PhSettings.current.update) {
    var vName = $('#lstCode option:selected').text();
    $('#editModalLabel').text(getLabel(PhSettings.Title) + ' >> ' + vName);
    $('#editId').val(data.Id);
    $('#editName').val(data.Name);
    $('#editRem').val(data.Rem);
    $('#editModal').modal('show');
  }
}

function save() {
  var form = KTUtil.getById('ph_edit_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Copy-Codes-Save",
      'code': $('#lstCode').val(),
      'nId': $('#editId').val(),
      'vName': $('#editName').val(),
      'vRem': $('#editRem').val()
    }, refreshALL);
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  if (PhSettings.current.delete) {
    PhUtility.doDelete(getLabel('Code'), {"vOperation": "cpy-Copy-Codes-Delete", 'code': $('#lstCode').val(), "nId": data.Id}, refreshALL, false);
  }
}
