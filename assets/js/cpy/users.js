/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNewUser();
  });
  $('#ph_resetPassword_submit').on('click', function () {
    resetPassword();
  });
  $('#ph_AddUser_submit').on('click', function () {
    addUser();
  });
  $('#ph_editUser_submit').on('click', function () {
    updateUser();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  refreshList();
});
function openNewUser() {
  $("#ph_add_form").trigger("reset");
  $('#addUserModal').modal('show');
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#editUserId').val(data.nId);
  $('#editUserName').val(data.vName);
  $('#editUserLogon').val(data.vLogon);
  $('#editUserType').val(data.nType);
  $('#editUserType').change();
  $('#editUserGender').val(data.nGender);
  $('#editUserGender').change();
  $('#editUserStatus').val(data.nStatus);
  $("#editUserStatus").change();
  $('#editUserModal').modal('show');
}

function cellResetClick(e, cell) {
  var data = cell.getData();
  $('#resetUserId').val(data.nId);
  $('#resetPasswordModal').modal('show');
}

function resetPassword() {
  var nUserId = parseInt($('#resetUserId').val());
  var vNPassword = $('#resetNPassword').val();
  var vVPassword = $('#resetVPassword').val();
  if (nUserId !== '' && nUserId > 0 && vNPassword === vVPassword) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Copy-User-ResetPassword",
        "nUserId": nUserId,
        "vNPassword": vNPassword,
        "vVPassword": vVPassword
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            swal.fire({
              text: getLabel("Password changed succsessfully"),
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: getLabel('OK'),
              confirmButtonClass: "btn font-weight-bold btn-light-primary"
            }).then(function () {
              $('#resetUserId').val(0);
              $('#resetNPassword').val('');
              $('#resetVPassword').val('');
              $('#resetPasswordModal').modal('hide');
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
}

function addUser() {
  var vNPassword = $('#addnPassword').val();
  var vVPassword = $('#addvPassword').val();
  if (vNPassword === vVPassword) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Copy-User-Save",
        "id": 0,
        "nGrp": $('#addUserType').val(),
        "nStatus": $('#addUserStatus').val(),
        "nGender": $('#addUserGender').val(),
        "vLogon": $('#addUserLogon').val(),
        "vNPassword": $('#addnPassword').val(),
        "vVPassword": $('#addvPassword').val(),
        "vName": $('#addUserName').val()
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            swal.fire({
              text: getLabel("Inserted succsessfully"),
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
}

function updateUser() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-User-Save",
      "nId": $('#editUserId').val(),
      "nGrp": $('#editUserType').val(),
      "nStatus": $('#editUserStatus').val(),
      "nGender": $('#editUserGender').val(),
      "vLogon": $('#editUserLogon').val(),
      "vName": $('#editUserName').val()
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          swal.fire({
            text: getLabel("Updated succsessfully"),
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
function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Copy-User-Delete',
    'nId': data.nId
  }, refreshList);
}

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (PhSettings.current.update) {
    aColumns[nIdx++] = {
      title: '',
      width: "5%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    };
    aColumns[nIdx++] = {
      title: "",
      width: "5%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.resetButton();
      },
      cellClick: cellResetClick
    };
  }
  aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: "vName",
    width: "45%",
    hozAlign: "left",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Logon'),
    field: "vLogon",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Group'),
    field: "vTypeName",
    width: "10%",
    hozAlign: "center",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Gender'),
    field: "vGenderName",
    width: "10%",
    hozAlign: "center",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: "vStatusName",
    width: "10%",
    hozAlign: "center",
    headerFilter: "input",
    formatter: function (cell, formatterParams) {
      var value = cell.getData().nStatus;
      return PhUtility.statusFormatter(value, cell.getData().vStatusName);
    }
  };
  if (PhSettings.current.delete) {
    aColumns[nIdx++] = {
      title: '',
      width: '5%',
      hozAlign: 'center',
      headerHozAlign: 'center',
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator('cpy-Copy-User-ListUsers', aColumns);
}
