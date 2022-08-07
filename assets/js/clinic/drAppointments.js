/* global PhSettings, PhUtility, getNear15Minute, KTUtil, swal */
var appData;
jQuery(document).ready(function () {

  $('#dateDay, #lstClinic').on('change', function () {
    refreshList();
  });
  $('#ph_addRems').on('click', function () {
    remSave();
  });

  refreshList();

});

function refreshList() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Clinic-Appointment-DoctorAppointments",
      "nClinic": $('#lstClinic').val(),
      "dDay": $('#dateDay').val()
    },
    success: function (response) {
      try {
        var dDate = new Date();
        var firstAppTime = dDate.getHours().toString().padStart(2, '0') + getNear15Minute().toString().padStart(2, '0');
        var res = response;
        if (res.Status) {
          appData = res.Data;
          if (Array.isArray(appData)) {
            var vTime = '';
            var vTimeId = '';
            var typeBGColor;
            var typeFGColor;
            var nameFGColor;
            var statusColor;
            var element = '';
            var vHtml = '';
            for (var i = 0; i < appData.length; i++) {
              element = appData[i];
              vTimeId = element.Hour.padStart(2, "0") + element.Minute.padStart(2, "0");
              vTime = element.Hour.padStart(2, "0") + ':' + element.Minute.padStart(2, "0");
              typeBGColor = getColor(element.TypeTitleBG);
              typeFGColor = getColor(element.TypeTitleFG);
              nameFGColor = getColor(element.TypeNameFG);
              statusColor = getColor(element.StatusColor);
              vHtml += '<div class="row p-3">';
              vHtml += '  <div id="' + vTimeId + '" class="col-12 p-2 bg-secondary">';
              vHtml += '    <div class="card p-2">';
              vHtml += '      <div class="row py-2">';
              vHtml += '        <div class="col-sm-10">';
              vHtml += '          <h1 class="' + nameFGColor.fgClass + '">';
              vHtml += '            ' + element.PatientName;
              vHtml += '          </h1>';
              vHtml += '        </div>';
              vHtml += '        <div class="col-sm-2 text-center px-5">';
              vHtml += '          <h1 class="rounded border border-1 bg-light">' + vTime + '</h1>';
              vHtml += '        </div>';
              vHtml += '      </div>';
              vHtml += '      <div class="row">';
              vHtml += '        <div class="col-12 col-sm-10">';
              vHtml += '          <div class="row">';
              vHtml += '            <div class="col-12 col-sm-3">';
              vHtml += '              <h2><i class="icon-md far fa-file-alt"></i> ' + element.PatientNum + '</h2>';
              vHtml += '            </div>';
              vHtml += '            <div class="col-12 col-sm-3">';
              vHtml += '              <h2><i class="icon-md fas fa-mobile-alt"></i> ' + element.PatientMobile + '</h2>';
              vHtml += '            </div>';
              vHtml += '            <div class="col-sm-4 text-center">';
              vHtml += '              <h2 class="' + typeBGColor.bgClass + ' ' + typeBGColor.Text + ' py-3 rounded">';
              vHtml += '                ' + element.Type;
              vHtml += '              </h2>';
              vHtml += '            </div>';
              vHtml += '            <div class="col-sm-2 text-center">';
              vHtml += '              <h2 class="' + statusColor.bgClass + ' ' + statusColor.Text + ' py-3 rounded">';
              vHtml += '                ' + element.Status;
              vHtml += '              </h2>';
              vHtml += '            </div>';
              vHtml += '          </div>';
              vHtml += '        </div>';
              vHtml += '        <div class="col-12 col-sm-2">';
              vHtml += '          <div class="d-flex align-items-center flex-wrap justify-content-between mt-5 mt-sm-0">';
              vHtml += '            <span class="btn btn-lg btn-success font-weight-bolder text-uppercase mt-2 pl-8 add-remarks" title="Add Remarks" data-id="' + i + '">';
              vHtml += '              <i class="icon-lg text-light flaticon2-tag"></i>';
              vHtml += '             </span>';
              vHtml += '            <span class="btn btn-lg btn-info font-weight-bolder text-uppercase mt-2 pl-8 add-update-treatment" title="Add/Update Treatment" data-id="' + i + '">';
              vHtml += '              <i class="icon-lg text-light flaticon2-help"></i>';
              vHtml += '             </span>';
              vHtml += '          </div>';
              vHtml += '        </div>';
              vHtml += '      </div>';
              vHtml += '    </div>';
              vHtml += '  </div>';
              vHtml += '</div>';
            }
            $('#appContainer').html(vHtml);
            $('.add-remarks').unbind('click').on('click', function () {
              $('#appIdx').val($(this).data('id'));
              getRemarks();
            });
            $('.add-update-treatment').unbind('click').on('click', function () {
              var app = appData[parseInt($(this).data('id'))];
              $('#treatPatient').val(app.PatientId);
              $('#treatPatient').change();
              getTreatment();
            });
            $('html, body').animate({
              scrollTop: $('#' + firstAppTime).offset().top
            }, 500);
          }
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

function remSave() {
  var app = appData[$('#appIdx').val()];
  if ($('#remNote').val() !== '') {
    PhUtility.doSave({
      "vOperation": "cpy-Clinic-Patient-Note-Save",
      "nId": $('#remId').val(),
      "nPId": app.PatientId,
      "nDId": app.DoctorId,
      "vNote": $('#remNote').val()
    }, getRemarks, false);
  }
}

function deleteRemark(nId) {
  PhUtility.doDelete('Remark', {"vOperation": "cpy-Clinic-Patient-Note-Delete", "nId": nId}, getRemarks, false);
}

function getRemarks() {
  var app = appData[$('#appIdx').val()];
  $('#remId').val(0);
  $('#remPId').val(app.PatientId);
  $('#remDId').val(app.DoctorId);
  $('#remNote').val('');
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Clinic-Patient-Note-ListPatientNotes",
      "nPatientId": app.PatientId
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          if (Array.isArray(res.Data)) {
            var vRemsHtml = '';
            var note;
            vRemsHtml += '<table class="table table-striped table-bordered mt-0 w-100">';
            vRemsHtml += '<tbody>';
            for (var i = 0; i < res.Data.length; i++) {
              note = res.Data[i];
              vRemsHtml += '<tr>';
              vRemsHtml += '<td style="width: 5%; padding-left: 1px; padding-right: 1px;">' + (parseInt(PhSettings['utype']) <= 0 || note.DoctorId === parseInt(PhSettings['uid']) ? PhUtility.deleteIdButton(note.Id, 'delete-remark') : '') + '</td>';
              vRemsHtml += '<td style="width: 20%;">' + note.Datetime + '</td>';
              vRemsHtml += '<td style="width: 25%;">' + note.DoctorName + '</td>';
              vRemsHtml += '<td style="width: 50%;">' + note.Note + '</td>';
              vRemsHtml += '</tr>';
            }
            vRemsHtml += '</tbody>';
            vRemsHtml += '</table>';
            $('#remRems').html(vRemsHtml);
            $('.delete-remark').unbind('click').on('click', function () {
              deleteRemark($(this).data('id'));
            });
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
          confirmButtonText: "OK",
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
  $('#remsFormModal').modal('show');
}

