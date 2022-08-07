/* global PhSettings, KTUtil, swal, FormValidation */

"use strict";

jQuery(document).ready(function () {
  var bStatus = true;
  $('#kt_login_signin_submit').on('click', function (e) {
    e.preventDefault();
    doSignIn();
  });
  $('#username, #password').on('keyup', function (e) {
    e.preventDefault();
    if (e.which === 13) {
      doSignIn();
    }
  });

  $('#loginStatus').html('');
  if (PhSettings.ds > 0 || PhSettings.rs > 0) {
    PhSettings.CDId = JSON.parse(localStorage.getItem(PhSettings.copy));
    if (typeof PhSettings.CDId === 'undefined' || PhSettings.CDId === null || PhSettings.CDId === 'null' || PhSettings.CDId === '') {
      bStatus = false;
      $('#loginStatus').html('<h1 class="text-danger">' + getLabel('Unregistered Copy') + '</h1>');
    }
  }
  if (bStatus) {
    var oGUId = JSON.parse(localStorage.getItem(PhSettings.copy + '_GUID'));
    if (!(typeof oGUId === 'undefined' || oGUId === null || oGUId === 'null' || oGUId === '')) {
      if (oGUId.Status) {
        $.ajax({
          type: 'POST',
          async: false,
          url: PhSettings.serviceURL,
          data: {
            "vCopy": PhSettings.copy,
            "vCDId": PhSettings.CDId,
            "vGUId": oGUId,
            "vOperation": "cpy-Copy-User-ALogin"
          },
          success: function (response) {
            try {
              var res = response;
              if (res.Status) {
                $.redirect(PhSettings.copyRootPath, {}, 'POST');
              }
            } catch (ex) {
            }
          }
        });
      }
    }
  }
});
function doSignIn() {
  var bStatus = true;
  var vUsername = $('#username').val();
  var vPassword = $('#password').val();
  if (vUsername === '') {
    bStatus = false;
    $('#username').addClass('invalid');
  }
  if (vPassword === '') {
    bStatus = false;
    $('#password').addClass('invalid');
  }
  if (bStatus) {
    if (!(typeof PhSettings.CDId === 'undefined' || PhSettings.CDId === null || PhSettings.CDId === 'null' || PhSettings.CDId === '')) {
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Copy-User-Login",
          "vUsername": vUsername,
          "vPassword": vPassword
        },
        success: function (response) {
          try {
            var res = response;
            if (res.Status) {
              localStorage.setItem(PhSettings.copy + '_GUID', JSON.stringify(res.GUId));
              $.redirect(PhSettings.copyRootPath, {'UName': res.Data.UName}, 'POST');
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
        }
      });
    }
  }
}
