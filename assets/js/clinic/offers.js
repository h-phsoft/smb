/* global PhSettings, PhUtility, KTUtil, swal */
var table;
var catProcs;
jQuery(document).ready(function () {

  $('#ph_add').on('click', function () {
    openAdd();
  });
  $('#ph_Offer_submit').on('click', function () {
    save();
  });
  $('#offerCat').on('change', function () {
    getCatProcedures();
  });
  $('#offerProcedure').on('change', function () {
    getProcPrice();
  });
  $('#ph_offferAddProc').on('click', function () {
    offerProcSave();
  });

  refreshList();

});

function refreshList() {
  $('#editId').val(0);
  $('#editName').val('');
  $('#editSDate').val('');
  $('#editEDate').val('');
  $('#editStatus').val($("#editStatus option:first").val());
  $('#editStatus').change();
  $('#editDesc').val('');
  var aContextMenu = [];
  aContextMenu[0] = {label: '<i class="icon-md text-danger fas fa-play"></i> Make Current Active Offer',
    action: function (e, cell) {
      var data = cell.getData();
      var nId = data.Id;
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Clinic-Offer-MakeCurrent",
          "nId": nId
        },
        success: function (response) {
          try {
            var res = response;
            if (res.Status) {
              location.reload();
            } else {
            }
          } catch (ex) {
          }
        },
        error: function (response) {
          try {
          } catch (ex) {
          }
        }
      });
    }
  };
  aContextMenu[1] = {label: '<i class="icon-md text-danger fas fa-unlink"></i> Stop Offers',
    action: function (e, cell) {
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Clinic-Offer-MakeCurrent",
          "nId": 0
        },
        success: function (response) {
          try {
            var res = response;
            if (res.Status) {
              location.reload();
            } else {
            }
          } catch (ex) {
          }
        }
      });
    }
  };
  var aColumns = [];
  var nIdx = 0;
  if (parseInt(PhSettings.current.update) === 1) {
    aColumns[nIdx++] = {
      title: "",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.editButton();
      },
      cellClick: cellEditClick
    };
    aColumns[nIdx++] = {
      title: "",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.procsButton();
      },
      cellClick: cellProcClick
    };
  }
  aColumns[nIdx++] = {
    title: "",
    field: "",
    width: "2%",
    headerSort: false,
    headerFilter: "input",
    formatter: function (cell, formatterParams) {
      var data = cell.getData();
      var vActive = '';
      if (data.nActive === 1) {
        vActive = '<span><i class="icon-md text-danger fas fa-play"></i></span>';
      }
      return vActive;
    },
    contextMenu: aContextMenu
  };
  aColumns[nIdx++] = {
    title: "Offer",
    field: "Name",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Status",
    field: "StatusName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Start",
    field: "SDate",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "End",
    field: "EDate",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Description",
    field: "Description",
    width: "10%",
    hozAlign: "right",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Clinics",
    field: "vClincs",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Added",
    field: "IName",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Modified",
    field: "UName",
    width: "10%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  if (parseInt(PhSettings.current.delete) === 1) {
    aColumns[nIdx++] = {title: "",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator("cpy-Clinic-Offer-ListOffers", aColumns);
}

function openAdd() {
  $('#offerId').val(0);
  $('#offerName').val('');
  $('#offerStatus').val($("#offerStatus option:first").val());
  $('#offerStatus').change();
  $('#offerDesc').val('');
  $('#offerFormModal').modal('show');
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#offerId').val(data.Id);
  $('#offerName').val(data.Name);
  $('#offerStatus').val(data.StatusId);
  $('#offerStatus').change();
  $('#offerSDate').val(data.SDate);
  $('#offerSDate').change();
  $('#offerEDate').val(data.EDate);
  $('#offerEDate').change();
  $('#offerDesc').val(data.Description);
  var aClinics = [];
  console.log(data.aClinics);
  console.log(data.aClinics.length);
  for (var i = 0; i < data.aClinics.length; i++) {
    console.log(i + ' ' + data.aClinics[i].Id);
    aClinics.push(data.aClinics[i].Id);
  }
  $('#offerClinics').val(aClinics);
  $("#offerClinics").change();
  $('#offerFormModal').modal('show');
}

function cellProcClick(e, cell) {
  var data = cell.getData();
  $('#offerId').val(data.Id);
  offerGetProcs();
  $('#offerProcsFormModal').modal('show');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete('Payment', {"vOperation": "cpy-Clinic-Offer-Delete", "id": data.Id}, refreshList);
}

function save() {
  var form = KTUtil.getById('ph_Offer_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    var clinics = $('#offerClinics option:selected');
    var aClinics = [];
    $(clinics).each(function (index, clinic) {
      aClinics.push([$(this).val()]);
    });
    PhUtility.doSave({
      "vOperation": "cpy-Clinic-Offer-Save",
      "id": $('#offerId').val(),
      "nStatusId": $('#offerStatus').val(),
      "dSDate": $('#offerSDate').val(),
      "dEDate": $('#offerEDate').val(),
      "vName": $('#offerName').val(),
      "vDesc": $('#offerDesc').val(),
      "aClinics": aClinics
    }, refreshList);
  } else {
    form.classList.add('was-validated');
  }
}

function getCatProcedures() {
  var nCat = parseInt($('#offerCat').val());
  if (nCat > 0) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Clinic-Procedure-getCategoryProcedures",
        "nId": nCat
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            if (Array.isArray(res.Data)) {
              catProcs = res.Data;
              var vProcOptions = '<option selected value="-1">Please Select</option>';
              for (var i = 0; i < res.Data.length; i++) {
                var proc = catProcs[i];
                vProcOptions += '<option value="' + i + '">' + proc.Name + '</option>';
              }
              $('#offerProcedure').empty().append(vProcOptions);
              $('#offerProcedure').selectpicker('refresh');
              $('#offerProcedure').change();
            }
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
            confirmButtonText: "OK",
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

function getProcPrice() {
  var nIdx = $('#offerProcedure').val();
  if (nIdx >= 0) {
    var proc = catProcs[nIdx];
    $('#offerProcPrice').val(proc.Price);
  }
}

function offerGetProcs(response) {
  var nOffer = $('#offerId').val();
  $('#offerProcPrice').val(0);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Clinic-Offer-Procedure-ListProcedures",
      "nOId": nOffer
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          if (Array.isArray(res.Data.data)) {
            var vProcHtml = '';
            var proc;
            vProcHtml += '<table class="table table-striped table-bordered my-0 w-100">';
            vProcHtml += '<tbody>';
            for (var i = 0; i < res.Data.data.length; i++) {
              proc = res.Data.data[i];
              vProcHtml += '<tr>';
              if (PhSettings.current.Del) {
                vProcHtml += '<td style="width: 5%;">' + PhUtility.deleteIdButton(proc.Id, 'delete-offer-procedure') + '</td>';
              }
              vProcHtml += '<td style="width: 15%;">' + proc.IDate + '</td>';
              vProcHtml += '<td style="width: 70%;">' + proc.CatName + ' - ' + proc.ProcedureName + '</td>';
              vProcHtml += '<td style="width: 10%;" class="text-right">' + Math.round(proc.Price, 0) + '</td>';
              vProcHtml += '</tr>';
            }
            vProcHtml += '</tbody>';
            vProcHtml += '</table>';
            $('#offerProcs').html(vProcHtml);
            if (PhSettings.current.Del) {
              $('.delete-offer-procedure').unbind('click').on('click', function () {
                deleteOfferProcedure($(this).data('id'));
              });
            }
          }
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
          confirmButtonText: "OK",
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}

function offerProcSave() {
  var nOffer = parseInt($('#offerId').val());
  var nCat = parseInt($('#offerCat').val());
  if (nOffer > 0 && nCat > 0) {
    var proc = catProcs[$('#offerProcedure').val()];
    PhUtility.doSave({
      "vOperation": "cpy-Clinic-Offer-Procedure-Save",
      "nOId": nOffer,
      "nProcId": proc.Id,
      "nPrice": parseFloat($('#offerProcPrice').val())
    }, offerGetProcs, false);
  }
}

function deleteOfferProcedure(nId) {
  if (PhSettings.current.delete) {
    PhUtility.doDelete('Procedure', {"vOperation": "cpy-Clinic-Offer-Procedure-Delete", "id": nId}, offerGetProcs, false);
  }
}
