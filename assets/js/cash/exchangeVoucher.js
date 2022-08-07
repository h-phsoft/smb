/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    Swal.fire({
      title: getLabel('Are you sure ?'),
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "<i class='flaticon2-check-mark'></i> " + getLabel('Yes'),
      cancelButtonText: "<i class='flaticon2-cross'></i> " + getLabel('No'),
      reverseButtons: true,
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-default"
      }
    }).then(function (result) {
      if (result.value) {
        openNew();
      } else if (result.dismiss === "cancel") {}
    });
  });
  $('#fldFCurnId').on('change', function () {
    getFCurrenRate(parseInt($(this).val()));
  });
  $('#fldTCurnId').on('change', function () {
    getTCurrenRate(parseInt($(this).val()));
  });
  $('#ph_search').on('click', function () {
    openSearch();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('#ph_delete').on('click', function () {
    cellDeleteClick();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  $('#fldFCurnRate, #fldFCamt').off('keyup').on('keyup', function () {
    getFAmount();
  });
  $('#fldTCurnRate, #fldTCamt').off('keyup').on('keyup', function () {
    getTAmount();
  });
  refreshList();
});

function openSearch() {
  $('#ph_Modal').modal('show');
  refreshList();
}

function getFCurrenRate(CurnId) {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      "vOperation": "cpy-Management-Currency-getRate",
      "nId": CurnId
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          if (res.nRate > 0) {
            $('#fldFCurnRate').val(res.nRate);
            getFAmount();
          }
        }
      } catch (ex) {}
    },
    error: function (response) {}
  });
}

function getTCurrenRate(CurnId) {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      "vOperation": "cpy-Management-Currency-getRate",
      "nId": CurnId
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          if (res.nRate > 0) {
            $('#fldTCurnRate').val(res.nRate);
            getTAmount();
          }
        }
      } catch (ex) {}
    },
    error: function (response) {}
  });
}

function getFAmount() {
  var nRate = parseFloat($('#fldFCurnRate').val());
  var nCAmt = parseFloat($('#fldFCamt').val());
  var nAmt = 0;
  if (nRate > 0 && nCAmt > 0) {
    nAmt = nRate * nCAmt;
  }
  $('#fldFAmt').val(nAmt);
}

function getTAmount() {
  var nRate = parseFloat($('#fldTCurnRate').val());
  var nCAmt = parseFloat($('#fldTCamt').val());
  var nAmt = 0;
  if (nRate > 0 && nCAmt > 0) {
    nAmt = nRate * nCAmt;
  }
  $('#fldTAmt').val(nAmt);
}

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldUserId').val('');
  $('#fldNum').val('');
  $('#fldDate').val(currentDate());
  $('#fldExpdate').val(currentDate());
  $('#fldExecdate').val(currentDate());
  $('#fldFBoxId').val($('#fldFBoxId option:first').val());
  $('#fldFCurnId').val($('#fldFCurnId option:first').val());
  $('#fldFCurnRate').val(1);
  $('#fldFCamt').val(0);
  $('#fldFAmt').val(0);
  $('#fldTBoxId').val($('#fldTBoxId option:first').val());
  $('#fldTCurnId').val($('#fldTCurnId option:first').val());
  $('#fldTCurnRate').val(1);
  $('#fldTCamt').val(0);
  $('#fldTAmt').val(0);
  $('#fldStatusId').val(0);
  $('#fldMethodId').val($('#fldMethodId option:first').val());
  $('#fldTransId').val($('#fldTransId option:first').val());
  $('#fldReason').val('');
  $('#fldCorres').val('');
  $('#fldRecipient').val('');
  $('#fldRem').val('');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    if (parseFloat($('#fldFCamt').val()) > 0 && parseFloat($('#fldTCamt').val()) > 0 && $('#fldDate').val() >= PhSettings.WPSDate && $('#fldDate').val() <= PhSettings.WPEDate) {
      getFAmount();
      getTAmount();
      PhUtility.doSave({
        'vOperation': 'cpy-Cash-Exchange-Save',
        'nId': $('#fldId').val(),
        'nNum': $('#fldNum').val(),
        'dDate': $('#fldDate').val(),
        'dExpdate': $('#fldExpdate').val(),
        'dExecdate': $('#fldExecdate').val(),
        'nFBoxId': $('#fldFBoxId').val(),
        'nFCurnId': $('#fldFCurnId').val(),
        'nFCurnRate': $('#fldFCurnRate').val(),
        'nFCamt': $('#fldFCamt').val(),
        'nFAmt': $('#fldFAmt').val(),
        'nTBoxId': $('#fldTBoxId').val(),
        'nTCurnId': $('#fldTCurnId').val(),
        'nTCurnRate': $('#fldTCurnRate').val(),
        'nTCamt': $('#fldTCamt').val(),
        'nTAmt': $('#fldTAmt').val(),
        'nStatusId': $('#fldStatusId').val(),
        'nMethodId': $('#fldMethodId').val(),
        'nTransId': $('#fldTransId').val(),
        'vReason': $('#fldReason').val(),
        'vCorres': $('#fldCorres').val(),
        'vRecipient': $('#fldRecipient').val(),
        'vRem': $('#fldRem').val(),
      }, openNew);
    }
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldUserId').val(data.vUserName);
  $('#fldNum').val(data.nNum);
  $('#fldDate').val(data.dDate);
  $('#fldExpdate').val(data.dExpdate);
  $('#fldExecdate').val(data.dExecdate);
  $('#fldFBoxId').val(data.nFBoxId);
  $('#fldFCurnId').val(data.nFCurnId);
  $('#fldFCurnRate').val(data.nFCurnRate);
  $('#fldFCamt').val(data.nFCamt);
  $('#fldFAmt').val(data.nFAmt);
  $('#fldTBoxId').val(data.nTBoxId);
  $('#fldTCurnId').val(data.nTCurnId);
  $('#fldTCurnRate').val(data.nTCurnRate);
  $('#fldTCamt').val(data.nTCamt);
  $('#fldTAmt').val(data.nTAmt);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldMethodId').val(data.nMethodId);
  $('#fldTransId').val(data.nTransId);
  $('#fldReason').val(data.vReason);
  $('#fldCorres').val(data.vCorres);
  $('#fldRecipient').val(data.vRecipient);
  $('#fldRem').val(data.vRem);
  $('#ph_Modal').modal('hide');
}

function cellDeleteClick() {
  if ($('#fldId').val() > 0) {
    PhUtility.doDelete($('#fldNum').val() + '  ' + $('#fldDate').val(), {
      'vOperation': 'cpy-Cash-Exchange-Delete',
      'nId': $('#fldId').val()
    }, openNew);
  }
}

function refreshALL() {
  refreshList();
}

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (PhSettings.current.update) {
    aColumns[nIdx++] = {
      title: getLabel(''),
      width: '4%',
      hozAlign: 'center',
      headerHozAlign: 'center',
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    };
  }
  aColumns[nIdx++] = {
    title: getLabel('From Box'),
    field: 'vFBoxName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('To Box'),
    field: 'vTBoxName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Num'),
    field: 'nNum',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Date'),
    field: 'dDate',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('User'),
    field: 'vUserName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Execdate'),
    field: 'dExecdate',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('From Currency'),
    field: 'vFCurnName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency Amount'),
    field: 'nFCamt',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('To Currency'),
    field: 'vTCurnName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency Amount'),
    field: 'nTCamt',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Status'),
    field: 'vStatusName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Reason'),
    field: 'vReason',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Remarks'),
    field: 'vRem',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  table = getAjaxTabulator('cpy-Cash-Exchange-List', aColumns);
}