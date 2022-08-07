/* global PhSettings, PhTabulatorLocale, KTUtil, swal, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openAddWarehouse();
  });

  $('#ph_edit_submit').on('click', function () {
    saveWarehouse();
  });

  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

  refreshList();

});

function refreshList() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Warehouse-Warehouse-ListWarehouses"
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          var aColumns = [
            {title: getLabel('Edit'),
              width: "4%",
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
              headerSort: false
            },
            {title: getLabel('Name'),
              field: "Name",
              hozAlign: "left",
              headerSort: false,
              formatter: "textarea"
            },
            {title: getLabel('Start'),
              field: "SDate",
              width: "10%",
              hozAlign: "left",
              headerSort: false
            },
            {title: getLabel('End'),
              field: "EDate",
              width: "10%",
              hozAlign: "left",
              headerSort: false
            },
            {title: getLabel('Address'),
              field: "Address",
              hozAlign: "left",
              headerSort: false,
              formatter: "textarea"
            },
            {title: getLabel('Remarks'),
              field: "Rem",
              hozAlign: "left",
              headerSort: false,
              formatter: "textarea"
            },
            {title: getLabel('Delete'),
              width: "4%",
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
  $("#ph_warehouse_form").trigger("reset");
  var data = cell.getData();
  $('#editId').val(data.Id);
  $('#editNum').val(data.Num);
  $('#editName').val(data.Name);
  $('#editAddress').val(data.Address);
  $('#editRem').val(data.Rem);
  $('#editStatus').val(data.Status);
  $('#editType').val(data.Type);
  $('#editOwned').val(data.Owned);
  $('#pageModal').modal('show');
}

function openAddWarehouse() {
  $("#ph_warehouse_form").trigger("reset");
  $('#editId').val(0);
  $('#editType').val(2);
  $('#pageModal').modal('show');
}

function saveWarehouse() {
  var form = KTUtil.getById('ph_warehouse_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      "vOperation": "cpy-Warehouse-Warehouse-Save",
      "nId": $('#editId').val(),
      "nNum": $('#editNum').val(),
      "vName": $('#editName').val(),
      "nType": $('#editType').val(),
      "nStatus": $('#editStatus').val(),
      "nUser": $('#editUser').val(),
      "nOwned": $('#editOwned').val(),
      "dSDate": $('#editSDate').val(),
      "dEDate": $('#editEDate').val(),
      "vAddress": $('#editAddress').val(),
      "vRem": $('#editRem').val()
    }, refreshALL, false);
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Warehouse'), {"vOperation": "cpy-Warehouse-Warehouse-Delete", "nId": data.Id}, refreshList);
}

function refreshALL() {
  $('#pageModal').modal('hide');
  refreshList();
}
