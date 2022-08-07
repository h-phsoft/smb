/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  refreshList();
});

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldName').val('');
  $('#fldCostId').val('');
  $('#fldCostName').val('');
  $('#fldAccId').val('');
  $('#fldAccName').val('');
  $('#fldRem').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Cash-Cashier-Save',
      'nId': $('#fldId').val(),
      'vName': $('#fldName').val(),
      'nCostId': $('#fldCostId').val(),
      'nAccId': $('#fldAccId').val(),
      'vRem': $('#fldRem').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldName').val(data.vName);
  $('#fldCostId').val(data.nCostId);
  $('#fldCostName').val(data.vCostName);
  $('#fldAccId').val(data.nAccId);
  $('#fldAccName').val(data.vAccName);
  $('#fldRem').val(data.vRem);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Cash-Cashier-Delete',
    'nId': data.nId
  }, refreshALL);
}

function refreshALL() {
  refreshList();
}
function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (PhSettings.current.update) {
    aColumns[nIdx++] = {
      title: getLabel(''),
      width: '4%',
      hozAlign: 'center',
      headerHozAlign: 'center',
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    };
  }
  aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: 'vName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Cost Center'),
    field: 'vCostName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Account'),
    field: 'vAccName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: 'vRem',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  if (PhSettings.current.delete) {
    aColumns[nIdx++] = {
      title: getLabel(''),
      width: '4%',
      hozAlign: 'center',
      headerHozAlign: 'center',
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator('cpy-Cash-Cashier-List', aColumns);
}
