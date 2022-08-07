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
  $('#fldGuid').val('');
  $('#fldStatusId').val(1);
  $('#fldShour').val(0);
  $('#fldSminute').val(0);
  $('#fldEhour').val(23);
  $('#fldEminute').val(59);
  $('#fldDay1').val(1);
  $('#fldDay2').val(1);
  $('#fldDay3').val(1);
  $('#fldDay4').val(1);
  $('#fldDay5').val(1);
  $('#fldDay6').val(1);
  $('#fldDay7').val(1);
  $('#fldAddedAt').val('');
  $('#fldDay1').change();
  $('#fldDay2').change();
  $('#fldDay3').change();
  $('#fldDay4').change();
  $('#fldDay5').change();
  $('#fldDay6').change();
  $('#fldDay7').change();
  $('#fldStatusId').change();
  $('#ph_Modal').modal('show');
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldName').val(data.vName);
  $('#fldGuid').val(data.vGuid);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldShour').val(data.nShour);
  $('#fldSminute').val(data.nSminute);
  $('#fldEhour').val(data.nEhour);
  $('#fldEminute').val(data.nEminute);
  $('#fldDay1').val(data.nDay1);
  $('#fldDay2').val(data.nDay2);
  $('#fldDay3').val(data.nDay3);
  $('#fldDay4').val(data.nDay4);
  $('#fldDay5').val(data.nDay5);
  $('#fldDay6').val(data.nDay6);
  $('#fldDay7').val(data.nDay7);
  $('#fldAddedAt').val(data.dAddedAt);
  $('#fldDay1').change();
  $('#fldDay2').change();
  $('#fldDay3').change();
  $('#fldDay4').change();
  $('#fldDay5').change();
  $('#fldDay6').change();
  $('#fldDay7').change();
  $('#fldStatusId').change();
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Copy-Devices-Delete',
    'nId': data.nId
  }, refreshALL);
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Copy-Devices-Save',
      'nId': $('#fldId').val(),
      'vName': $('#fldName').val(),
      'vGuid': $('#fldGuid').val(),
      'nStatusId': $('#fldStatusId').val(),
      'nShour': $('#fldShour').val(),
      'nSminute': $('#fldSminute').val(),
      'nEhour': $('#fldEhour').val(),
      'nEminute': $('#fldEminute').val(),
      'nDay1': $('#fldDay1').val(),
      'nDay2': $('#fldDay2').val(),
      'nDay3': $('#fldDay3').val(),
      'nDay4': $('#fldDay4').val(),
      'nDay5': $('#fldDay5').val(),
      'nDay6': $('#fldDay6').val(),
      'nDay7': $('#fldDay7').val(),
      'dAddedAt': $('#fldAddedAt').val(),
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
    title: getLabel('Name'),
    field: 'vName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('GUID'),
    field: 'vGuid',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: 'vStatusName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Start Hour'),
    field: 'nShour',
    width: '7%',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Sstart Minute'),
    field: 'nSminute',
    width: '7%',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('End Hour'),
    field: 'nEhour',
    width: '7%',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('End Minute'),
    field: 'nEminute',
    width: '7%',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Added at'),
    field: 'dAddedAt',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerSort: false,
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
  table = getAjaxTabulator('cpy-Copy-Devices-List', aColumns);
}
