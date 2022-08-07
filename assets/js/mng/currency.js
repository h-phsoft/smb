/* global PhSettings, PhTabulatorLocale, KTUtil, swal, PhUtility */
var table;
jQuery(document).ready(function () {

  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

  $('#ph_add').on('click', function () {
    $("#ph_form").trigger("reset");
    $('#editId').val(0);
    $('#pageModal').modal('show');
  });

  $('#ph_edit_submit').on('click', function () {
    save();
  });

  refreshList();
});

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#editId').val(data.Id);
  $('#editNum').val(data.Num);
  $('#editCode').val(data.Code);
  $('#editName').val(data.Name);
  $('#editRate').val(data.Rate);
  $('#editRem').val(data.Rem);
  $('#pageModal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.Name, {"vOperation": "cpy-Management-Currency-Delete", "nId": data.Id});
}

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      "vOperation": "cpy-Management-Currency-Save",
      "nId": $('#editId').val(),
      "num": $('#editNum').val(),
      "code": $('#editCode').val(),
      "name": $('#editName').val(),
      "rate": $('#editRate').val(),
      "rem": $('#editRem').val()
    }, refreshList, false);
  } else {
    form.classList.add('was-validated');
  }
}

function refreshList() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Management-Currency-ListCurrecnies"
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          var aColumns = [
            {title: getLabel('Edit'),
              width: "5%",
              headerSort: false,
              formatter: function (cell, formatterParams) {
                return PhUtility.editButton();
              },
              cellClick: cellEditClick
            },
            {title: getLabel('Number'),
              field: "Num",
              width: "10%",
              hozAlign: "left",
              headerFilter: "input"
            },
            {title: getLabel('Code'),
              field: "Code",
              width: "10%",
              hozAlign: "left",
              headerFilter: "input"
            },
            {title: getLabel('Name'),
              field: "Name",
              width: "30%",
              hozAlign: "left",
              headerFilter: "input"
            },
            {title: getLabel('Rate'),
              field: "Rate",
              width: "10%",
              hozAlign: "left",
              headerFilter: "input"
            },
            {title: getLabel('Remarks'),
              field: "Rem",
              width: "30%",
              hozAlign: "left",
              headerFilter: "input"
            },
            {title: getLabel('Delete'),
              width: "5%",
              headerSort: false,
              formatter: function (cell, formatterParams) {
                return PhUtility.deleteButton();
              },
              cellClick: cellDeleteClick
            }
          ];
          table = getTabulator(aColumns, res.Data);
          window.addEventListener('resize', function () {
            table.redraw(true);
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel(getLabel('OK')),
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
          confirmButtonText: getLabel(getLabel('OK')),
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}