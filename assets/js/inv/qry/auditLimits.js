/* global KTAppSettings, PhTabulatorLocale, PhSettings, KTUtil, swal */

var table;
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
});

function executeQuery() {
  var aParams = {};
  var aColumns = [];
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
    title: getLabel('Limit'),
    field: "Limit",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "left"
  };

  aColumns[nIdx++] = {
    title: getLabel('Balance'),
    field: "Qnt",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "left"
  };

  aColumns[nIdx++] = {
    title: getLabel('OverLimit'),
    field: "OverLimit",
    width: "10%",
    headerHozAlign: "center",
    hozAlign: "left"
  };

  aParams.vOperation = "cpy-Warehouse-Query-QryAuditLimits";
  aParams.MstStore = $("#MstStore").val();
  aParams.ItemName = $("#ItemName").val();
  aParams.MstDate = $("#MstDate").val();
  aParams.ItemStatus = $("#ItemStatus").val();
  aParams.ItemUnit = $("#ItemUnit").val();
  aParams.ItemSpc1 = $("#ItemSpc1").val();
  aParams.ItemSpc2 = $("#ItemSpc2").val();
  aParams.ItemSpc3 = $("#ItemSpc3").val();
  aParams.SItemLoc1 = $("#SItemLoc1").val();
  aParams.SItemLoc2 = $("#SItemLoc2").val();
  aParams.SItemLoc3 = $("#SItemLoc3").val();
  aParams.optnLimit = $("#Limit").val();
  aParams.optnMode = $("#Mode").val();
  table = ajaxQueryTabulatorAll(aColumns, aParams);
}
