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
    title: getLabel('Open.Balances') + ' ' + getLabel('Fund Collection'),
    field: "nOCrd",
    display: 'Open',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Open.Balances') + ' ' + getLabel('Fund Payment'),
    field: "nODeb",
    display: 'Open',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Total') + ' ' + getLabel('Fund Collection'),
    field: "nTCrd",
    display: 'Totals',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Total') + ' ' + getLabel('Fund Payment'),
    field: "nTDeb",
    display: 'Totals',
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Balance') + ' ' + getLabel('Fund Collection'),
    field: "nBCrd",
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Balance') + ' ' + getLabel('Fund Payment'),
    field: "nBDeb",
    width: "10%",
    headerSort: false,
    headerHozAlign: "center",
    hozAlign: "left"
  };
  aColumns[nIdx++] = {
    title: getLabel('Fund Box'),
    field: "vBoxName",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency'),
    display: 'Currency',
    field: "vCurnCode",
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
    display: 'Centers',
    field: "vCostName",
    headerSort: false,
    headerHozAlign: "center",
    formatter: "textarea"
  };
  //
  aDispCols.Open = {Title: getLabel('Open.Balances'), Status: 0};
  aDispCols.Totals = {Title: getLabel('Totals'), Status: 0};
  aDispCols.Currency = {Title: getLabel('Currency'), Status: 0};
  aDispCols.Centers = {Title: getLabel('Cost Center'), Status: 1};
  queryDrawOptions('#displayColumns', aDispCols, 'Disp');
}

function executeQuery() {
  var display = queryGetDisplay(aColumns, aDispCols, 'Disp');
  var aParams = {};
  aParams.vOperation = "cpy-Fund-Query-QryBoxBalances";
  aParams.Filters = {};
  aParams.Filters.BoxId = $("#BoxId").val();
  aParams.Filters.CurnId = $("#CurnId").val();
  aParams.Filters.AccName = $("#AccName").val();
  aParams.Filters.CostName = $("#CostName").val();
  aParams.Filters.Date = {'Value1': $("#FDate").val(), 'Value2': $("#TDate").val()};
  aParams.Filters.Rem = $("#Rem").val();
  aParams.Options = queryGetOptions(aOptions, 'Opt');
  aParams.Display = display.Display;
  table = ajaxQueryTabulatorAll(display.Columns, aParams);
}
