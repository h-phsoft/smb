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
  var nPId = $('#qryPatient').val();
  if (nPId > 0) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vOperation": "cpy-Clinic-Patient-getPatient",
        "nPId": nPId,
        "SDate": $('#qrySDate').val(),
        "EDate": $('#qryEDate').val()
      },
      success: function (response) {
        console.log(response);
        try {
          var res = response;
          if (res.Status) {
            var nTotal = 0;
            var vHtml = '';
            $('#qryPatientName').html(res.Patient.Name);
            $('#qryPatientNum').html('<i class="icon-md far fa-file-alt"></i> ' + res.Patient.Num);
            if (res.Patient.NatName !== null) {
              $('#qryPatientNationality').html('<i class="icon-md fas fa-id-badge"></i> ' + res.Patient.NatName);
            }
            if (res.Patient.NatNum !== null) {
              $('#qryPatientNatNum').html('<i class="icon-md far fa-id-badge"></i> ' + res.Patient.NatNum);
            }
            if (res.Patient.Mobile !== null) {
              $('#qryPatientMobile').html('<i class="icon-md fas fa-mobile-alt"></i> ' + res.Patient.Mobile);
            }
            $('#qryTotalOpen').text(res.Open);
            $('#qryTotalInvoices').text(res.Invoices);
            $('#qryTotalPayments').text(res.Payments);
            $('#qryTotalDiscounts').text(res.Discounts);
            $('#qryTotalRefunds').text(res.Refunds);
            $('#qryTotalNets').text(res.Net);

            $('#finOpen').text(res.Open);
            nTotal = res.Open;
            vHtml = '';
            var trtName = '';
            res.aCard.forEach(function (element) {
              trtName = element.TrtName;
              if (element.TrtId === 1) {
                trtName = trtName + ' - ' + element.Num;
              }
              vHtml += '<div class="row">';
              vHtml += '  <div class="col-4 text-left"><span class="font-weight-bolder font-size-md">' + trtName + '</span></div>';
              vHtml += '  <div class="col-4 text-left"><span class="font-weight-bolder font-size-md">' + element.Date + '</span></div>';
              vHtml += '  <div class="col-1 text-right"><span class="font-weight-bolder font-size-md">' + Math.round(element.Amount, 0) + '</span></div>';
              vHtml += '  <div class="col-1 text-right"><span class="font-weight-bolder font-size-md">' + Math.round(element.Vat, 0) + '</span></div>';
              vHtml += '  <div class="col-1 text-right"><span class="font-weight-bolder font-size-md">' + Math.round(element.Discount, 0) + '</span></div>';
              vHtml += '  <div class="col-1 text-right"><span class="font-weight-bolder font-size-md">' + Math.round(element.Net, 0) + '</span></div>';
              vHtml += '</div>';
              nTotal += parseFloat(element.Net);
            });
            $('#qryPatientCard').html(vHtml);
            $('#qryPatientCardTotal').text(nTotal);

            vHtml = '';
            res.aTreats.forEach(function (element) {
              vHtml += '<div class="row">';
              vHtml += '  <div class="col-2"><span class="font-weight-bolder font-size-md">' + element.DoctorName + '</span></div>';
              vHtml += '  <div class="col-2"><span class="font-weight-bolder font-size-md">' + element.Date + '</span></div>';
              vHtml += '  <div class="col-3"><span class="font-weight-bolder font-size-md text-wrap">' + element.CatName + '</span></div>';
              vHtml += '  <div class="col-3"><span class="font-weight-bolder font-size-md text-wrap">' + element.ProcedureName + '</span></div>';
              vHtml += '  <div class="col-1"><span class="font-weight-bolder font-size-md text-right">' + element.Amount + '</span></div>';
              vHtml += '  <div class="col-1"><span class="font-weight-bolder font-size-md text-right">' + element.VatAmount + '</span></div>';
              vHtml += '</div>';
            });
            $('#qryPatientTrats').html(vHtml);

            vHtml = '';
            res.aNotes.forEach(function (element) {
              vHtml += '<div class="row py-2">';
              vHtml += '  <div class="col-3 col-sm-3"><span class="font-weight-bolder font-size-md">' + element.DoctorName + '</span></div>';
              vHtml += '  <div class="col-3 col-sm-2"><span class="font-weight-bolder font-size-md">' + element.Date + '</span></div>';
              vHtml += '  <div class="col-6 col-sm-7"><span class="font-weight-bolder font-size-md text-wrap">' + element.Note + '</span></div>';
              vHtml += '</div>';
            });
            $('#qryPatientRems').html(vHtml);

            vHtml = '';
            res.aApps.forEach(function (element) {
              vHtml += '<div class="row py-2">';
              vHtml += '  <div class="col-3 col-sm-3"><span class="font-weight-bolder font-size-md">' + element.DoctorName + '</span></div>';
              vHtml += '  <div class="col-3 col-sm-3"><span class="font-weight-bolder font-size-md">' + element.Date + ' ' + element.Hour + ':' + element.Minute + '</span></div>';
              vHtml += '  <div class="col-3 col-sm-3"><span class="font-weight-bolder font-size-md">' + element.TypeName + '</span></div>';
              vHtml += '  <div class="col-3 col-sm-3"><span class="font-weight-bolder font-size-md text-wrap">' + element.StatusName + '</span></div>';
              vHtml += '</div>';
            });
            $('#qryPatientApps').html(vHtml);
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
}
