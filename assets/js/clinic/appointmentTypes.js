/* global PhSettings, PhUtility, PhTabulatorLocale, KTUtil */
var table;
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('.ph_export').on('click', function () {
    var type = parseInt($(this).data('type'));
    var fileName = $(this).data('file');
    ph_export(table, type, fileName);
  });
  refreshList();

  $('#fldTbgId').change(function () {
    var vClass = '';
    var nColor = $(this).val(); 
    var oColor = getColor(nColor); 
    var nextButton = $(this).next('button');
    PhSettings['color'].forEach(function (element) {
      vClass = element.Bgclass + ' ' + element.Bgtext;
      nextButton.removeClass('btn-' + element.Name.toLowerCase());
      $('#atTypeName').removeClass(vClass);
    });
    vClass = oColor.Bgclass + ' ' + oColor.Text;
    nextButton.addClass('btn-' + oColor.Name.toLowerCase());
    $('#atTypeName').addClass(vClass);
  });

  $('#fldTfgId').change(function () {
    var vClass = '';
    var nColor = $(this).val();
    var oColor = getColor(nColor);
    var nextButton = $(this).next('button');
    PhSettings['color'].forEach(function (element) {
      vClass = element.Fgclass;
      nextButton.removeClass('btn-' + element.Name.toLowerCase());
      $('#atTypeName').removeClass(vClass);
    });
    vClass = oColor.Fgclass;
    nextButton.addClass('btn-' + oColor.Name.toLowerCase());
    $('#atTypeName').addClass(vClass);
  });

  $('#fldNfgId').change(function () {
    var vClass = '';
    var nColor = $(this).val();
    var oColor = getColor(nColor);
    var nextButton = $(this).next('button');
    PhSettings['color'].forEach(function (element) {
      vClass = element.Fgclass;
      nextButton.removeClass('btn-' + element.Name.toLowerCase());
      $('#atPatientName').removeClass(vClass);
    });
    vClass = oColor.Fgclass;
    nextButton.addClass('btn-' + oColor.Name.toLowerCase());
    $('#atPatientName').addClass(vClass);
  });
});

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldName').val('');
  $('#fldCapacity').val(0);
  $('#fldTime').val(PhSettings.appTime);
  $('#fldTbgId').val($('#fldTbgId :first').val());
  $('#fldTfgId').val($('#fldTfgId :first').val());
  $('#fldNfgId').val($('#fldNfgId :first').val());
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Clinic-AppointmentType-Save',
      'nId': $('#fldId').val(),
      'vName': $('#fldName').val(),
      'nCapacity': $('#fldCapacity').val(),
      'nTime': $('#fldTime').val(),
      'nTbgId': $('#fldTbgId').val(),
      'nTfgId': $('#fldTfgId').val(),
      'nNfgId': $('#fldNfgId').val()
    }, refreshList);
    if (!(parseInt($('#fldId').val()) > 0)) {
      $("#ph_Form").trigger("reset");
    }
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#fldId').val(data.nId);
  $('#fldName').val(data.vName);
  $('#fldCapacity').val(data.nCapacity);
  $('#fldTime').val(data.nTime);
  $('#fldTbgId').val(data.nTbgId);
  $('#fldTfgId').val(data.nTfgId);
  $('#fldNfgId').val(data.nNfgId);
  $('#ph_Modal').modal('show'); 

  PhSettings['color'].forEach(function (element) {
    $('#atTypeName').removeClass(element.Bgclass);
    $('#atTypeName').removeClass(element.Fgclass);
    $('#atPatientName').removeClass(element.Fgclass);
  });
  var oAppTypeTBGColor = getColor(data.nTbgId);
  var oAppTypeTFGColor = getColor(data.nTfgId);
  var oAppTypeNFGColor = getColor(data.nNfgId);
  $('#atTypeName').addClass(oAppTypeTBGColor.Bgclass);
  $('#atTypeName').addClass(oAppTypeTFGColor.Fgclass);
  $('#atPatientName').addClass(oAppTypeNFGColor.Fgclass);

}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-AppointmentType-Delete',
    'nId': data.nId
  }, refreshALL);
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
    title: getLabel('Name'),
    field: 'vName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Capacity'),
    field: 'nCapacity',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Time'),
    field: 'nTime',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Color'),
    field: "",
    width: "15%",
    headerHozAlign: 'center',
    hozAlign: 'center',
    headerSort: false,
    formatter: function (cell, formatterParams) {
      var data = cell.getData();
      var oAppTypeTBGColor = getColor(data.nTbgId);
      var oAppTypeTFGColor = getColor(data.nTfgId);
      var oAppTypeNFGColor = getColor(data.nNfgId);
      var vHtml = '';
      vHtml += '<div class="card border-success m-0 text-wrap" style="height: 100%; width: 100%;">';
      vHtml += '  <div class="card-header p-3 ' + oAppTypeTBGColor.Bgclass + ' ' + oAppTypeTFGColor.Fgclass + '">' + data.vName + '</div>';
      vHtml += '  <div class="card-body p-2 m-0 ' + oAppTypeNFGColor.Fgclass + '">';
      vHtml += '    <h5 class="card-title m-0 p-1">Patient Name</h5>';
      vHtml += '  </div>';
      vHtml += '  <div class="card-footer px-5 py-1 bg-light"><i class="icon-md flaticon-calendar-with-a-clock-time-tools"></i> Status Name</div>';
      vHtml += '</div>';
      return vHtml;
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
  table = getAjaxTabulator('cpy-Clinic-AppointmentType-List', aColumns);
}

