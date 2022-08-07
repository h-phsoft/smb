/* global PhSettings, PhUtility, KTUtil, HOST_URL */
var aData = [];
jQuery(document).ready(function () {

  $('#btnPrevious').on('click', function () {
    refreshList($('#lstBox').val(), $('#diaryDate').val(), -1);
  });
  $('#diaryDate, #lstBox').on('change', function () {
    refreshList($('#lstBox').val(), $('#diaryDate').val());
  });
  $('#btnNext').on('click', function () {
    refreshList($('#lstBox').val(), $('#diaryDate').val(), 1);
  });
  $('#btnRefresh').on('click', function () {
    refreshList($('#lstBox').val(), $('#diaryDate').val());
  });
  $('#btnPayment').on('click', function () {
    openNewPayment();
  });
  $('#btnCollect').on('click', function () {
    openNewCollection();
  });
  $('#btnExchange').on('click', function () {
    openNewExchange();
  });

  $('#ph_save').on('click', function () {
    save();
  });
  $('#ph_exchangeSave').on('click', function () {
    saveExchange();
  });

  refreshList($('#lstBox').val(), $('#diaryDate').val());
});

function openNewPayment() {
  $("#fundForm").trigger("reset");
  $('#fundModalTitle').text(getLabel('Fund Payment'));
  $('#fldId').val(0);
  $('#fldType').val(2);
  $('#fldDate').val($('#diaryDate').val());
  $('#attPreview').attr('src', '');
  $('#fundModal').modal('show');
}

function openNewCollection() {
  $("#fundForm").trigger("reset");
  $('#fundModalTitle').text(getLabel('Fund Collection'));
  $('#fldId').val(0);
  $('#fldType').val(1);
  $('#fldDate').val($('#diaryDate').val());
  $('#attPreview').attr('src', '');
  $('#fundModal').modal('show');
}

function openNewExchange() {
  $("#fundExchangeForm").trigger("reset");
  $('#fundExchangeModalTitle').text(getLabel('Fund Exchange'));
  $('#fldExId').val(0);
  $('#fldExType').val(1);
  $('#fldExDate').val($('#diaryDate').val());
  $('#fldExDate').val($('#diaryDate').val());
  $('#fundExchangeModal').modal('show');
}

function openEdit(nIdx) {
  $("#fundForm").trigger("reset");
  if (aData[nIdx].TId === 1) {
    $('#fundModalTitle').text(getLabel('Fund Collection'));
  } else {
    $('#fundModalTitle').text(getLabel('Fund Payment'));
  }
  $('#attPreview').attr('src', '');
  $('#fldId').val(aData[nIdx].Id);
  $('#fldType').val(aData[nIdx].TId);
  $('#fldCurn').val(aData[nIdx].CCId);
  $('#fldCurn').change();
  $('#fldDate').val(aData[nIdx].Date);
  $('#fldAmt').val(aData[nIdx].CAmt);
  $('#fldAccId').val(aData[nIdx].AId);
  $('#fldAccName').val(aData[nIdx].AName);
  $('#fldCntrId').val(aData[nIdx].CId);
  $('#fldCntrName').val(aData[nIdx].CName);
  $('#fldRem').val(aData[nIdx].Rem);
  $('#attPreview').attr('src', aData[nIdx].Attach);
  $('#fundModal').modal('show');
}

function save() {
  var form = KTUtil.getById('fundForm');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var $fileField = $('#fldFile');
    var folder = $fileField.data('folder');
    var fileName = $('#' + $fileField.data('relname')).val();
    var vBase64 = $('#' + $fileField.data('relfld')).val();
    PhUtility.doSave({
      'vOperation': "cpy-Fund-Diary-Save",
      'nId': $('#fldId').val(),
      'nType': $('#fldType').val(),
      'nBox': $('#lstBox').val(),
      'nAccId': $('#fldAccId').val(),
      'nCntrId': $('#fldCntrId').val(),
      'nCurn': $('#fldCurn').val(),
      'dDate': $('#fldDate').val(),
      'nAmt': $('#fldAmt').val(),
      'vRem': $('#fldRem').val(),
      'vFile': vBase64,
      'vFileName': fileName,
      'vFolder': folder
    }, refreshALL);
    if (!(parseInt($('#boxId').val()) > 0)) {
      $("#fundForm").trigger("reset");
    }
  } else {
    form.classList.add('was-validated');
  }
}

function saveExchange() {
  var form = KTUtil.getById('fundExchangeForm');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Fund-Diary-ExchangeSave",
      'nId': $('#fldExId').val(),
      'nType': $('#fldExType').val(),
      'nFBox': $('#lstFBox').val(),
      'nTBox': $('#lstTBox').val(),
      'nAccId': $('#fldExAccId').val(),
      'nCntrId': $('#fldExCntrId').val(),
      'nFCurn': $('#fldExFCurn').val(),
      'nTCurn': $('#fldExTCurn').val(),
      'dDate': $('#fldExDate').val(),
      'nFAmt': $('#fldExFAmt').val(),
      'nTAmt': $('#fldExTAmt').val(),
      'vRem': $('#fldExRem').val()
    }, refreshALL);
    if (!(parseInt($('#boxId').val()) > 0)) {
      $("#fundForm").trigger("reset");
    }
  } else {
    form.classList.add('was-validated');
  }
}

function refreshALL() {
  $("#fundForm").trigger("reset");
  refreshList($('#lstBox').val(), $('#diaryDate').val());
}

function refreshList(nBox, dDate, nType = 0) {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Fund-Diary-List",
      "nType": nType,
      "nBox": nBox,
      "dDate": dDate
    },
    success: function (response) {
      if (response.Status) {
        var vOCrd = 0;
        var vODeb = 0;
        var aTots = {};
        var vHtml = '';
        $('#diaryDate').val(response.Date);
        for (var i = 0; i < response.aBlncs.length; i++) {
          curn = response.aBlncs[i];
          aTots[curn.vCode] = {nOpen: parseFloat(curn.nOpen), tCrd: 0, tDeb: 0};
          if (Math.abs(parseFloat(curn.nOpen)) !== 0) {
            if (parseFloat(curn.nOpen) >= 0) {
              vOCrd = Math.abs(parseFloat(curn.nOpen));
            } else {
              vODeb = Math.abs(parseFloat(curn.nOpen));
            }
            vHtml += '<tr class="bg-light p-0 font-weight-bold" style="font-size: 1.4rem;">';
            vHtml += '<td></td>';
            vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(vOCrd) + '</td>';
            vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(vODeb) + '</td>';
            vHtml += '<td class="font-weight-bolder p-1">' + curn.vCode + '</td>';
            vHtml += '<td class="font-weight-bolder p-1" colspan="3">' + getLabel('Open.Balance') + '</td>';
            vHtml += '</tr>';
          }
        }
        if (response.Date !== '') {
          aData = response.Data;
          for (var i = 0; i < aData.length; i++) {
            var row = aData[i];
            if (!aTots.hasOwnProperty(row.CCode)) {
              aTots[row.CCode] = {nOpen: 0, tCrd: 0, tDeb: 0};
            }
            vHtml += '<tr style="font-size: 1.3rem;">';
            vHtml += '<td class="p-1">';

            vHtml += '<div class="dropdown">';
            vHtml += '  <button class="btn btn-success dropdown-toggle p-2" type="button" id="dropdown' + i + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            vHtml += '    <i class="la la-flash"></i>';
            vHtml += '  </button>';
            vHtml += '  <div class="dropdown-menu" aria-labelledby="dropdown' + i + '">';
            vHtml += '    <a class="dropdown-item fund-edit" href="javascript:;" data-rid="' + i + '"><i class="icon-lg la la-pencil"/>&nbsp;&nbsp;' + getLabel('Edit') + '</a>';
            vHtml += '    <a class="dropdown-item fund-print" href="javascript:;" data-rid="' + row.Id + '" data-ptype="0"><i class="icon-lg la la-print"/>&nbsp;&nbsp;' + getLabel('Print') + '&nbsp;&nbsp;' + (row.Print > 0 ? row.Print : '') + '</a>';
            vHtml += '    <a class="dropdown-item fund-whats" href="javascript:;" data-rid="' + row.Id + '" data-ptype="0"><i class="icon-lg fab fa-whatsapp"/>&nbsp;&nbsp;' + getLabel('WhatsApp') + '&nbsp;&nbsp;</a>';
            vHtml += '    <a class="dropdown-item fund-delete" href="javascript:;" data-rid="' + i + '"><i class="icon-lg la la-trash-o"/>&nbsp;&nbsp;' + getLabel('Delete') + '</a>';
            vHtml += '  </div>';
            vHtml += '</div>';

            vHtml += '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + decimalFormat(parseFloat(row.Crd)) + '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + decimalFormat(parseFloat(row.Deb)) + '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + row.CCode + '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + row.AName + '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + row.Rem + '</td>';
            vHtml += '<td class="font-weight-bold p-1">' + row.CName + '</td>';
            vHtml += '</tr>';
            aTots[row.CCode].tCrd += row.Crd;
            aTots[row.CCode].tDeb += row.Deb;
          }
        }
        for (var tCurn in aTots) {
          vHtml += '<tr class="bg-light p-0 font-weight-bold" style="font-size: 1.4rem;">';
          vHtml += '<td></td>';
          vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(aTots[tCurn].tCrd) + '</td>';
          vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(aTots[tCurn].tDeb) + '</td>';
          vHtml += '<td class="font-weight-bolder p-1">' + tCurn + '</td>';
          vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(aTots[tCurn].nOpen) + '</td>';
          vHtml += '<td class="font-weight-bolder p-1">' + decimalFormat(aTots[tCurn].nOpen + aTots[tCurn].tCrd - aTots[tCurn].tDeb) + '</td>';
          vHtml += '<td class="font-weight-bolder p-1"></td>';
          vHtml += '</tr>';
        }
        $("#ListDataTable tbody").html(vHtml);
        refreshButtonEvents();
      }
    }
  });
}

function refreshButtonEvents() {
  $('.fund-edit').off('click').on('click', function () {
    openEdit(parseInt($(this).data('rid')));
  });
  $('.fund-print').off('click').on('click', function () {
    $.redirect(encodeURI(PhSettings.rootPath + 'Portal/' + PhSettings.copy + '/fundPrint/' + $(this).data('rid') + '|' + $(this).data('ptype')), {}, 'POST', '_BLANK');
  });
  $('.fund-whats').off('click').on('click', function () {
    var vWhatsapp = 'https://api.whatsapp.com/send?text=';
    vWhatsapp += encodeURI(getLabel('we register a Receipt on your account') + String.fromCharCode(13) + HOST_URL + 'Portal/' + PhSettings.copy + '/fundPrint/' + $(this).data('rid') + '|' + $(this).data('ptype'));
    window.open(vWhatsapp);
  });
  $('.fund-delete').off('click').on('click', function () {
    var nIdx = parseInt($(this).data('rid'));
    var vMessage = aData[nIdx].Crd + ', ' + aData[nIdx].Deb + ', ' + aData[nIdx].AName + ', ' + aData[nIdx].CCode + ', ' + aData[nIdx].CName;
    PhUtility.doDelete(vMessage, {
      'vOperation': "cpy-Fund-Diary-Delete",
      'nId': aData[nIdx].Id
    }, refreshALL, true);
  });
}