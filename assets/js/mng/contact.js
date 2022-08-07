/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
var phTable;
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
  $('#addRow').on('click', function () {
    phTable.addEmptyRow();
    phTable.render();
  });
  initPhTable();
  refreshList();
});

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldNum').val('');
  $('#fldName').val('');
  $('#fldTitle').val('');
  $('#fldLegal').val('');
  $('#fldOwner').val('');
  $('#fldPerson').val('');
  $('#fldNlmt').val(0);
  $('#fldDlmt').val(0);
  $('#fldStatusId').val(1);
  $('#fldTypeId').val($('#fldTypeId option:first').val());
  $('#fldNatId').val($('#fldNatId option:first').val());
  $('#fldClass1Id').val(0);
  $('#fldClass2Id').val(0);
  $('#fldClass3Id').val(0);
  $('#fldClass4Id').val(0);
  $('#fldClass5Id').val(0);
  $('#fldPhone').val('');
  $('#fldMobile').val('');
  $('#fldEmail').val('');
  $('#fldAddress').val('');
  phTable.setData([]);
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var aRows = phTable.getData();
    PhUtility.doSave({
      'vOperation': 'cpy-Management-Contact-Save',
      'nId': $('#fldId').val(),
      'nNum': $('#fldNum').val(),
      'vName': $('#fldName').val(),
      'vTitle': $('#fldTitle').val(),
      'vLegal': $('#fldLegal').val(),
      'vOwner': $('#fldOwner').val(),
      'vPerson': $('#fldPerson').val(),
      'nNlmt': $('#fldNlmt').val(),
      'nDlmt': $('#fldDlmt').val(),
      'nStatusId': $('#fldStatusId').val(),
      'nTypeId': $('#fldTypeId').val(),
      'nNatId': $('#fldNatId').val(),
      'nClass1Id': $('#fldClass1Id').val(),
      'nClass2Id': $('#fldClass2Id').val(),
      'nClass3Id': $('#fldClass3Id').val(),
      'nClass4Id': $('#fldClass4Id').val(),
      'nClass5Id': $('#fldClass5Id').val(),
      'vPhone': $('#fldPhone').val(),
      'vMobile': $('#fldMobile').val(),
      'vEmail': $('#fldEmail').val(),
      'vAddress': $('#fldAddress').val(),
      'aRows': aRows
    }, refreshALL);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldNum').val(data.nNum);
  $('#fldName').val(data.vName);
  $('#fldTitle').val(data.vTitle);
  $('#fldLegal').val(data.vLegal);
  $('#fldOwner').val(data.vOwner);
  $('#fldPerson').val(data.vPerson);
  $('#fldNlmt').val(data.nNlmt);
  $('#fldDlmt').val(data.nDlmt);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldTypeId').val(data.nTypeId);
  $('#fldNatId').val(data.nNatId);
  $('#fldClass1Id').val(data.nClass1Id);
  $('#fldClass2Id').val(data.nClass2Id);
  $('#fldClass3Id').val(data.nClass3Id);
  $('#fldClass4Id').val(data.nClass4Id);
  $('#fldClass5Id').val(data.nClass5Id);
  $('#fldPhone').val(data.vPhone);
  $('#fldMobile').val(data.vMobile);
  $('#fldEmail').val(data.vEmail);
  $('#fldAddress').val(data.vAddress);
  $('#fldClass1Id').change();
  $('#fldClass2Id').change();
  $('#fldClass3Id').change();
  $('#fldClass4Id').change();
  $('#fldClass5Id').change();
  $('#fldNatId').change();
  $('#fldStatusId').change();
  $('#fldTypeId').change();
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      'vOperation': 'cpy-Management-Contact-GetDetails',
      'nId': data.nId
    },
    success: function (response) {
      if (response.Status) {
        phTable.setData(response.Data);
      }
    },
    error: function (response) {
    }
  });
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Management-Contact-Delete',
    'nId': data.nId
  }, refreshALL);
}

function refreshALL() {
  $('#ph_Modal').modal('hide');
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
    title: getLabel('Number'),
    field: 'nNum',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('cont.Title'),
    field: 'vTitle',
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
    title: getLabel('Legal Name'),
    field: 'vLegal',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Contact Person'),
    field: 'vPerson',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: 'vStatusName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Type'),
    field: 'vTypeName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Phone'),
    field: 'vPhone',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Mobile'),
    field: 'vMobile',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Email'),
    field: 'vEmail',
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
  table = getAjaxTabulator('cpy-Management-Contact-List', aColumns);
}

function initPhTable() {
  var aColumns = [];
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: '<i class="icon flaticon-delete p-0"></i>',
    field: 'delrow',
    width: '35px',
    component: 'button',
    enabled: true,
    classes: 'btn-danger',
    format: '<i class="icon flaticon-delete p-0"></i>',
    callback: {'event': 'click',
      'callback': phTableDeleteRow
    }
  };
  aColumns[nIdx++] = {
    title: 'nId',
    field: 'nId',
    visible: false,
    component: 'input',
    enabled: true
  };
  aColumns[nIdx++] = {
    title: 'ParentId',
    field: 'nPId',
    visible: false,
    component: 'input',
    enabled: true
  };
  aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: 'vName',
    width: '235px',
    component: 'input',
    enabled: true,
    required: true,
    defValue: '',
    defLabel: '',
    callback: {'event': 'change',
      'callback': onChangePhCell
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('cont.Title'),
    field: 'vPosition',
    width: '200px',
    component: 'input',
    enabled: true,
    required: true,
    defValue: '',
    defLabel: '',
    callback: {'event': 'change',
      'callback': onChangePhCell
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Mobile'),
    field: 'vMobile',
    width: '200px',
    component: 'input',
    enabled: true,
    defValue: '',
    defLabel: '',
    callback: {'event': 'change',
      'callback': onChangePhCell
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Phone'),
    field: 'vPhone',
    width: '200px',
    component: 'input',
    enabled: true,
    defValue: '',
    defLabel: '',
    callback: {'event': 'change',
      'callback': onChangePhCell
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Email'),
    field: 'vEmail',
    width: '200px',
    component: 'input',
    enabled: true,
    defValue: '',
    defLabel: '',
    callback: {'event': 'change',
      'callback': onChangePhCell
    }
  };
  phTable = new PhTable('phTable', aColumns, []);
  phTable.setHeight(25);
}

function onChangePhCell() {
  var nRow = $(this).data('row');
  //changePhCell(nRow);
  //var nFieldValue = parseFloat(phTable.getFieldValue(nRow, 'FieldName'));
  //phTable.setFieldValue(nRow, 'FieldName', 'FieldValue');
}

function phTableDeleteRow() {
  phTable.deleteRow(parseInt($(this).data('row')));
}

