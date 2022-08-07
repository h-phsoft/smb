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
  $('#fldClinicId').val(0);
  $('#fldPatientId').val(0);
  $('#fldPatientId').val('');
  $('#fldDate').val('');
  $('#fldAmt').val(0);
  $('#fldDescription').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Clinic-Finance-Discount-Save',
      'nId': $('#fldId').val(),
      // 'nClinicId': $('#fldClinicId').val(),
      'nClinicId': 1,
      'nPatientId': $('#fldPatientId').val(),
      'dDate': $('#fldDate').val(),
      'nAmt': $('#fldAmt').val(),
      'vDescription': $('#fldDescription').val(),
    }, refreshList);
    if (!(parseInt($('#fldId').val()) > 0)) {
      $("#ph_Form").trigger("reset");
    }
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldClinicId').val(data.nClinicId);
  $('#fldPatientId').val(data.nPatientId);
  $('#fldPatientName').val(data.vPatientName);
  $('#fldDate').val(data.dDate);
  $('#fldAmt').val(data.nAmt);
  $('#fldDescription').val(data.vDescription);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-Finance-Discount-Delete',
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
    title: getLabel('Clinic'),
    field: 'vClinicName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Patient'),
    field: 'vPatientName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: 'dDate',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Amt'),
    field: 'nAmt',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Description'),
    field: 'vDescription',
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
  table = getAjaxTabulator('cpy-Clinic-Finance-Discount-List', aColumns);
}
