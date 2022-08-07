/* global PhSettings, PhUtility, swal, KTUtil */
var table;
var aData = [];
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
  $('#fldtTypeId').on('change', function () {
    getTypeItem(parseInt($(this).val()));
  });
  $('#ph_search').on('click', function () {
    openSearch();
  });
  $('#ph_delete').on('click', function () {
    if (PhSettings.current.delete) {
      doDelete();
    }
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('#ph_dSubmit').on('click', function () {
    addDataRow();
  });
  $('#addRow').on('click', function () {
    addDataRow();
  });
  openNew();
});

function getTypeItem(nTypeId) {
  $('.fldDName').addClass('d-none');
  $('#fldDName' + nTypeId).removeClass('d-none');
  phAutocomplete();
}

function openNew() {
  $('ph_Form').trigger('reset');
  $('ph_Form').removeClass('was-validated');
  $('#fldId').val(0);
  $('#fldName').val('');
  $('#fldCurnId').val($('#fldCurnId :first').val());
  $('#fldSdate').val(currentDate());
  $('#fldEdate').val(currentDate());
  $('#fldRem').val('');
  openNewRow();

  toggleButtons();
  aData = [];
  drawData();
}

function toggleButtons() {

}

function openSearch() {
  $('#ph_Modal').modal('show');
  refreshList();
}

function doDelete() {
  if (PhSettings.current.delete) {
    if ($('#fldId').val() > 0) {
      var vName = '';
      PhUtility.doDelete(vName, {
        'vOperation': 'cpy-Inv-PriceList-Delete',
        'nId': $('#fldId').val()
      }, openNew);
    }
  }
}

function openNewRow() {
  $('#fldTIndex').val(-1);
  $('#fldtId').val(0);
  $('#fldtTypeId').val($('#fldtTypeId :first').val());
  $('#fldDNameId').val(0);
  $('#fldDName1').val('');
  $('#fldDName2').val('');
  $('#fldtPrice').val(0);
  $('#fldtRem').val('');
}

function addDataRow() {
  var index = aData.length;
  if (!($('#fldDName' + $('#fldtTypeId').val()).val() == '' || $('#fldtPrice').val() == '' || $('#fldDNameId').val() == 0)) {
    if (parseInt($('#fldTIndex').val()) > -1) {
      index = $('#fldTIndex').val();
    }
    aData[index] = {};
    aData[index].isDeleted = false;
    aData[index].nId = $('#fldtId').val();
    aData[index].nTypeId = $('#fldtTypeId').val();
    aData[index].vTypeName = $('#fldtTypeId option:selected').text();
    aData[index].nDNameId = $('#fldDNameId').val();
    aData[index].vDName = $('#fldDName' + $('#fldtTypeId').val()).val();
    aData[index].nPrice = $('#fldtPrice').val();
    aData[index].vRem = $('#fldtRem').val();
    drawData();
    openNewRow();
  }
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var aRows = aData;
    PhUtility.doSave({
      'vOperation': 'cpy-Inv-PriceList-Save',
      'nId': $('#fldId').val(),
      'vName': $('#fldName').val(),
      'nCurnId': $('#fldCurnId').val(),
      'dSdate': $('#fldSdate').val(),
      'dEdate': $('#fldEdate').val(),
      'vRem': $('#fldRem').val(),
      'aRows': aRows
    }, openNew);
  } else {
    form.classList.add('was-validated');
  }
}

function getRows() {
  return aData;
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldName').val(data.vName);
  $('#fldCurnId').val(data.nCurnId);
  $('#fldSdate').val(data.dSdate);
  $('#fldEdate').val(data.dEdate);
  $('#fldRem').val(data.vRem);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      'vOperation': 'cpy-Inv-PriceList-GetDetails',
      'id': data.nId
    },
    success: function (response) {
      if (response.Status) {
        aData = response.Data;
        drawData();
      }
    },
    error: function (response) {}
  });
  toggleButtons();
  $('#ph_Modal').modal('hide');
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
    title: getLabel('Name'),
    field: 'vName',
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
    title: getLabel('Sdate'),
    field: 'dSdate',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Edate'),
    field: 'dEdate',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Rem'),
    field: 'vRem',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  table = getAjaxTabulator('cpy-Inv-PriceList-List', aColumns);
}

function drawData() {
  var vHtml = "";
  for (let index = 0; index < aData.length; index++) {
    if (!aData[index].isDeleted) {
      vHtml += '<tr>';
      vHtml += '  <td>';
      vHtml += '    <a href="javascript:;" class="btn btn-light-primary p-1 edit-item" data-id="' + index + '" >';
      vHtml += '      <i class="icon-x flaticon-edit"></i>';
      vHtml += '    </a>';
      vHtml += '  </td>';
      vHtml += '  <td>' + aData[index].vTypeName + '</td>';
      vHtml += '  <td>' + aData[index].vDName + '</td>';
      vHtml += '  <td>' + aData[index].nPrice + '</td>';
      vHtml += '  <td>' + aData[index].vRem + '</td>';
      vHtml += '  <td>';
      vHtml += '    <a href="javascript:;" class="btn btn-light-danger p-1 delete-item" data-id="' + index + '">';
      vHtml += '      <i class="icon-x flaticon2-rubbish-bin"></i>';
      vHtml += '    </a>';
      vHtml += '  </td>';
      vHtml += '</tr>';
    }
  }

  $('#dataTable tbody').html(vHtml);
  $('.edit-item').off().on('click', function () {
    editDataRow(parseInt($(this).data('id')));
  });
  $('.delete-item').off().on('click', function () {
    deleteDataRow(parseInt($(this).data('id')));
  });
}

function editDataRow(index) {
  $('#fldTIndex').val(index);
  $('#fldtId').val(aData[index].nId);
  $('#fldtTypeId').val(aData[index].nTypeId);
  $('#fldDNameId').val(aData[index].nDNameId);
  $('#fldDName' + $('#fldtTypeId').val()).val(aData[index].vDName);
  $('#fldtPrice').val(aData[index].nPrice);
  $('#fldtRem').val(aData[index].vRem);
}

function deleteDataRow(index) {
  if (aData[index].nId > 0) {
    aData[index].isDeleted = true;
  } else {
    aData.splice(index, 1);
  }
  drawData();
}