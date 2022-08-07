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
  executeQuery();

});

function initQuery() {
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: getLabel('Debit'),
    field: "nDeb",
    width: "8%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Credit'),
    field: "nCrd",
    width: "8%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Balance'),
    field: "nBlnc",
    width: "8%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: "MstDate",
    width: "8%",
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Number'),
    field: "MstNum",
    width: "5%",
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency'),
    field: "vCurnCode",
    display: 'Currency',
    width: "5%",
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Rate'),
    field: "nCurnRate",
    display: 'Currency',
    width: "5%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency.Debit'),
    field: "nDebC",
    display: 'Currency',
    width: "8%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency.Credit'),
    field: "nCrdC",
    display: 'Currency',
    width: "8%",
    headerSort: false,
    hozAlign: "right",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Cost Center'),
    field: "CostName",
    display: 'Centers',
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: "MstRem",
    display: 'Rem',
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Descrption'),
    field: "TrnRem",
    display: 'Desc',
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  //
  aOptions.Open = {Title: getLabel('Open.Balances'), Status: 1};
  queryDrawOptions('#queryOptions', aOptions, 'Opt');
  //
  aDispCols.Currency = {Title: getLabel('Currency'), Status: 0};
  aDispCols.Centers = {Title: getLabel('Cost Center'), Status: 1};
  aDispCols.Rem = {Title: getLabel('Remarks'), Status: 1};
  aDispCols.Desc = {Title: getLabel('Description'), Status: 1};
  queryDrawOptions('#displayColumns', aDispCols, 'Disp');
}

function executeQuery() {
  if ($("#AccId").val() !== "") {
    var display = queryGetDisplay(aColumns, aDispCols, 'Disp');
    var aParams = {};
    aParams.vOperation = "cpy-Account-Query-QryAccountCard";
    aParams.Filters = {};
    aParams.Filters.AccId = $("#AccId").val();
    aParams.Filters.CostName = $("#CostName").val();
    aParams.Filters.MstDoc = $("#MstDoc").val();
    aParams.Filters.CurnId = $("#CurnId").val();
    aParams.Filters.MstRem = $("#MstRem").val();
    aParams.Filters.TrnRem = $("#TrnRem").val();
    aParams.Filters.MstDate = {'Value1': $("#MstFDate").val(), 'Value2': $("#MstTDate").val()};
    aParams.Filters.MstNum = {'Value1': $("#MstFNum").val(), 'Value2': $("#MstTNum").val()};
    aParams.Filters.MstDocD = {'Value1': $("#MstFDocD").val(), 'Value2': $("#MstTDocD").val()};
    aParams.Filters.MstDocN = {'Value1': $("#MstFDocN").val(), 'Value2': $("#MstTDocN").val()};
    aParams.Options = queryGetOptions(aOptions, 'Opt');
    aParams.Display = display.Display;
    table = ajaxQueryTabulatorAll(display.Columns, aParams);
  }
}