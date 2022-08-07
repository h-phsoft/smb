/* global KTAppSettings, PhTabulatorLocale, PhSettings, KTUtil, swal, PhUtility */

var phTable;
var table;
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
    title: getLabel('Doc'),
    field: "Doc",
    width: "25%",
    hozAlign: "left",
    headerFilter: "input"
  };

  aColumns[nIdx++] = {
    title: getLabel('Warehouse'),
    field: "Stor",
    hozAlign: "left",
    headerFilter: "input"
  };

  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: "Date",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input"
  };

  aColumns[nIdx++] = {
    title: getLabel('Number'),
    field: "Num",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input"
  };

  aColumns[nIdx++] = {
    title: getLabel('Doc.Number'),
    field: "DocNum",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input"
  };

  aColumns[nIdx++] = {
    title: getLabel('Doc.Date'),
    field: "DocDate",
    width: "10%",
    hozAlign: "left",
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

  table = getAjaxTabulator("cpy-Warehouse-Outbound-ListOutbounds", aColumns);
}

function openAddNew(e, cell) {
  $('#fldId').val('0');
  $('#fldDoc').val($('#fldDoc option:first').val());
  $('#fldStore').val($('#fldStore option:first').val());
  $('#fldAccId').val('');
  $('#fldAccName').val('');
  $('#fldCostId').val('');
  $('#fldCostName').val('');
  $('#fldDocN').val('');
  $('#fldDocD').val(formatDate(new Date(), 'dd-mm-yyyy'));
  $('#fldNum').val('');
  $('#fldDate').val(formatDate(new Date(), 'dd-mm-yyyy'));
  $('#fldRDocN').val('');
  $('#fldRDocD').val('');
  $('#fldRNum').val('');
  $('#fldRem').val('');
  phTable.setData([]);
  $('#pageModal').modal('show');
}

function cellEditClick(e, cell) {
  var data = cell.getData();

  $('#fldId').val(data.Id);
  $('#fldDoc').val(data.DocId);
  $('#fldStore').val(data.StorId);
  $('#fldAccId').val(data.AccId);
  $('#fldAccName').val(data.AccName);
  $('#fldCost').val(data.CostId);
  $('#fldCost').val(data.CostName);
  $('#fldDocN').val(data.DocNum);
  $('#fldDocD').val(data.DocDate);
  $('#fldNum').val(data.Num);
  $('#fldDate').val(data.Date);
  $('#fldRDocN').val(data.RDocNum);
  $('#fldRDocD').val(data.RDocDate);
  $('#fldRNum').val(data.RNum);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Warehouse-Outbound-GetOutbound",
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
  PhUtility.doDelete(getLabel('Outbound'), {
    'vOperation': "cpy-Warehouse-Outbound-OutboundDelete",
    'nId': data.Id
  }, refreshList, true);
}

function initPhTable() {
  var aColumns = [];
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: '<i class="icon-md flaticon-delete p-0"></i>',
    field: 'delrow',
    width: '2.5%',
    component: 'button',
    enabled: true,
    classes: 'btn-danger',
    format: '<i class="icon-md flaticon-delete p-0"></i>',
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
    title: getLabel('Item'),
    field: 'ItemId',
    rfield: 'Item',
    width: '38%',
    component: 'input',
    enabled: true,
    autocomplete: true,
    defValue: 0,
    defLabel: '',
    ajax: true,
    ajaxType: 'POST',
    ajaxAsync: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxData: function () {
      return{
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        'vOperation': 'cpy-Warehouse-Material-ListWarehouseItemsAutocomplete',
        'term': '',
        'nStrId': $('#fldStore').val()
      }
    },
    callback: {'event': 'change',
      'callback': onChangeItem
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('QTY'),
    field: 'Qnt',
    datatype: 'decimal',
    width: '10%',
    aggregate: 'sum',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangeQnt
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Price'),
    field: 'Price',
    datatype: 'decimal',
    width: '10%',
    aggregate: 'sum',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 0,
    classes: 'text-start',
    callback: {'event': 'change',
      'callback': onChangePrice
    }
  };
  aColumns[nIdx++] = {
    title: getLabel('Amount'),
    field: 'Amt',
    datatype: 'decimal',
    width: '10%',
    aggregate: 'sum',
    component: 'input',
    enabled: false,
    required: true,
    defValue: 0,
    classes: 'text-start'
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: 'Rem',
    width: '26%',
    component: 'input',
    enabled: true,
    autocomplete: false,
    defValue: '',
    defLabel: '',
    ajax: false
  };
  phTable = new PhTable('phTable', aColumns, []);
}

function deleteRow() {
  phTable.deleteRow(parseInt($(this).data('row')));
}

function onChangeItem() {
  var nRow = $(this).data('row');
  var nId = phTable.getFieldValue(nRow, 'ItemId');
  if (nId !== '') {
    phTable.setFieldValue(nRow, 'Balance', 0);
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Warehouse-Materials-GetMaterial",
        "nStrId": $('#fldStore').val(),
        "nItemId": nId
      },
      success: function (response) {
        try {
          if (response.Status) {
            phTable.setFieldValue(nRow, 'Balance', response.Data.Qnt1);
          }
        } catch (ex) {
        }
      },
      error: function (response) {

      }
    });
  }

}

function onChangeQnt() {
  var nRow = $(this).data('row');
  var nQnt = parseFloat(phTable.getFieldValue(nRow, 'Qnt'));
  var nPrice = parseFloat(phTable.getFieldValue(nRow, 'Price'));
  if (nQnt === 'NaN' || nQnt <= 0 || nPrice === 'NaN' || nPrice <= 0) {

    return false;
  }
  phTable.setFieldValue(nRow, 'Amt', nQnt * nPrice);
}

function onChangePrice() {
  var nRow = $(this).data('row');
  var nQnt = parseFloat(phTable.getFieldValue(nRow, 'Qnt'));
  var nPrice = parseFloat(phTable.getFieldValue(nRow, 'Price'));
  if (nQnt === 'NaN' || nQnt <= 0 || nPrice === 'NaN' || nPrice <= 0) {

    return false;
  }
  phTable.setFieldValue(nRow, 'Amt', nQnt * nPrice);
}

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var aRows = phTable.getData();
    PhUtility.doSave({
      'vOperation': "cpy-Warehouse-Outbound-OutboundSave",
      'nId': $('#fldId').val(),
      'nDoc': $('#fldDoc').val(),
      'nStore': $('#fldStore').val(),
      'nAcc': $('#fldAccId').val(),
      'nCost': $('#fldCostId').val(),
      'vDocN': $('#fldDocN').val(),
      'dDocD': $('#fldDocD').val(),
      'nNum': $('#fldNum').val(),
      'dDate': $('#fldDate').val(),
      'vRDocN': $('#fldRDocN').val(),
      'dRDocD': $('#fldRDocD').val(),
      'nRNum': $('#fldRNum').val(),
      'vRem': $('#fldRem').val(),
      'aRows': aRows
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}
