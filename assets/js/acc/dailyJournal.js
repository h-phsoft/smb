/* global PhSettings, PhTabulatorLocale, PhUtility, swal, KTUtil, PhTable, PHTABLE_WIDTH_FIXED, PhTable_WIDTH_FIXED */

var table;
var phTable;
jQuery(document).ready(function () {

  initPhTable();

  refreshList();

  $('#ph_add').on('click', function () {
    openAddNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('#addRow').on('click', function () {
    phTable.addEmptyRow();
    phTable.render();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

});

function openAddNew(e, cell) {
  $('#editId').val('0');
  $('#editNum').val('');
  $('#editRem').val('');
  phTable.setData([]);
  $('#pageModal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var aRows = phTable.getData();
    PhUtility.doSave({
      'vOperation': "cpy-Account-Journal-JournalSave",
      'nId': $('#editId').val(),
      'nNum': $('#editNum').val(),
      'dDate': $('#editDate').val(),
      'vRem': $('#editRem').val(),
      'aRows': aRows
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();

  $('#editId').val(data.Id);
  $('#editNum').val(data.Num);
  $('#editDate').val(data.Date);
  $('#editRem').val(data.Rem);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Account-Journal-GetDetails",
      "nId": data.Id
    },
    success: function (response) {
      if (response.Status) {
        phTable.setData(response.Data);
      }
    },
    error: function (response) {
    }
  });
  $('#pageModal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Accounting Journal'), {
    'vOperation': "cpy-Account-Journal-JournalDelete",
    'nId': data.Id
  }, refreshList, true);
}

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (PhSettings.current.update) {
    aColumns[nIdx++] = {
      title: getLabel('Edit'),
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    };
  }
  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: "Date",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "center",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Number'),
    field: "Num",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "center",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: "Rem",
    headerHozAlign: "center",
    hozAlign: "center",
    headerFilter: "input"
  };
  if (PhSettings.current.delete) {
    aColumns[nIdx++] = {
      title: getLabel('Delete'),
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator("cpy-Account-Journal-ListJournals", aColumns);
}

function initPhTable() {
  var curnOptions = [];
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Management-Currency-ListAutocomplete"
    },
    success: function (response) {
      if (response.Status) {
        curnOptions = response.Data;
      }
    }
  });

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
      'callback': deleteRow
    }
  };
  aColumns[nIdx++] = {
    title: 'Id',
    field: 'Id',
    visible: false,
    component: 'input',
    enabled: true
  };
  aColumns[nIdx++] = {
    title: 'MstId',
    field: 'MstId',
    visible: false,
    component: 'input',
    enabled: true
  };
  aColumns[nIdx++] = {
    title: getLabel('Debit'),
    field: 'DebC',
    datatype: 'decimal',
    width: '125px',
    aggregate: 'sum',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeDebitC
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Credit'),
    field: 'CrdC',
    datatype: 'decimal',
    width: '125px',
    aggregate: 'sum',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeCreditC
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Account'),
    field: 'AccId',
    rfield: 'AccName',
    width: '300px',
    component: 'input',
    enabled: true,
    defValue: 0,
    defLabel: '',
    autocomplete: true,
    ajax: true,
    ajaxType: 'POST',
    ajaxAsync: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxData: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      'vOperation': 'cpy-Account-Accounts-ListAutocompleteActives'
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Cost Center'),
    field: 'CostId',
    rfield: 'CostName',
    width: '250px',
    component: 'input',
    enabled: true,
    defValue: 0,
    defLabel: '',
    autocomplete: true,
    ajax: true,
    ajaxType: 'POST',
    ajaxAsync: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxData: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Account-CostCenters-ListAutocompleteActives"
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency'),
    field: 'CurnId',
    datatype: 'integer',
    width: '75px',
    component: 'select',
    enabled: true,
    ajax: false,
    options: curnOptions,
    defValue: 1,
    callback: {'event': 'change',
      'callback': onChangeCurrency
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Rate'),
    field: 'Rate',
    datatype: 'decimal',
    width: '90px',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 1,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeRate
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Local Debit'),
    field: 'Deb',
    datatype: 'decimal',
    width: '125px',
    aggregate: 'sum',
    component: 'input',
    enabled: false,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeDebit
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Local Credit'),
    field: 'Crd',
    datatype: 'decimal',
    width: '125px',
    aggregate: 'sum',
    component: 'input',
    enabled: false,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeCredit
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: 'Rem',
    width: '300px',
    component: 'input',
    enabled: true
  };
  phTable = new PhTable('phTable', aColumns, [], {widthType: PhTable_WIDTH_FIXED});
  phTable.setHeight(40);
}

function deleteRow() {
  phTable.deleteRow(parseInt($(this).data('row')));
}

function onChangeDebitC() {
  var nRow = $(this).data('row');
  changeDebitC(nRow);
}

function onChangeCreditC() {
  var nRow = $(this).data('row');
  changeCreditC(nRow);
}

function onChangeCurrency() {
  var nRate = 1;
  var nRow = $(this).data('row');
  var nId = $(this).val();
  if (nId !== '') {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Management-Currency-GetRate",
        "nId": nId
      },
      success: function (response) {
        try {
          if (response.Status) {
            nRate = response.nRate;
            if (nId === 1) {
              phTable.disableField(nRow, 'Deb');
              phTable.disableField(nRow, 'Crd');
            } else {
              phTable.enableField(nRow, 'Deb');
              phTable.enableField(nRow, 'Crd');
            }
            changeRate(nRow, nRate);
          }
        } catch (ex) {
        }
      },
      error: function (response) {

      }
    });
  }

}

function onChangeRate() {
  var nRow = $(this).data('row');
  var nRate = parseFloat($(this).val());
  console.log('OnChange Rate', 'RowNum=[' + nRow + ']');
  changeRate(nRow, nRate);
}

function onChangeDebit() {
  console.log('OnChange Debit');
}

function onChangeCredit() {
  console.log('OnChange Credit');
}

function changeDebitC(nRow) {
  var nDebitC = parseFloat(phTable.getFieldValue(nRow, 'DebC'));
  var nRate = parseFloat(phTable.getFieldValue(nRow, 'Rate'));
  var nDebit = parseFloat(nDebitC * nRate);
  phTable.setFieldValue(nRow, 'Deb', nDebit);
  if (nDebit > 0) {
    phTable.setFieldValue(nRow, 'Crd', 0);
    phTable.setFieldValue(nRow, 'CrdC', 0);
  }
}

function changeCreditC(nRow) {
  var nCreditC = parseFloat(phTable.getFieldValue(nRow, 'CrdC'));
  var nRate = parseFloat(phTable.getFieldValue(nRow, 'Rate'));
  var nCredit = parseFloat(nCreditC * nRate);
  phTable.setFieldValue(nRow, 'Crd', nCredit);
  if (nCredit > 0) {
    phTable.setFieldValue(nRow, 'Deb', 0);
    phTable.setFieldValue(nRow, 'DebC', 0);
  }
}

function changeRate(nRow, nRate) {
  phTable.setFieldValue(nRow, 'Rate', nRate);
  var nDebitC = parseFloat(phTable.getFieldValue(nRow, 'DebC'));
  if (nDebitC > 0) {
    var nDebit = parseFloat(nDebitC * nRate);
    phTable.setFieldValue(nRow, 'Deb', nDebit);
    phTable.setFieldValue(nRow, 'Crd', 0);
    phTable.setFieldValue(nRow, 'CrdC', 0);
  } else {
    var nCreditC = parseFloat(phTable.getFieldValue(nRow, 'CrdC'));
    if (nCreditC > 0) {
      var nCredit = parseFloat(nCreditC * nRate);
      phTable.setFieldValue(nRow, 'Crd', nCredit);
      phTable.setFieldValue(nRow, 'Deb', 0);
      phTable.setFieldValue(nRow, 'DebC', 0);
    }
  }
}
