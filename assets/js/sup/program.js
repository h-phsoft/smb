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
  $('#fldProgId').val(0);
  $('#fldSysId').val(0);
  $('#fldGrp').val(0);
  $('#fldStatusId').val(1);
  $('#fldTypeId').val(0);
  $('#fldOpen').val(0);
  $('#fldOrd').val(0);
  $('#fldName').val('');
  $('#fldIcon').val('');
  $('#fldFile').val('');
  $('#fldCss').val('');
  $('#fldJs').val('');
  $('#fldAttributes').val('');
  $('#ph_Modal').modal('show');
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldProgId').val(data.nProgId);
  $('#fldProgName').val(data.vProgName);
  $('#fldSysId').val(data.nSysId);
  $('#fldGrp').val(data.nGrp);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldTypeId').val(data.nTypeId);
  $('#fldOpen').val(data.nOpen);
  $('#fldOrd').val(data.nOrd);
  $('#fldName').val(data.vName);
  $('#fldIcon').val(data.vIcon);
  $('#fldFile').val(data.vFile);
  $('#fldCss').val(data.vCss);
  $('#fldJs').val(data.vJs);
  $('#fldAttributes').val(data.vAttributes);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'phs-Management-Programs-Delete',
    'nId': data.nId
  }, refreshALL);
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'phs-Management-Programs-Save',
      'nId': $('#fldId').val(),
      'nProgId': $('#fldProgId').val(),
      'nSysId': $('#fldSysId').val(),
      'nGrp': $('#fldGrp').val(),
      'nStatusId': $('#fldStatusId').val(),
      'nTypeId': $('#fldTypeId').val(),
      'nOpen': $('#fldOpen').val(),
      'nOrd': $('#fldOrd').val(),
      'vName': $('#fldName').val(),
      'vIcon': $('#fldIcon').val(),
      'vFile': $('#fldFile').val(),
      'vCss': $('#fldCss').val(),
      'vJs': $('#fldJs').val(),
      'vAttributes': $('#fldAttributes').val(),
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
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
    title: getLabel('Id'),
    field: 'nId',
    width: '10%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Parent'),
    field: 'nProgId',
    width: '5%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: '#',
    field: 'nOrd',
    width: '5%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('System'),
    field: 'vSysName',
    width: '10%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Group'),
    field: 'nGrp',
    width: '5%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: 'vStatusName',
    width: '5%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Type'),
    field: 'vTypeName',
    width: '10%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Open'),
    field: 'nOpen',
    width: '5%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: 'vName',
    width: '20%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Icon'),
    width: '20%',
    field: 'vIcon',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('File'),
    field: 'vFile',
    width: '20%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('JS'),
    field: 'vJs',
    width: '20%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('CSS'),
    field: 'vCss',
    width: '10%',
    hozAlign: 'center',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Attributes'),
    field: 'vAttributes',
    width: '10%',
    hozAlign: 'center',
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
  table = getAjaxTabulator('phs-Management-Programs-List', aColumns);
}
