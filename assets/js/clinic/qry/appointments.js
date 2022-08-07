/* global KTAppSettings, PhUtility, getNear15Minute, KTUtil, swal, PhSettings */
var appData;
var catProcs;
jQuery(document).ready(function () {

  $('#qryExeute').on('click', function () {
    refreshList();
  });

  $('#qryPrint').on('click', function () {
    window.print();
  });

});

function refreshList() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vOperation": "cpy-Clinic-Appointment-ListAppointments",
      "nGrp1": $('#qryGrp1').val(),
      "nGrp2": $('#qryGrp2').val(),
      "nGrp3": $('#qryGrp3').val(),
      "nGrp4": $('#qryGrp4').val(),
      "SDate": $('#qrySDate').val(),
      "EDate": $('#qryEDate').val()
    },
    success: function (response) {
      console.log(response);
      try {
        var res = response;
        if (res.Status) {
          $('#queryHeader').html(res.Title);
          if (res.Data.length > 100) {
            var table = new Tabulator("#tabulatorTable", {
              layout: "fitColumns",
              height: "100%",
              cellVertAlign: "middle",
              variableHeight: true,
              pagination: "local",
              paginationSize: 10,
              paginationSizeSelector: [10, 25, 50, 75, 100],
              data: res.Data,
              columns: res.Columns
            });
          } else {
            var table = new Tabulator("#tabulatorTable", {
              layout: "fitColumns",
              height: "100%",
              cellVertAlign: "middle",
              variableHeight: true,
              data: res.Data,
              columns: res.Columns
            });
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
