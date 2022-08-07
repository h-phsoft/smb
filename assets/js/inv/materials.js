/* global PhSettings, PhTabulatorLocale, KTUtil, PhUtility, swal */
var table;
var phTable;
var image;
jQuery(document).ready(function () {

  image = new KTImageInput('kt_user_edit_image');

  $('#ph_add').on('click', function () {
    openAddItem();
    resizeImage();
  });
  $('#ph_save').on('click', function () {
    saveItem();
  });

  $('#ph_fsave').on('click', function () {
    saveFormula();
  });

  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

  refreshList();

  $(window).on("resize", function () {
    resizeImage();
  }).resize();
  resizeImage();

  $('#addRow').on('click', function () {
    phTable.addEmptyRow();
    phTable.render();
  });
});

function resizeImage() {
  $('#image_preview').height($('#image_preview').width());
}

function refreshList() {
  var aColumns = [
    {title: getLabel('Edit'),
      width: "4%",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    },
    {title: getLabel('Number'),
      field: "Num",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Name'),
      field: "Name",
      width: "15%",
      hozAlign: "left",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Unit'),
      field: "UnitName",
      hozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Status'),
      field: "StatusName",
      hozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Price'),
      field: "nNPrice",
      formatter: "money",
      bottomCalcFormatter: "money",
      hozAlign: "left",
      headerFilter: "input"
    },
    {title: getLabel('Spec.1'),
      field: "Spc1Name",
      hozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Spec.2'),
      field: "Spc2Name",
      hozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Spec.3'),
      field: "Spc3Name",
      hozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Delete'),
      width: "4%",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    },
  ];
  table = getAjaxTabulator("cpy-Warehouse-Material-ListMaterials", aColumns);
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#itemId').val(data.Id);
  $('#itemNum').val(data.Num);
  $('#itemPartNum').val(data.PartNum);
  $('#itemName').val(data.Name);
  $('#itemRem').val(data.Rem);
  $('#itemBox').val(data.Box);
  $('#itemCost').val(data.CCost);
  $('#itemnPrice').val(data.nNPrice);
  $('#itemdPrice').val(data.nDPrice);
  $('#itemsPrice').val(data.nSPrice);
  $('#itemwPrice').val(data.nWPrice);
  $('#itemhPrice').val(data.nHPrice);
  $('#itemrPrice').val(data.nRPrice);
  $('#itemmPrice').val(data.nMPrice);
  $('#itemCat').val(data.Cat);
  $('#itemCat').change();
  $('#itemType').val(data.Type);
  $('#itemType').change();
  $('#itemStatus').val(data.Status);
  $('#itemStatus').change();
  $('#itemUnit').val(data.Unit);
  $('#itemUnit').change();
  $('#itemSpc1').val(data.Spc1);
  $('#itemSpc1').change();
  $('#itemSpc2').val(data.Spc2);
  $('#itemSpc2').change();
  $('#itemSpc3').val(data.Spc3);
  $('#itemSpc3').change();
  $('#itemSpc4').val(data.Spc3);
  $('#itemSpc4').change();
  $('#itemSpc5').val(data.Spc3);
  $('#itemSpc5').change();
  $('#attPreview').attr('src', data.Image);
  $('#itemModal').modal('show');
}

function openAddItem() {
  $("#itemForm").trigger("reset");
  $('#itemId').val('');
  $('#itemNum').val('');
  $('#itemPartNum').val('');
  $('#itemName').val('');
  $('#itemRem').val('');
  $('#itemBox').val(1);
  $('#itemCost').val(0);
  $('#itemnPrice').val(0);
  $('#itemdPrice').val(0);
  $('#itemsPrice').val(0);
  $('#itemwPrice').val(0);
  $('#itemhPrice').val(0);
  $('#itemrPrice').val(0);
  $('#itemmPrice').val(0);
  $('#itemCat').val($("#itemCat option:first").val());
  $('#itemCat').change();
  $('#itemType').val($("#itemType option:first").val());
  $('#itemType').change();
  $('#itemStatus').val($("#itemStatus option:first").val());
  $('#itemStatus').change();
  $('#itemUnit').val($("#itemUnit option:first").val());
  $('#itemUnit').change();
  $('#itemSpc1').val($("#itemSpc1 option:first").val());
  $('#itemSpc1').change();
  $('#itemSpc2').val($("#itemSpc2 option:first").val());
  $('#itemSpc2').change();
  $('#itemSpc3').val($("#itemSpc3 option:first").val());
  $('#itemSpc3').change();
  $('#itemSpc4').val($("#itemSpc4 option:first").val());
  $('#itemSpc4').change();
  $('#itemSpc5').val($("#itemSpc5 option:first").val());
  $('#itemSpc5').change();

  clearAttache('fldFile');
  $('#itemModal').modal('show');
}

function saveItem() {
  var form = KTUtil.getById('itemForm');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var $fileField = $('#fldFile');
    var folder = $fileField.data('folder');
    var fileName = $('#' + $fileField.data('relname')).val();
    var ext = $('#' + $fileField.data('relext')).val();
    var vBase64 = $('#' + $fileField.data('relfld')).val();
    var nPos = vBase64.indexOf(";base64,/");
    var type = vBase64.substr(0, nPos).substr(5).replace("_", "/");
    PhUtility.doSave({
      'vOperation': "cpy-Warehouse-Material-Save",
      'nId': $('#itemId').val(),
      'vNum': $('#itemNum').val(),
      'vPart': $('#itemPartNum').val(),
      'vName': $('#itemName').val(),
      'vRem': $('#itemRem').val(),
      'nBox': $('#itemBox').val(),
      'nCost': $('#itemCost').val(),
      'nNPrice': $('#itemnPrice').val(),
      'nDPrice': $('#itemdPrice').val(),
      'nSPrice': $('#itemsPrice').val(),
      'nWPrice': $('#itemwPrice').val(),
      'nHPrice': $('#itemhPrice').val(),
      'nRPrice': $('#itemrPrice').val(),
      'nMPrice': $('#itemmPrice').val(),
      'nCat': $('#itemCat').val(),
      'nType': $('#itemType').val(),
      'nStatus': $('#itemStatus').val(),
      'nUnit': $('#itemUnit').val(),
      'nSpc1': $('#itemSpc1').val(),
      'nSpc2': $('#itemSpc2').val(),
      'nSpc3': $('#itemSpc3').val(),
      'nSpc4': $('#itemSpc4').val(),
      'nSpc5': $('#itemSpc5').val(),
      'vFile': vBase64,
      'vFileName': fileName,
      'vType': type,
      'vExt': ext,
      'vFolder': folder
    }, refreshALL);
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Material'), {"vOperation": "cpy-Warehouse-Material-Delete", "nId": data.Id}, refreshALL);
}

function refreshALL() {
  $("#itemForm").trigger("reset");
  $('#formulaModal').modal('hide');
  refreshList();
}

function cellFormulaClick(e, cell) {
  var data = cell.getData();
  $('#itemFId').val(data.Id);
  $('#itemDetail').val(data.Desc);
  $('#formulaModalLabel').html(data.Name);
  $('#formulaModal').modal('show');

  var aColumns = [];
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: '<i class="icon-md flaticon-delete"></i>',
    field: 'delrow',
    width: '35px',
    component: 'button',
    enabled: true,
    classes: 'btn-danger',
    format: '<i class="icon-md flaticon-delete"></i>',
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
    title: 'ItemFId',
    field: 'ItemFId',
    visible: false,
    component: 'input',
    enabled: true
  };
  aColumns[nIdx++] = {
    title: getLabel('Item'),
    field: 'ItemId',
    rfield: 'Item',
    width: '400px',
    component: 'input',
    enabled: true,
    autocomplete: true,
    defValue: 0,
    defLabel: '',
    ajax: true,
    ajaxType: 'POST',
    ajaxAsync: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxData: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      'vOperation': 'cpy-Warehouse-Material-ListAutocompleteProductItems',
      'term': ''
    },
    callback: {'event': 'change',
      'callback': onChangeItem
    }
  };
  aColumns[nIdx++] = {
    title: 'Unit',
    field: 'Unit',
    datatype: 'string',
    width: '150px',
    component: 'input',
    enabled: false,
    defValue: ' ',
    classes: 'text-center'
  };
  aColumns[nIdx++] = {
    title: 'Box',
    field: 'Box',
    datatype: 'decimal',
    width: '150px',
    component: 'input',
    enabled: false,
    required: true,
    defValue: 0,
    classes: 'text-center'
  };
  aColumns[nIdx++] = {
    title: 'QTY',
    field: 'Qnt',
    datatype: 'decimal',
    width: '150px',
    component: 'input',
    enabled: true,
    required: true,
    defValue: 0
  };
  phTable = new PhTable('phTable', aColumns, []);
  $('#formulaModal').modal('show');
  getFormulaItems();
}

function deleteRow() {
  phTable.deleteRow(parseInt($(this).data('row')));
}

function onChangeItem() {
  var nRow = $(this).data('row');
  var nId = phTable.getFieldValue(nRow, 'ItemId');
  if (nId !== '') {
    phTable.setFieldValue(nRow, 'Unit', '');
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Warehouse-Material-GetMaterial",
        "nItemId": nId
      },
      success: function (response) {
        try {
          if (response.Status) {
            phTable.setFieldValue(nRow, 'Unit', response.Data.UnitName);
            phTable.setFieldValue(nRow, 'Box', response.Data.Box);
          }
        } catch (ex) {
        }
      },
      error: function (response) {

      }
    });
  }

}

function getFormulaItems() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Warehouse-Material-FormulaList",
      "nFId": $('#itemFId').val()
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          $('#itemFor').val(res.FQnt);
          if (Array.isArray(res.Data)) {
            phTable.setData(res.Data);
          }
        }
      } catch (ex) {
      }
    },
    error: function (response) {
      try {
        var res = JSON.parse(response);
        swal.fire({
          text: res.Message,
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: getLabel('OK'),
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}

function saveFormula() {
  var nFId = parseInt($('#itemFId').val());
  if (nFId > 0) {
    var aRows = phTable.getData();
    PhUtility.doSave({
      "vOperation": "cpy-Warehouse-Material-FormulaSave",
      "nFId": nFId,
      "nFor": parseFloat($('#itemFor').val()),
      "vDesc": $('#itemDetail').val(),
      'aRows': aRows
    }, refreshALL, false);
  }
}

function formulaDelete(nId) {
  if (PhSettings.Treats.Del) {
    PhUtility.doDelete(getLabel('Item'), {"vOperation": "cpy-Warehouse-Material-FormulaDelete", "id": nId}, getFormulaItems, false);
  }
}
