/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
jQuery(document).ready(function () {

  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  refreshList();
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
});

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.Id);
  $('#fldNum').val(data.Num);
  $('#fldName').val(data.Name);
  $('#fldType').val(data.Type);
  $('#fldType').change();
  $('#fldStatus').val(data.Status);
  $('#fldStatus').change();
  $('#fldRem').val(data.Rem);
  $('#pageModal').modal('show');
}

function openNew() {
  $('#fldId').val('');
  $('#fldNum').val('');
  $('#fldName').val('');
  $('#fldType').val(2);
  $('#fldType').change();
  $('#fldStatus').val(1);
  $('#fldStatus').change();
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
      "vOperation": "cpy-Account-CostCenters-ListCosts"
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
                headerSort: false,
                formatter: function (cell, formatterParams) {
                  return PhUtility.editButton();
                },
                cellClick: cellEditClick
              },
              {title: getLabel('Number'),
                field: "Num",
                width: "10%",
                hozAlign: "center",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Name'),
                field: "Name",
                hozAlign: "left",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Type'),
                field: "TypeName",
                width: "10%",
                hozAlign: "left",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Status'),
                field: "StatusName",
                width: "10%",
                hozAlign: "left",
                headerFilter: "input",
                formatter: function (cell, formatterParams) {
                  var value = cell.getData().Status;
                  return PhUtility.statusFormatter(value, cell.getData().StatusName);
                }
              },
              {title: getLabel('Remarks'),
                field: "Rem",
                hozAlign: "left",
                headerFilter: "input",
                formatter: "textarea"
              },
              {title: getLabel('Delete'),
                width: "5%",
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

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Account-CostCenters-CostSave",
      'nId': $('#fldId').val(),
      'vNum': $('#fldNum').val(),
      'vName': $('#fldName').val(),
      'vRem': $('#fldRem').val(),
      'nType': $('#fldType').val(),
      'nStatus': $('#fldStatus').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Cost Center'), {"vOperation": "cpy-Account-CostCenters-CostDelete", "nId": data.Id}, refreshList);
}
