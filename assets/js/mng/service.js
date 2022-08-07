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
  $('#fldCode').val('');
  $('#fldName').val('');
  $('#fldCst').val(0);
  $('#fldCostId').val('');
  $('#fldCostName').val('');
  $('#fldAccCid').val('');
  $('#fldAccCName').val('');
  $('#fldAccRid').val('');
  $('#fldAccRname').val('');
  $('#fldUnitId').val(1);
  $('#fldGrp').val('');
  $('#fldRem').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Management-Service-Save',
      'nId': $('#fldId').val(),
      'vCode': $('#fldCode').val(),
      'vName': $('#fldName').val(),
      'nCst': $('#fldCst').val(),
      'nCostId': $('#fldCostId').val(),
      'nAccCid': $('#fldAccCid').val(),
      'nAccRid': $('#fldAccRid').val(),
      'nUnitId': $('#fldUnitId').val(),
      'vGrp': $('#fldGrp').val(),
      'vRem': $('#fldRem').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldCode').val(data.vCode);
  $('#fldName').val(data.vName);
  $('#fldCst').val(data.nCst);
  $('#fldCostId').val(data.nCostId);
  $('#fldCostName').val(data.vCostName);
  $('#fldAccCid').val(data.nAccCid);
  $('#fldAccCName').val(data.vAccCName);
  $('#fldAccRid').val(data.nAccRid);
  $('#fldAccRName').val(data.vAccRName);
  $('#fldUnitId').val(data.nUnitId);
  $('#fldGrp').val(data.vGrp);
  $('#fldRem').val(data.vRem);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Management-Service-Delete',
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
    title: getLabel('Code'),
    field: 'vCode',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
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
    title: getLabel('Cost Account'),
    field: 'vAccCName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Revenue Account'),
    field: 'vAccRName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Unit'),
    field: 'vUnitName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Cst'),
    field: 'nCst',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Group'),
    field: 'vGrp',
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
  table = getAjaxTabulator('cpy-Management-Service-List', aColumns);
}
