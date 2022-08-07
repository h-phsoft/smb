/* global KTAppSettings, PhUtility, getNear15Minute, KTUtil, swal, PhSettings */
var table;
jQuery(document).ready(function () {

//  $('#qryExeute').on('click', function () {
//    refreshList();
//  });
//
//  $('#qryPrint').on('click', function () {
//    window.print();
//  });
  refreshList();

});

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  aColumns[nIdx++] = {
    title: "Doctor",
    field: "DoctorName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "MrNo",
    field: "PatientNum",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Patient",
    field: "PatientName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Nat.Id",
    field: "PatientNatNum",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Mobile",
    field: "PatientMobile",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Speciality",
    field: "SpecialName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Type",
    field: "TypeName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: function (cell, formatterParams) {
      var id = cell.getData().TypeId;
      var name = cell.getData().TypeName;
      var oAppType = getAppType(id);
      var oAppTypeTBGColor = getColor(oAppType.TitleBG);
      var oAppTypeTFGColor = getColor(oAppType.TitleFG);
      return '<span class="label label-lg font-weight-bold font-size-h5 label-inline ' + oAppTypeTBGColor.bgClass + ' ' + oAppTypeTFGColor.fgClass + '">' + name + '</span>';
    }
  };
  aColumns[nIdx++] = {
    title: "Status",
    field: "StatusName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: function (cell, formatterParams) {
      var id = cell.getData().StatusId;
      var name = cell.getData().StatusName;
      var oAppStatus = getAppStatus(id);
      var oStatusColor = getColor(oAppStatus.Color);
      var vStatusColor = oStatusColor.fgClass;
      return '<span class="label label-lg font-weight-bold label-inline ' + oAppStatus.Icon + ' ' + vStatusColor + '">&nbsp;' + name + '</span>';
    }
  };
  aColumns[nIdx++] = {
    title: "Date",
    field: "Date",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Time",
    field: "Time",
    width: "5%",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Description",
    field: "Description",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Added",
    field: "IName",
    width: "8%",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Modified",
    field: "UName",
    width: "8%",
    headerSort: false,
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  table = getAjaxTabulator("cpy-Clinic-Appointment-ListAppointmentAll", aColumns);
}
