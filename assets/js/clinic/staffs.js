/* global PhSettings, PhUtility, PhTabulatorLocale, KTUtil */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('#ph_resetPassword_submit').on('click', function () {
    resetPassword();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  refreshList();
});

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldTypeId').val($('#fldTypeId :first').val());
  $('#fldGrpId').val(0);
  $('#fldStatusId').val($('#fldStatusId :first').val());
  $('#fldGenderId').val($('#fldGenderId :first').val());
  $('#fldSpecialId').val($('#fldSpecialId :first').val());
  $('#fldName').val('');
  $('#fldUsername').val('');
  $('#fldPassword').val('');
  $('#pass').removeClass('d-none');
  $('#fldRem').val('');
  // $('#fldImage').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    if ($('#fldPassword').val() == $('#fldVPassword').val()) {
      PhUtility.doSave({
        'vOperation': 'cpy-Clinic-Staff-Save',
        'nId': $('#fldId').val(),
        'nTypeId': $('#fldTypeId').val(),
        'nGrpId': $('#fldGrpId').val(),
        'nStatusId': $('#fldStatusId').val(),
        'nGenderId': $('#fldGenderId').val(),
        'nSpecialId': $('#fldSpecialId').val(),
        'vName': $('#fldName').val(),
        'vUsername': $('#fldUsername').val(),
        'vPassword': $('#fldPassword').val(),
        'vVPassword': $('#fldVPassword').val(),
        'vRem': $('#fldRem').val(),
        // 'vImage': $('#fldImage').val()
      }, refreshList);
    }
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldTypeId').val(data.nTypeId);
  $('#fldGrpId').val(data.nGrpId);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldGenderId').val(data.nGenderId);
  $('#fldSpecialId').val(data.nSpecialId);
  $('#fldName').val(data.vName);
  $('#fldUsername').val(data.vUsername);
  $('#fldPassword').val(data.vPassword);
  $('#pass').addClass('d-none');
  $('#fldRem').val(data.vRem);
  // $('#fldImage').val(data.vImage);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      'vOperation': 'cpy-Clinic-Staff-GetDetails',
      'id': data.nId
    },
    success: function (response) {
      if (response.Status) {
        phTable.setData(response.Data);
      }
    },
    error: function (response) {
    }
  });
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-Staff-Delete',
    'nId': data.nId
  }, refreshALL);
}

function refreshALL() {
  refreshList();
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
        "vOperation": "cpy-Clinic-Staff-ResetPassword",
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

function cellResetClick(e, cell) {
  var data = cell.getData();
  $('#resetUserId').val(data.nId);
  $('#resetPasswordModal').modal('show');
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
    field: 'vName',
    width: '50%',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Username'),
    field: 'vUsername',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Gender'),
    field: 'vGenderName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    hozAlign: "center",
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Type'),
    field: 'vTypeName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    hozAlign: "center",
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: "vStatusName",
    width: "10%",
    hozAlign: "center",
    headerFilter: "input",
    formatter: function (cell, formatterParams) {
      var value = cell.getData().nStatusId;
      return PhUtility.statusFormatter(value, cell.getData().vStatusName);
    }
  };
  if (PhSettings.current.delete) {
    aColumns[nIdx++] = {
      title: getLabel(''),
      width: '4%',
      hozAlign: 'center',
      headerHozAlign: 'center',
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator('cpy-Clinic-Staff-List', aColumns);
}



