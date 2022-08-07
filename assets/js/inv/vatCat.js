/* global PhSettings, PhUtility, swal, KTUtil */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    swal.fire({
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
  $('#ph_delete').on('click', function () {
    if (PhSettings.current.delete) {
      doDelete();
    }
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  refreshList();
  openNew();
});

function openNew() {
  var form = KTUtil.getById('ph_Form');
  $('#ph_Form').trigger('reset');
  form.classList.remove('was-validated'); 
  $('#fldId').val(0);
  $('#fldName').val('');
  $('#fldVal').val(0);
  $('#fldRem').val('');
  toggleButtons();
  refreshList();
}

function toggleButtons() {
}

function doDelete() {
  if (PhSettings.current.delete) {
    if ($('#fldId').val() > 0) {
      var vName = '';
      PhUtility.doDelete(vName, {
        'vOperation': 'cpy-Warehouse-VatCategory-Delete',
        'nId': $('#fldId').val()
      }, openNew);
    }
  }
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Warehouse-VatCategory-Save',
      'nId': $('#fldId').val(),
      'vName': $('#fldName').val(),
      'vVal': $('#fldVal').val(),
      'vRem': $('#fldRem').val(),
    }, refreshAll);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldName').val(data.vName);
  $('#fldVal').val(data.vVal);
  $('#fldRem').val(data.vRem);
  toggleButtons(); 
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
  }aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: 'vName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Value'),
    field: 'vVal',
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
  table = getAjaxTabulator('cpy-Warehouse-VatCategory-List', aColumns);
}

function refreshAll(e, cell) {
  refreshList();
  openNew(); 
}
