/* global PhSettings, PhUtility, PhTabulatorLocale, KTUtil */
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
  $('#fldStorId').val($('#fldStorId :first').val());
  $('#fldName').val('');
  $('#fldRem').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Clinic-Specialties-Save',
      'nId': $('#fldId').val(),
      'nStorId': $('#fldStorId').val(),
      'vName': $('#fldName').val(),
      'vRem': $('#fldRem').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldStorId').val(data.nStorId);
  $('#fldName').val(data.vName);
  $('#fldRem').val(data.vRem);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-Specialties-Delete',
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
      title: getLabel('Store'),
      field: 'vStorName',
      hozAlign: 'left',
      width :'25%',
      headerHozAlign: 'center',
      headerFilter: 'input',
      formatter: 'textarea'
  };
  aColumns[nIdx++] = {
      title: getLabel('Rem'),
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
  table = getAjaxTabulator('cpy-Clinic-Specialties-List', aColumns);
}
