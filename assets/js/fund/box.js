/* global PhSettings, PhUtility, KTUtil */

var table;
var phTable;
var image;
jQuery(document).ready(function () {

  $('#ph_add').on('click', function () {
    openAdd();
  });

  $('#ph_save').on('click', function () {
    save();
  });

  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });

  refreshList();
});

function refreshList() {
  var aColumns = [{title: '',
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    },
    {title: getLabel('Name'),
      field: "Name",
      hozAlign: "left",
      headerHozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Account'),
      field: "AccName",
      hozAlign: "left",
      headerHozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Cashier'),
      field: "UserName",
      hozAlign: "left",
      headerHozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Status'),
      field: "StatusName",
      hozAlign: "left",
      headerHozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: getLabel('Remarks'),
      field: "Rem",
      hozAlign: "left",
      headerHozAlign: "center",
      headerFilter: "input",
      formatter: "textarea"
    },
    {title: '',
      width: "4%",
      headerHozAlign: "center",
      hozAlign: "center",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    }
  ];
  table = getAjaxTabulator("cpy-Fund-Box-List", aColumns);
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#boxId').val(data.Id);
  $('#boxName').val(data.Name);
  $('#boxRem').val(data.Rem);
  $('#boxAcc').val(data.Acc);
  $('#boxAccName').val(data.AccName);
  $('#boxUser').val(data.User);
  $('#boxUser').change();
  $('#boxStatus').val(data.Status);
  $('#boxStatus').change();
  $('#itemModal').modal('show');
}

function openAdd() {
  $("#itemForm").trigger("reset");
  $('#boxId').val('');
  $('#itemModal').modal('show');
}

function save() {
  var form = KTUtil.getById('itemForm');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Fund-Box-Save",
      'nId': $('#boxId').val(),
      'vName': $('#boxName').val(),
      'vRem': $('#boxRem').val(),
      'nUser': $('#boxUser').val(),
      'nAcc': $('#boxAcc').val(),
      'nStatus': $('#boxStatus').val()
    }, refreshALL);
    if (!(parseInt($('#boxId').val()) > 0)) {
      $("#itemForm").trigger("reset");
    }
  } else {
    form.classList.add('was-validated');
  }
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(getLabel('Fund Box'), {
    "vOperation": "cpy-Fund-Box-Delete",
    "nId": data.Id
  }, refreshALL);
}

function refreshALL() {
  $("#itemForm").trigger("reset");
  refreshList();
}