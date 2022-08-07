/* global PhSettings, PhUtility, swal, KTUtil */
var jResponse;
jQuery(document).ready(function () {

  $('#toggleEmptyRows').on('click', function () {
    toggleEmptyRows();
  });

  $('#dateDay').on('change', function () {
    refreshAppointments();
  });

  $('#lstClinic, #lstSpecial').on('change', function () {
    refreshAppointments();
  });

  refreshAppointments();

});

function toggleEmptyRows() {
  if ($('#toggleEmptyRows').is(':checked')) {
    $('.apps0').removeClass('d-none');
  } else {
    $('.apps0').addClass('d-none');
  }
}

function refreshAppointments() {
  var nIdx = 0;
  var statusMenu = [];
  var today = new Date();
  var vDate = $('#dateDay').val();
  var aDate = vDate.split('-');
  var dDate = new Date(aDate[2], aDate[1] - 1, aDate[0], 23, 59);
  if (dDate >= today) {
    PhSettings['appStatus'].forEach(function (element) {
      var oStatusColor = getColor(element.Color);
      var vStatusColor = oStatusColor.fgClass;
      statusMenu[nIdx] = {
        label: "<i class='" + element.Icon + " " + vStatusColor + "'></i> " + element.Name,
        action: function (e, cell) {
          var data = cell.getData();
          var cellValue = cell.getValue();
          var column = cell.getColumn();
          var fld = data[column.getField()];
          var nStatus = element.Id;
          $.ajax({
            type: 'POST',
            async: false,
            url: PhSettings.serviceURL,
            data: {
              "vCopy": PhSettings.copy,
              "vCDId": PhSettings.CDId,
              "vGUId": PhSettings.GUId,
              "vOperation": "cpy-Clinic-Appointment-ChangeStatus",
              "nId": fld.Id,
              "nStatus": nStatus
            },
            success: function (response) {
              try {
                var res = response;
                if (res.Status) {
                  cellValue.Status = element.Id;
                  cell.setValue(cellValue);
                } else {
                  swal.fire({
                    text: res.Message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn font-weight-bold btn-light-primary"
                  }).then(function () {
                    KTUtil.scrollTop();
                  });
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
                  confirmButtonText: "OK",
                  confirmButtonClass: "btn font-weight-bold btn-light-primary"
                }).then(function () {
                  KTUtil.scrollTop();
                });
              } catch (ex) {
              }
            }
          });
        }
      };
      nIdx++;
    });
  }
  nIdx = 0;
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Clinic-Appointment-ListDeskAppointments",
      "nClinic": $('#lstClinic').val(),
      "nSpecial": $('#lstSpecial').val(),
      "dDay": $('#dateDay').val()
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          jResponse = res;
          fillPhTable(res);
          $('.edit-app').off('dblclick').on('dblclick', function () {
            openEdit($(this));
          });
          $('.new-app').off('dblclick').on('dblclick', function () {
            openAdd($(this));
          });
          $('.app-status-change').off('click').on('click', function () {
            changeAppStatus($(this));
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "OK",
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
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
          confirmButtonText: "OK",
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });

}

function fillPhTable(res) {
  var vTable = '';
  var vTHeader = '';
  var vTBody = '';
  var vDoctor = '';
  var vApp = '';
  var aCols = [];
  vTHeader += '<tr>';
  vTHeader += '<th style="width: 5%;">Time</th>';
  for (var i = 0; i < res.Doctors.length; i++) {
    vDoctor = '';
    vDoctor += '<div class="card m-0 text-wrap" style="height: 100%; width: 100%; max-width: 220px;">';
    vDoctor += '  <div class="card-body p-2 text-success">';
    vDoctor += '    <span class="card-title m-0">' + res.Doctors[i].Name + '</span>';
    vDoctor += '  </div>';
    vDoctor += '  <div class="card-footer px-5 py-1 bg-light">' + res.Doctors[i].SpecialName + '</div>';
    vDoctor += '</div>';
    vTHeader += '<th class="p-1" style="width: 220px;">' + vDoctor + '</th>';
    aCols[i] = 1;
  }
  for (var i = 0; i < res.Data.length; i++) {
    var oTime = res.Data[i];
    vTBody += '<tr class="apps' + oTime.Count + '">';
    vTBody += '<td style="width: 5%;">' + oTime.Time + '</td>';
    for (var j = 0; j < res.Doctors.length; j++) {
      vApp = '';
      if (oTime.Apps.hasOwnProperty(res.Doctors[j].Id)) {
        var fld = oTime.Apps[res.Doctors[j].Id];
        var oAppType = getAppType(fld.Type);
        var oAppTypeTBGColor = getColor(oAppType.TitleBG);
        var oAppTypeTFGColor = getColor(oAppType.TitleFG);
        var oAppTypeNFGColor = getColor(oAppType.NameFG);
        var oAppStatus = getAppStatus(fld.Status);
        var oStatusColor = getColor(oAppStatus.Color);
        var vStatusColor = oStatusColor.fgClass;
        aCols[j] = fld.Rowspan;
        vApp += '<div class="card border-' + oStatusColor.Name.toLowerCase() + ' m-0 text-wrap" style="height: 100%; width: 220px; max-width: 220px;">';
        vApp += '  <div class="card-header p-3 ' + oAppTypeTBGColor.bgClass + ' ' + oAppTypeTFGColor.fgClass + '">' + oAppType.Name + '</div>';
        vApp += '  <div class="card-body p-2 m-0 ' + oAppTypeNFGColor.fgClass + '">';
        vApp += '    <div class="p-1" style="height: 5rem;"><h6 class="p-1">' + fld.Name + '</h6></div>';
        vApp += '    <div class="p-1 text-body" style="width: 100%;"><i class="icon-md far fa-file-alt"></i> ' + fld.PatientNum + '</div>';
        vApp += '    <div class="p-1 text-body" style="width: 100%;"><i class="icon-md fas fa-mobile-alt"></i> ' + fld.PatientMobile + '</div>';
        vApp += '    <div class="p-1 text-body" style="width: 100%;"><i class="icon fas fa-coins"></i> ' + fld.Amount + '</div>';
        vApp += '    <div class="p-1 text-muted" style="width: 100%;"><i class="icon fas fa-plus-square"></i> ' + fld.IUserName + ', ' + fld.IDate + '</div>';
        vApp += '    <div class="p-1 text-muted" style="width: 100%;"><i class="icon fas fa-pen-square"></i> ' + fld.UUserName + ', ' + fld.UDate + '</div>';
        vApp += '    <div class="p-1 text-body" style="width: 100%;">' + fld.Desc + '</div>';
        vApp += '  </div>';
        vApp += '  <div class="card-footer px-5 py-1 bg-light">';
        vApp += '    <div class="row">';
        vApp += '      <div class="col-10">';
        vApp += '        <i class="' + oAppStatus.Icon + ' ' + vStatusColor + '"></i> ' + oAppStatus.Name;
        vApp += '      </div>';
        vApp += '      <div class="col-2">';
        vApp += '        ' + getMenu(i, res.Doctors[j].Id);
        vApp += '      </div>';
        vApp += '    </div>';
        vApp += '  </div>';
        vApp += '</div>';
        var vRowpan = '';
        if (fld.Rowspan > 1) {
          vRowpan = ' rowspan="' + fld.Rowspan + '" ';
        }
        vTBody += '<td' + vRowpan + ' style="width: 220px; vertical-align: middle;" class="edit-app p-1" data-idx="' + i + '" data-did="' + res.Doctors[j].Id + '">' + vApp + '</td>';
      } else {
        if (aCols[j] <= 1) {
          vTBody += '<td class="new-app p-1" style="width: 220px;" data-idx=' + i + ' data-did="' + res.Doctors[j].Id + '"></td>';
        } else {
          aCols[j]--;
        }
      }
    }
    vTBody += '</tr>';
  }
  vTHeader += '</tr>';
  vTable = '<table class="table table-bordered">';
  vTable += '<thead>' + vTHeader + '</thead>';
  vTable += '</table>';
  $('#phTableHeader').html(vTable);
  vTable = '<table class="table table-bordered">';
  vTable += '<tbody>' + vTBody + '</tbody>';
  vTable += '</table>';
  $('#phTable').html(vTable);
}

function openEdit($app) {
  var nIdx = $app.data('idx');
  var nDId = $app.data('did');
  var oTime = jResponse.Data[nIdx];
  var oApp = jResponse.Data[nIdx].Apps[nDId];
  $("#ph_AddAppointment_form").trigger("reset");
  $('#appId').val(oApp.Id);
  $('#appClinic').val(oApp.ClinicId);
  $('#appDoctor').val(oApp.DoctorId);
  $('#appPatient').val(oApp.PatientId);
  $('#appSpecial').val(oApp.Special);
  $('#appType').val(oApp.Type);
  $('#appDate').val(oApp.Date);
  $('#appHour').val(oApp.Hour);
  $('#appMinute').val(oApp.Minute);
  $('#appMinutes').val(oApp.Minutes);
  $('#appAmount').val(oApp.Amount);
  $('#appDesc').val(oApp.Desc);
  $('#addAppointmentModalLabel').text('Edit Appointment');
  $('#addAppointmentModal').modal('show');
}

function openAdd($app) {
  var nIdx = $app.data('idx');
  var nDId = $app.data('did');
  var oTime = jResponse.Data[nIdx];
  var nClinic = $('#lstClinic').val();
  var oAppType = getAppType($('#appType').val());
  $("#ph_AddAppointment_form").trigger("reset");
  $('#appClinic').val(nClinic);
  $('#appId').val('0');
  $('#appDoctor').val(nDId);
  $('#appDate').val(oTime.Date);
  $('#appHour').val(oTime.Hour);
  $('#appMinute').val(oTime.Minute);
  $('#appMinutes').val(oAppType.Time);
  $('#addAppointmentModalLabel').text('Add Appointment');
  $('#addAppointmentModal').modal('show');

}

function getMenu(nIdx, nDId) {
  var vMenu = '';
  var today = new Date();
  var vDate = $('#dateDay').val();
  var aDate = vDate.split('-');
  var dDate = new Date(aDate[2], aDate[1] - 1, aDate[0], 23, 59);
  if (dDate >= today) {
    vMenu += '<div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">';
    vMenu += '  <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
    vMenu += '    <span class="btn btn-sm"><i class="icon-md text-dark-50 flaticon-more"></i></span>';
    vMenu += '  </a>';
    vMenu += '  <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-212px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">';
    vMenu += '    <!--begin::Naviigation-->';
    vMenu += '    <ul class="navi">';
    vMenu += '      <li class="navi-header font-weight-bold py-5">';
    vMenu += '        <span class="font-size-lg">Status</span>';
    vMenu += '      </li>';
    vMenu += '      <li class="navi-separator mb-3 opacity-70"></li>';
    PhSettings['appStatus'].forEach(function (element) {
      var oStatusColor = getColor(element.Color);
      var vStatusColor = oStatusColor.fgClass;
      vMenu += '      <li class="navi-item">';
      vMenu += '        <a class="navi-link app-status-change" data-idx="' + nIdx + '" data-did="' + nDId + '" data-sid="' + element.Id + '">';
      vMenu += '          <span class="navi-icon">';
      vMenu += '            <i class="' + element.Icon + ' ' + vStatusColor + '"></i>';
      vMenu += '          </span>';
      vMenu += '          <span class="navi-text">' + element.Name + '</span>';
      vMenu += '        </a>';
      vMenu += '      </li>';
    });
    vMenu += '    </ul>';
    vMenu += '    <!--end::Naviigation-->';
    vMenu += '  </div>';
    vMenu += '</div>';
  }
  return vMenu;
}

function changeAppStatus($status) {
  var nIdx = $status.data('idx');
  var nDId = $status.data('did');
  var nSId = $status.data('sid');
  var oApp = jResponse.Data[nIdx].Apps[nDId];
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Clinic-Appointment-ChangeStatus",
      "nId": oApp.Id,
      "nStatus": nSId
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          jResponse.Data[nIdx].Apps[nDId].Status = nSId;
          fillPhTable(jResponse);
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "OK",
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
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
          confirmButtonText: "OK",
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}