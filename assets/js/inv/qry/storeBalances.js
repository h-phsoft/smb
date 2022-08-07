var table;
var aDispCols = {};
var aOptions = {};
var aColumns = [];
var toggleCriteria = true;
jQuery(document).ready(function () {

  $('#ph_toggleCriteria').on('click', function () {
    $('#ph_toggleCriteria').removeClass('btn-light-success');
    $('#ph_toggleCriteria').removeClass('btn-light-danger');
    $('#qryCriteria').removeClass('d-block');
    $('#qryCriteria').removeClass('d-none');
    toggleCriteria = !toggleCriteria;
    if (toggleCriteria) {
      $('#ph_toggleCriteria').html('<i class="icon-2x la la-toggle-on"></i>');
      $('#ph_toggleCriteria').addClass('btn-light-success');
      $('#qryCriteria').addClass('d-block');
    } else {
      $('#ph_toggleCriteria').html('<i class="icon-2x la la-toggle-off"></i>');
      $('#ph_toggleCriteria').addClass('btn-light-danger');
      $('#qryCriteria').addClass('d-none');
    }
  });
  $('#ph_execute').on('click', function () {
    executeQuery();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  initQuery();
});

function initQuery() {
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: getLabel('Warehouse'),
    field: "Warehouse",
    headerHozAlign: "center",
    hozAlign: "left",
    formatter: "textarea"
  };

  aColumns[nIdx++] = {
    title: getLabel('Material'),
    field: "Item",
    headerHozAlign: "center",
    formatter: "textarea"
  };

  aColumns[nIdx++] = {
    title: getLabel('Unit'),
    field: "UnitName",
    width: "5%",
    headerHozAlign: "center",
    formatter: "textarea"
  };

  aColumns[nIdx++] = {
    title: getLabel('Qnt'),
    field: "Qnt1",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "left"
  };

  aColumns[nIdx++] = {
    title: getLabel('Amount'),
    field: "Amt3",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "left"
  };
  //
  aOptions.ZeroBlnc = {Title: getLabel('ZeroBlnc'), Status: 1};
  queryDrawOptions('#queryOptions', aOptions, 'Opt');
}

function executeQuery() {
  var display = queryGetDisplay(aColumns, aDispCols, 'Disp');
  var aParams = {};
  aParams.vOperation = "cpy-Warehouse-Query-QryMaterials";
  aParams.Filters = {};
  aParams.Filters.MstStore = $("#MstStore").val();
  aParams.Filters.ItemName = $("#ItemName").val();
  aParams.Filters.MstDate = $("#MstDate").val();
  aParams.Filters.ItemStatus = $("#ItemStatus").val();
  aParams.Filters.ItemUnit = $("#ItemUnit").val();
  aParams.Filters.ItemSpc1 = $("#ItemSpc1").val();
  aParams.Filters.ItemSpc2 = $("#ItemSpc2").val();
  aParams.Filters.ItemSpc3 = $("#ItemSpc3").val();
  aParams.Filters.SItemLoc1 = $("#SItemLoc1").val();
  aParams.Filters.SItemLoc2 = $("#SItemLoc2").val();
  aParams.Filters.SItemLoc3 = $("#SItemLoc3").val();
  aParams.Options = queryGetOptions(aOptions, 'Opt');
  aParams.Display = display.Display;
  table = ajaxQueryTabulatorAll(display.Columns, aParams);
}
