var table;
var aDispCols = {};
var aOptions = {};
var aColumns = [];
var toggleCriteria = true;
var oColors = {'Collect': '#c1cbff', 'Payment': '#ffc1c1'};
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
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Credit'),
    field: "nCrd",
    width: "8%",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Balance'),
    field: "nBlnc",
    display: 'Balance',
    width: "8%",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: "Date",
    width: "8%",
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency'),
    field: "CurnCode",
    display: 'Currency',
    width: "5%",
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Fund Box'),
    field: "BoxName",
    display: 'Box',
    headerSort: false,
    hozAlign: "center",
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
    field: "Rem",
    display: 'Rem',
    headerSort: false,
    hozAlign: "center",
    headerHozAlign: "center",
    formatter: "textarea"
  };
  //
  aOptions.Open = {Title: getLabel('Open.Balances'), Status: 1};
  queryDrawOptions('#queryOptions', aOptions, 'Opt');
  //
  aDispCols.Balance = {Title: getLabel('Balance'), Status: 1};
  aDispCols.Box = {Title: getLabel('Fund Box'), Status: 1};
  aDispCols.Currency = {Title: getLabel('Currency'), Status: 0};
  aDispCols.Centers = {Title: getLabel('Cost Center'), Status: 1};
  aDispCols.Rem = {Title: getLabel('Remarks'), Status: 1};
  queryDrawOptions('#displayColumns', aDispCols, 'Disp');
}

function executeQuery() {
  if ($("#AccId").val() !== "") {
    var display = queryGetDisplay(aColumns, aDispCols, 'Disp');
    var aParams = {};
    aParams.vOperation = "cpy-Fund-Query-QryAccountCard";
    aParams.Filters = {};
    aParams.Filters.AccId = $("#AccId").val();
    aParams.Filters.CostName = $("#CostName").val();
    aParams.Filters.CurnId = $("#CurnId").val();
    aParams.Filters.Rem = $("#Rem").val();
    aParams.Filters.Date = {'Value1': $("#FDate").val(), 'Value2': $("#TDate").val()};
    aParams.Options = queryGetOptions(aOptions, 'Opt');
    aParams.Display = display.Display;
    table = ajaxQueryTabulatorAll(display.Columns, aParams);
  }
}