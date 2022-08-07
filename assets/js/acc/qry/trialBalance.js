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
    title: getLabel('Open Debit'),
    field: "nODeb",
    display: 'Open',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Open Credit'),
    field: "nOCrd",
    display: 'Open',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Total Debit'),
    field: "nTDeb",
    display: 'Totals',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Total Credit'),
    field: "nTCrd",
    display: 'Totals',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Debit Balance'),
    field: "nBDeb",
    display: 'Balances',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Credit Balance'),
    field: "nBCrd",
    display: 'Balances',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Acc.Num'),
    field: "vAccNum",
    width: "5%",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Acc.Name'),
    field: "vAccName",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Cost.Num'),
    field: "vCostNum",
    display: 'Centers',
    width: "5%",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Cost.Name'),
    field: "vCostName",
    display: 'Centers',
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  //
  aOptions.HAccs = {Title: getLabel('Head Accounts'), Status: 1};
  aOptions.AAccs = {Title: getLabel('Active Accounts'), Status: 1};
  queryDrawOptions('#queryOptions', aOptions, 'Opt');
  //
  aDispCols.Open = {Title: getLabel('Open.Balances'), Status: 0};
  aDispCols.Totals = {Title: getLabel('Totals'), Status: 0};
  aDispCols.Balances = {Title: getLabel('Balances'), Status: 1};
  aDispCols.Centers = {Title: getLabel('Cost Center'), Status: 1};
  queryDrawOptions('#displayColumns', aDispCols, 'Disp');
}

function executeQuery() {
  var display = queryGetDisplay(aColumns, aDispCols, 'Disp');
  var aParams = {};
  aParams.vOperation = "cpy-Account-Query-QryTrialBalance";
  aParams.Filters = {};
  aParams.Filters.AccName = $("#AccName").val();
  aParams.Filters.CostName = $("#CostName").val();
  aParams.Filters.MstDate = {'Value1': $("#MstFDate").val(), 'Value2': $("#MstTDate").val()};
  aParams.Filters.MstNum = {'Value1': $("#MstFNum").val(), 'Value2': $("#MstTNum").val()};
  aParams.Filters.MstDocD = {'Value1': $("#MstFDocD").val(), 'Value2': $("#MstTDocD").val()};
  aParams.Filters.MstDocN = {'Value1': $("#MstFDocN").val(), 'Value2': $("#MstTDocN").val()};
  aParams.Filters.MstDoc = $("#MstDoc").val();
  aParams.Filters.MstRem = $("#MstRem").val();
  aParams.Filters.TrnRem = $("#TrnRem").val();
  aParams.Options = queryGetOptions(aOptions, 'Opt');
  aParams.Display = display.Display;
  table = ajaxQueryTabulatorAll(display.Columns, aParams);
}
