/* global PhSettings, PhTabulatorLocale, KTUtil, swal, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openAdd();
  });
  $('#ph_submit').on('click', function () {
    save();
  });

  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

  $("#editItem").autocomplete({
    source: function (request, response) {
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          'vOperation': 'cpy-Warehouse-Material-ListOutWarehouseItemsAutocomplete',
          'term': request.term,
          'nStrId': $('#editStore').val()
        },
        success: function (ajaxResponse) {
          response(ajaxResponse.Data);
        }
      });
    },
    minLength: 0,
    focus: function (event, ui) {
      return false;
    },
    select: function (event, ui) {
      var vRelField = $(this).data('relfield');
      $(this).val(ui.item.label);
      $('#' + vRelField).val(ui.item.value);
      return false;
    }
  });
  refreshList();

});

function refreshList() {
  var aColumns = [
    {title: getLabel('Edit'),
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    },
    {title: getLabel('Warehouse'),
      field: "StorName",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Material'),
      field: "Name",
      width: "20%",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Location1'),
      field: "Loc1Name",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Location2'),
      field: "Loc2Name",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Location3'),
      field: "Loc3Name",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('QTY'),
      field: "Qnt",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Amt'),
      field: "Amt",
      headerHozAlign: "center",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Delete'),
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellEditClick
    }
  ];
  table = getAjaxTabulator("cpy-Warehouse-WarehouseMaterials-ListMaterials", aColumns);
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#editId').val(data.Id);
  $('#editRem').val(data.Rem);
  $('#editStore').val(data.StorId);
  $('#editStore').change();
  $('#editItemId').val(data.ItemId);
  $('#editItem').val(data.Name);
  $('#editLoc1').val(data.Loc1Id);
  $('#editLoc1').change();
  $('#editLoc2').val(data.Loc2Id);
  $('#editLoc2').change();
  $('#editLoc3').val(data.Loc3Id);
  $('#editLoc3').change();
  $('#pageModal').modal('show');
}

function openAdd() {
  $('#editId').val('');
  $('#editRem').val('');
  $('#editStore').val($('#editStore option:first').val());
  $('#editStore').change();
  $('#editItemId').val('');
  $('#editItem').val('');
  $('#editLoc1').val($('#editLoc1 option:first').val());
  $('#editLoc1').change();
  $('#editLoc2').val($('#editLoc2 option:first').val());
  $('#editLoc2').change();
  $('#editLoc3').val($('#editLoc3 option:first').val());
  $('#editLoc3').change();
  $('#pageModal').modal('show');
}


function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Warehouse-WarehouseMaterials-Save",
      'nId': $('#Id').val(),
      'nStrId': $('#nStrId').val(),
      'nItemId': $('#nItemId').val(),
      'vRem': $('#itemRem').val(),
      'nMinQnt': $('#nMinQnt').val(),
      'nReqQnt': $('#nReqQnt').val(),
      'nMaxQnt': $('#nMaxQnt').val(),
      'nLoc1': $('#nLoc1').val(),
      'nLoc2': $('#nLoc2').val(),
      'nLoc3': $('#nLoc3').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}
