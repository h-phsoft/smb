/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */
jQuery(document).ready(function () {
  $('#ph_refresh').on('click', function () {
    rebuildTree();
  });
  $('#ph_add').on('click', function () {
    openNew();
  });
  $('#ph_submit').on('click', function () {
    save();
  });
  $('#ph_delete').on('click', function () {
    deleteAccount();
  });
  $('#fldFilter').on('keyup', function () {
    setTimeout(function () {
      $('#treeView').jstree(true).search($('#fldFilter').val());
    }, 250);
  });
  buildTree();
});

function openNew() {
  var nId = parseInt($('#fldId').val());
  var vNum = $('#fldNum').val();
  var nType = $('#fldType').val();
  $('#fldId').val('');
  $('#fldNum').val('');
  $('#fldName').val('');
  $('#fldType').val(2);
  $('#fldType').change();
  $('#fldStatus').val(1);
  $('#fldStatus').change();
  $('#fldDbCr').val(1);
  $('#fldDbCr').change();
  $('#fldClose').val($('#fldClose option:first').val());
  $('#fldClose').change();
  $('#fldRem').val('');
  if (nId > 0) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Account-Accounts-NewAccount",
        "nId": nId,
        "vNum": vNum,
        "nType": nType
      },
      success: function (response) {
        try {
          if (response.Status) {
            $('#fldNum').val(response.NewNum);
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
            confirmButtonText: getLabel('OK'),
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

function save() {
  var form = KTUtil.getById('ph_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      'vOperation': "cpy-Account-Accounts-AccountSave",
      'nId': $('#fldId').val(),
      'vNum': $('#fldNum').val(),
      'vName': $('#fldName').val(),
      'vRem': $('#fldRem').val(),
      'nType': $('#fldType').val(),
      'nStatus': $('#fldStatus').val(),
      'nDbCr': $('#fldDbCr').val(),
      'nClose': $('#fldClose').val()
    }, rebuildTree);
  } else {
    form.classList.add('was-validated');
  }
}

function deleteAccount() {
  PhUtility.doDelete($('#fldName').val(), {"vOperation": "cpy-Account-Accounts-AccountDelete", "nId": $('#fldId').val()}, rebuildTree);
}

function rebuildTree() {
  $('#formStatus').text(getLabel('Please Wait'));
  $('#loader').html('<img src="' + PhSettings.rootPath + 'assets/media/loaders/loader203.gif" width="80%" height="80%">');
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Account-Accounts-RefreshTree"
    },
    success: function (response) {
      try {
        if (response.Status) {
          $('#formStatus').text('');
          $('#loader').html('');
          refreshTree();
        }
      } catch (ex) {
      }
    },
    error: function (response) {
    }
  });
}
function buildTree() {
  $("#treeView").jstree({
    "core": {
      "themes": {
        "responsive": false
      },
      // so that create works
      "check_callback": true
    },
    "types": {
      "default": {
        "icon": "fa fa-file text-success"
      },
      "1": {
        "icon": "fa fa-folder text-warning"
      },
      "2": {
        "icon": "fa fa-file text-success"
      }
    },
    "contextmenu": {
      "items": function ($node) {
        var tree = $("#tree").jstree(true);
        var menu = '';
        if (parseInt($node.data.TypeId) === 2) {
          menu = {
            "AccountCard": {
              "separator_before": false,
              "separator_after": false,
              "label": getLabel('General Ledger'),
              "action": function (obj) {
                $.redirect(PhSettings.copyRootPath + "acc/qry/generalLedger", {'RelId': $node.data.Id, 'RelText': $node.text}, 'POST', '_BLANK');
              }
            }
          };
        }
        return menu;
      }
    },
    "state": {
      "key": "acc"
    },
    "plugins": ["contextmenu", "state", "types", "search"]
  }).on("changed.jstree", function (e, jsdata) {
    if (jsdata.selected.length) {
      var data = jsdata.instance.get_node(jsdata.selected[0]).data;
      $('#fldId').val(data.Id);
      $('#fldNum').val(data.Num);
      $('#fldName').val(data.Name);
      $('#fldType').val(data.TypeId);
      $('#fldType').change();
      $('#fldStatus').val(data.StatusId);
      $('#fldStatus').change();
      $('#fldRem').val(data.Rem);
    }
  });
  refreshTree();
}
function refreshTree() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Account-Accounts-ListTree"
    },
    success: function (response) {
      try {
        if (response.Status) {
          $('#treeView').jstree(true).settings.core.data = response.Data;
          $('#treeView').jstree(true).refresh();
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
          confirmButtonText: getLabel('OK'),
          confirmButtonClass: "btn font-weight-bold btn-light-primary"
        }).then(function () {
          KTUtil.scrollTop();
        });
      } catch (ex) {
      }
    }
  });
}

