/* global PhUtility, PhSettings */

var aData = [];
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  refreshList();
});

function openNew() {
  openNewEmpyt()
  $('#ph_Modal').modal('show');
}

function openNewEmpyt() {
  $('#ph_Form').trigger('reset');
  $('#ph_Form').removeClass('was-validated');
  $('#fldTIndex').val(-1);
  $('#fldId').val(0);
  $('#fldStatusId').val($('#fldStatusId :first').val());
  $('#fldName').val('');
  $('#fldPrefix').val('');
  $('#fldEmail').val('');
  $('#fldPhone1').val('');
  $('#fldPhone2').val('');
  // $('#fldPhone3').val('');
  $('#fldAddress').val('');
}

function save() {
  var form = KTUtil.getById('ph_Form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': 'cpy-Clinic-Clinic-Save',
      'nId': $('#fldId').val(),
      'nStatusId': $('#fldStatusId').val(),
      'vName': $('#fldName').val(),
      'vPrefix': $('#fldPrefix').val(),
      'vEmail': $('#fldEmail').val(),
      'vPhone1': $('#fldPhone1').val(),
      'vPhone2': $('#fldPhone2').val(),
      'vPhone3': ' ',
      'vAddress': $('#fldAddress').val()
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function cellEditClick(index) {
  $('#fldIndex').val(index);
  $('#fldId').val(aData[index].nId);
  $('#fldStatusId').val(aData[index].nStatusId);
  $('#fldName').val(aData[index].vName);
  $('#fldPrefix').val(aData[index].vPrefix);
  $('#fldEmail').val(aData[index].vEmail);
  $('#fldPhone1').val(aData[index].vPhone1);
  $('#fldPhone2').val(aData[index].vPhone2);
  // $('#fldPhone3').val(aData[index].vPhone3);
  $('#fldAddress').val(aData[index].vAddress);
  $('#ph_Modal').modal('show');
}

function cellDeleteClick(index) {
  var data = aData[index];
  PhUtility.doDelete(data.vName, {
    'vOperation': 'cpy-Clinic-Clinic-Delete',
    'nId': data.nId
  }, refreshList);
}

function refreshList() {
  $('#Cards').html('');
  aData = [];
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'vCopy': PhSettings.copy,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      "vOperation": "cpy-Clinic-Clinic-List",
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          aData = res.Data;
          var vHtml = '';
          var vStatus = '';
          vHtml += '<div class="row">';
          for (var i = 0; i < aData.length; i++) {
            var clinic = aData[i];
            vStatus = 'flaticon2-correct text-success';
            if (clinic['nStatusId'] == 2) {
              vStatus = 'flaticon2-hexagonal text-danger';
            }
            vHtml += '<div class="col-sm-6">';
            vHtml += '<div class="card card-custom gutter-b">';
            vHtml += '  <div class="card-body">';
            vHtml += '    <div class="d-flex">';
            vHtml += '      <div class="flex-grow-1">';
            vHtml += '        <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">';
            vHtml += '          <div class="mr-3">';
            vHtml += '            <a href="javascript:;" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">';
            vHtml += '              <i class="' + vStatus + ' icon-md mr-2"></i>';
            vHtml += '              ' + clinic['vName'] + ', ' + clinic['vPrefix'];
            vHtml += '            </a>';
            vHtml += '          </div>';
            vHtml += '          <div class="my-lg-0 my-1">';
            // if (parseInt(PhSettings.current.update) === 1) {
            vHtml += '            <span class="btn btn-sm btn-primary font-weight-bolder text-uppercase clinic-edit" title="edit" data-id="' + i + '">';
            vHtml += '              <i class="icon-md text-light flaticon2-edit"></i>';
            vHtml += '            </span>';
            // }
            vHtml += '          </div>';
            vHtml += '        </div>';
            vHtml += '        <div class="d-flex align-items-center flex-wrap justify-content-between">';
            vHtml += '          <div class="d-flex flex-wrap my-2">';
            if (clinic['Email'] !== null) {
              vHtml += '            <span class="text-dark font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">';
              vHtml += '              <i class="flaticon-mail icon-md mr-2"></i>' + clinic['vEmail'];
              vHtml += '            </span>';
            }
            if (clinic['Phone1'] !== null) {
              vHtml += '            <span class="text-dark font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">';
              vHtml += '              <i class="flaticon2-phone icon-md mr-2"></i>' + clinic['vPhone1'];
              vHtml += '            </span>';
            }
            if (clinic['Phone2'] !== null) {
              vHtml += '            <span class="text-dark font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">';
              vHtml += '              <i class="flaticon2-phone icon-md mr-2"></i>' + clinic['vPhone2'];
              vHtml += '            </span>';
            }
            if (clinic['Phone3'] !== null) {
              vHtml += '            <span class="text-dark font-weight-bold">';
              vHtml += '              <i class="flaticon2-phone icon-md mr-2"></i>' + clinic['vPhone3'];
              vHtml += '            </span>';
            }
            vHtml += '          </div>';
            vHtml += '        </div>';
            vHtml += '        <div class="d-flex align-items-center flex-wrap justify-content-between">';
            vHtml += '          <div class="flex-grow-1 font-weight-bold text-dark-75 py-2 py-lg-2 mr-5">';
            vHtml += '            <i class="flaticon2-location icon-md mr-2"></i>' + clinic['vAddress'];
            vHtml += '          </div>';
            vHtml += '        </div>';
            // vHtml += '        <div class="d-flex align-items-center flex-wrap justify-content-between">';
            // vHtml += '          <div class="flex-grow-1 font-weight-bold text-dark-75 py-2 py-lg-2 mr-5">';
            // vHtml += '            <i class="flaticon2-user icon-md mr-2"></i>' + clinic['nInsUser'] + ', ' + clinic['IDate'];
            // vHtml += '          </div>';
            // vHtml += '        </div>';
            // vHtml += '        <div class="d-flex align-items-center flex-wrap justify-content-between">';
            // vHtml += '          <div class="flex-grow-1 font-weight-bold text-dark-75 py-2 py-lg-2 mr-5">';
            // vHtml += '            <i class="flaticon2-user icon-md mr-2"></i>' + clinic['nUpdUser'] + ', ' + clinic['UDate'];
            // vHtml += '          </div>';
            // vHtml += '        </div>';
            vHtml += '        <div class="d-flex align-items-center flex-wrap justify-content-between">';
            // if (parseInt(PhSettings.current.delete) === 1) {
            vHtml += '          <span class="btn btn-sm btn-danger font-weight-bolder text-uppercase clinic-delete" title="delete" data-id="' + i + '">';
            vHtml += '            <i class="icon-md text-light flaticon-delete"></i>';
            vHtml += '          </span>';
            // }
            vHtml += '        </div>';
            vHtml += '      </div>';
            vHtml += '    </div>';
            vHtml += '  </div>';
            vHtml += '</div>';
            vHtml += '</div>';
          }
          vHtml += '</div>';
          $('#Cards').html(vHtml);
          $('.clinic-edit').on('click', function () {
            cellEditClick($(this).data('id'));
          });
          $('.clinic-delete').on('click', function () {
            cellDeleteClick($(this).data('id'));
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "OK",
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
        }
      } catch (ex) {
      }
    },
    error: function (response) { }
  });
  openNewEmpyt();
}
