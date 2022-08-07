/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNew();
  });
  refreshList();
  $('#ph_submit').on('click', function () {
    save();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
});

function openNew() {
  $('#fldId').val('');
  $('#fldOrd').val('');
  $('#fldName').val('');
  $('#fldRem').val('');
  $('#pageModal').modal('show');
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
      "vOperation": "cpy-Account-ClosingAccounts-ListClosingAccounts"
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          table = new Tabulator("#tabulatorTable", {
            layout: "fitColumns",
            height: "100%",
            textDirection: PhSettings.direction,
            locale: true,
            langs: PhTabulatorLocale,
            cellVertAlign: "middle",
            variableHeight: true,
            pagination: "local",
            paginationSize: 5,
            paginationSizeSelector: [5, 10, 25, 50, 75, 100],
            data: res.Data,
            columns: [
              {title: getLabel('Edit'),
                width: "5%",
                headerHozAlign: "center",
                hozAlign: "center",
                headerSort: false,
                formatter: function (cell, formatterParams) {
                  return PhUtility.editButton();
                },
                cellClick: cellEditClick
              },
              {title: getLabel('Order'),
                field: "Ord",
                width: "10%",
                headerHozAlign: "center",
                hozAlign: "center",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Name'),
                field: "Name",
                width: "30%",
                headerHozAlign: "center",
                hozAlign: "left",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Remarks'),
                field: "Rem",
                headerHozAlign: "center",
                hozAlign: "left",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Delete'),
                width: "5%",
                headerHozAlign: "center",
                hozAlign: "center",
                headerSort: false,
                formatter: function (cell, formatterParams) {
                  return PhUtility.deleteButton();
                },
                cellClick: cellDeleteClick
              }
            ]
          });
          table.setLocale(PhSettings.locale);
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
  var data = cell.getData();
  $('#fldId').val(data.Id);
  $('#fldOrd').val(data.Ord);
  $('#fldName').val(data.Name);
  $('#fldRem').val(data.Rem);
  $('#pageModal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Account-ClosingAccounts-ClosingAccountSave",
      'nId': $('#fldId').val(),
      'nOrd': $('#fldOrd').val(),
      'vName': $('#fldName').val(),
      'vRem': $('#fldRem').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Closing Accounts'), {"vOperation": "cpy-Account-ClosingAccounts-ClosingAccountDelete", "nId": data.Id}, refreshList);
}
