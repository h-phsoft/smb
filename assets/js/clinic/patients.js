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
});

function openNew() {
  $('#ph_Form').trigger('reset');
  $('#fldId').val(0);
  $('#fldClinicId').val($('#fldClinicId :first').val());
  $('#fldName').val('');
  $('#fldNum').val('');
  $('#fldBirthday').val('');
  $('#fldGenderId').val($('#fldGenderId :first').val());
  $('#fldMartialId').val($('#fldMartialId :first').val());
  $('#fldNatId').val($('#fldNatId :first').val());
  $('#fldVisaId').val($('#fldVisaId :first').val());
  $('#fldHormonalId').val(2);
  $('#fldSmokedId').val(2);
  $('#fldAlcoholicId').val(2);
  $('#fldPregnancyId').val(2);
  $('#fldBreastfeedId').val(2);
  $('#fldNatNum').val('');
  $('#fldIdtypeId').val($('#fldIdtypeId :first').val());
  $('#fldIdnum').val('');
  $('#fldMobile').val('');
  $('#fldLand1').val('');
  $('#fldLand2').val('');
  $('#fldJobName').val('');
  $('#fldAddr').val('');
  $('#fldChronicDiseases').val('');
  $('#fldPreOperations').val('');
  $('#fldMedicinesUsed').val('');
  $('#fldPatrem').val('');
  $('#fldRem').val('');
  $('#fldHownow').val('');
  $('#fldHownowId').val($('#fldHownowId :first').val());
  $('#fldEmail').val('');
  $('#fldCompany').val('');
  $('#fldLangs').val('');
  $('#fldDescription').val('');
  $('#ph_Modal').modal('show');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Clinic-Patient-Save',
      'nId': $('#fldId').val(),
      'nClinicId': 1,
      'vName': $('#fldName').val(),
      'vNum': $('#fldNum').val(),
      'dBirthday': $('#fldBirthday').val(),
      'nGenderId': $('#fldGenderId').val(),
      'nMartialId': $('#fldMartialId').val(),
      'nNatId': $('#fldNatId').val(),
      'nVisaId': $('#fldVisaId').val(),
      'nHormonalId': $('#fldHormonalId').val(),
      'nSmokedId': $('#fldSmokedId').val(),
      'nAlcoholicId': $('#fldAlcoholicId').val(),
      'nPregnancyId': $('#fldPregnancyId').val(),
      'nBreastfeedId': $('#fldBreastfeedId').val(),
      'vNatNum': $('#fldNatNum').val(),
      'nIdtypeId': $('#fldIdtypeId').val(),
      'vIdnum': $('#fldIdnum').val(),
      'vMobile': $('#fldMobile').val(),
      'vLand1': $('#fldLand1').val(),
      'vLand2': $('#fldLand2').val(),
      'vJobName': $('#fldJobName').val(),
      'vAddr': $('#fldAddr').val(),
      'vChronicDiseases': $('#fldChronicDiseases').val(),
      'vPreOperations': $('#fldPreOperations').val(),
      'vMedicinesUsed': $('#fldMedicinesUsed').val(),
      'vPatrem': $('#fldPatrem').val(),
      'vRem': $('#fldRem').val(),
      'vHownow': $('#fldHownow').val(),
      'nHownowId': $('#fldHownowId').val(),
      'vEmail': $('#fldEmail').val(),
      'vCompany': $('#fldCompany').val(),
      'vLangs': $('#fldLangs').val(),
      'vDescription': $('#fldDescription').val()
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
  $('#fldClinicId').val(data.nClinicId);
  $('#fldName').val(data.vName);
  $('#fldNum').val(data.vNum);
  $('#fldBirthday').val(data.dBirthday);
  $('#fldGenderId').val(data.nGenderId);
  $('#fldMartialId').val(data.nMartialId);
  $('#fldNatId').val(data.nNatId);
  $('#fldVisaId').val(data.nVisaId);
  $('#fldHormonalId').val(data.nHormonalId);
  $('#fldSmokedId').val(data.nSmokedId);
  $('#fldAlcoholicId').val(data.nAlcoholicId);
  $('#fldPregnancyId').val(data.nPregnancyId);
  $('#fldBreastfeedId').val(data.nBreastfeedId);
  $('#fldNatNum').val(data.vNatNum);
  $('#fldIdtypeId').val(data.nIdtypeId);
  $('#fldIdnum').val(data.vIdnum);
  $('#fldMobile').val(data.vMobile);
  $('#fldLand1').val(data.vLand1);
  $('#fldLand2').val(data.vLand2);
  $('#fldJobName').val(data.vJobName);
  $('#fldAddr').val(data.vAddr);
  $('#fldChronicDiseases').val(data.vChronicDiseases);
  $('#fldPreOperations').val(data.vPreOperations);
  $('#fldMedicinesUsed').val(data.vMedicinesUsed);
  $('#fldPatrem').val(data.vPatrem);
  $('#fldRem').val(data.vRem);
  $('#fldHownow').val(data.vHownow);
  $('#fldHownowId').val(data.nHownowId);
  $('#fldEmail').val(data.vEmail);
  $('#fldCompany').val(data.vCompany);
  $('#fldLangs').val(data.vLangs);
  $('#fldDescription').val(data.vDescription);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-Patient-Delete',
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
    title: getLabel('Num'),
    field: 'vNum',
    hozAlign: 'left',
    width: '15%',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Name'),
    field: 'vName',
    hozAlign: 'left',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Gender'),
    field: 'vGenderName',
    hozAlign: 'left',
    width: '15%',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
  };
  aColumns[nIdx++] = {
    title: getLabel('Mobile'),
    field: 'vMobile',
    hozAlign: 'left',
    width: '15%',
    headerHozAlign: 'center',
    headerFilter: 'input',
    formatter: 'textarea'
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
  table = getAjaxTabulator('cpy-Clinic-Patient-List', aColumns);
}
