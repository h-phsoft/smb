/* global PhSettings, PhUtility, swal, KTUtil */
jQuery(document).ready(function () {

  $('.customize-save').on('click', function () {
    alert($(this).data('rid'));
    //save($(this).data('rid'));
  });

});

function save(nRId) {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-PGrp-Save",
      "nId": $('#editId').val(),
      "vName": $('#editName').val()
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          swal.fire({
            text: getLabel('Updated succsessfully'),
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            location.reload();
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
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
          confirmButtonText: getLabel('OK'),
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}
