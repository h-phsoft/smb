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
  $('#fldCurnId').on('change', function () {
    getCurrenRate(parseInt($(this).val()));
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
  $('#fldCurnRate, #fldCamt').off('keyup').on('keyup', function () {
    getAmount();
  });
  refreshList();
});

function openSearch() {
  $('#ph_Modal').modal('show');
  refreshList();
}

function getCurrenRate(CurnId) {
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
            $('#fldCurnRate').val(res.nRate);
            getAmount();
          }
        }
      } catch (ex) {}
    },
    error: function (response) {}
  });
}

function getAmount() {
  var nRate = parseFloat($('#fldCurnRate').val());
  var nCAmt = parseFloat($('#fldCamt').val());
  var nAmt = 0;
  if (nRate > 0 && nCAmt > 0) {
    nAmt = nRate * nCAmt;
  }
  $('#fldAmt').val(nAmt);
}

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldUserId').val('');
  $('#fldNum').val('');
  $('#fldDate').val(currentDate());
  $('#fldExpdate').val(currentDate());
  $('#fldExecdate').val(currentDate());
  $('#fldBoxId').val($('#fldBoxId option:first').val());
  $('#fldServId').val(0);
  $('#fldServName').val('');
  $('#fldCurnId').val($('#fldCurnId option:first').val());
  $('#fldCurnRate').val(1);
  $('#fldCamt').val(0);
  $('#fldAmt').val(0);
  $('#fldStatusId').val(0);
  $('#fldMethodId').val($('#fldMethodId option:first').val());
  $('#fldDocn').val('');
  $('#fldDocd').val(currentDate());
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
    if (parseFloat($('#fldCamt').val()) > 0 && $('#fldDate').val() >= PhSettings.WPSDate && $('#fldDate').val() <= PhSettings.WPEDate) {
      getAmount();
      PhUtility.doSave({
        'vOperation': 'cpy-Cash-ServicePayment-Save',
        'nId': $('#fldId').val(),
        'nNum': $('#fldNum').val(),
        'dDate': $('#fldDate').val(),
        'dExpdate': $('#fldExpdate').val(),
        'dExecdate': $('#fldExecdate').val(),
        'nBoxId': $('#fldBoxId').val(),
        'nServId': $('#fldServId').val(),
        'nCurnId': $('#fldCurnId').val(),
        'nCurnRate': $('#fldCurnRate').val(),
        'nCamt': $('#fldCamt').val(),
        'nAmt': $('#fldAmt').val(),
        'nStatusId': $('#fldStatusId').val(),
        'nMethodId': $('#fldMethodId').val(),
        'vDocn': $('#fldDocn').val(),
        'dDocd': $('#fldDocd').val(),
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
  $('#fldBoxId').val(data.nBoxId);
  $('#fldServId').val(data.nServId);
  $('#fldServName').val(data.vServName);
  $('#fldCurnId').val(data.nCurnId);
  $('#fldCurnRate').val(data.nCurnRate);
  $('#fldCamt').val(data.nCamt);
  $('#fldAmt').val(data.nAmt);
  $('#fldStatusId').val(data.nStatusId);
  $('#fldMethodId').val(data.nMethodId);
  $('#fldDocn').val(data.vDocn);
  $('#fldDocd').val(data.dDocd);
  $('#fldTransId').val(data.nTransId);
  $('#fldReason').val(data.vReason);
  $('#fldCorres').val(data.vCorres);
  $('#fldRecipient').val(data.vRecipient);
  $('#fldRem').val(data.vRem);
  $('#ph_Modal').modal('hide');
}

function cellDeleteClick() {
  PhUtility.doDelete($('#fldNum').val() + '  ' + $('#fldDate').val(), {
    'vOperation': 'cpy-Cash-ServicePayment-Delete',
    'nId': $('#fldId').val()
  }, openNew);
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
    title: getLabel('Box'),
    field: 'vBoxName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Service'),
    field: 'vServName',
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
    title: getLabel('Currency'),
    field: 'vCurnName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Currency Amount'),
    field: 'nCamt',
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
    title: getLabel('Doc.Number'),
    field: 'vDocn',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Doc.Date'),
    field: 'dDocd',
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
  table = getAjaxTabulator('cpy-Cash-ServicePayment-List', aColumns);
}