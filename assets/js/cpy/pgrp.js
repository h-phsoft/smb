/* global PhSettings, PhUtility, swal, KTUtil */
var table;
var aPerms = ['isOK', 'Insert', 'Update', 'Delete', 'Query', 'Print', 'Commit', 'Revoke', 'Export', 'Import', 'Special'];
jQuery(document).ready(function () {
  $('#ph_add').on('click', function () {
    $('#editId').val(0);
    $('#editName').val('');
    $('#editModal').modal('show');
  });

  $('#ph_edit').on('click', function () {
    $('#editId').val($('#lstPGrp').val());
    $('#editName').val($('#lstPGrp option:selected').text());
    $('#editModal').modal('show');
  });

  $('#ph_delete').on('click', function () {
    var nId = $('#lstPGrp').val();
    var vName = $('#lstPGrp option:selected').text();
    PhUtility.doDelete(vName, {"vOperation": "cpy-Copy-PGrp-Delete", "nId": nId});
  });

  $('#lstPGrp').on('change', function () {
    refreshList();
  });

  $('#ph_edit_submit').on('click', function () {
    save();
  });

  refreshList();
});

function save() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-PGrp-Save",
      "nId": $('#editId').val(),
      "vName": $('#editName').val()
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          swal.fire({
            text: getLabel('Updated succsessfully'),
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            location.reload();
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
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

function refreshList() {
  var nId = $('#lstPGrp').val();
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-PGrp-ListPermissions",
      "nId": nId
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          table = new Tabulator("#tabulatorTable", {
            layout: "fitColumns",
            cellVertAlign: "middle",
            variableHeight: true,
            data: res.Data,
            columns: [
              {title: getLabel('isOK'),
                field: "isOK",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('isOK') + '<br/><input type="checkbox" class="toggle-all" data-perm="0"/>';
                }
              },
              {title: getLabel('Name'),
                field: "Name",
                width: "40%",
                hozAlign: "left",
                headerFilter: "input"
              },
              {title: getLabel('Insert'),
                field: "Insert",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Insert') + '<br/><input type="checkbox" class="toggle-all" data-perm="1"/>';
                }
              },
              {title: getLabel('Update'),
                field: "Update",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Update') + '<br/><input type="checkbox" class="toggle-all" data-perm="2"/>';
                }
              },
              {title: getLabel('Delete'),
                field: "Delete",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Delete') + '<br/><input type="checkbox" class="toggle-all" data-perm="3"/>';
                }
              },
              {title: getLabel('Query'),
                field: "Query",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Query') + '<br/><input type="checkbox" class="toggle-all" data-perm="4"/>';
                }
              },
              {title: getLabel('Print'),
                field: "Print",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Print') + '<br/><input type="checkbox" class="toggle-all" data-perm="5"/>';
                }
              },
              {title: getLabel('Commit'),
                field: "Commit",
                width: "6%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Commit') + '<br/><input type="checkbox" class="toggle-all" data-perm="6"/>';
                }
              },
              {title: getLabel('Revoke'),
                field: "Revoke",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                editor: true,
                formatter: "tickCross",
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Revoke') + '<br/><input type="checkbox" class="toggle-all" data-perm="7"/>';
                }
              },
              {title: getLabel('Export'),
                field: "Export",
                width: "6%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Export') + '<br/><input type="checkbox" class="toggle-all" data-perm="8"/>';
                }
              },
              {title: getLabel('Import'),
                field: "Import",
                width: "5%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                editor: true,
                formatter: "tickCross",
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Import') + '<br/><input type="checkbox" class="toggle-all" data-perm="9"/>';
                }
              },
              {title: getLabel('Special'),
                field: "Special",
                width: "6%",
                hozAlign: "center",
                headerSort: false,
                cssClass: 'text-center',
                formatter: "tickCross",
                editor: true,
                cellEdited: celPermissionEdited,
                titleFormatter: function (cell, formatterParams, onRendered) {
                  return getLabel('Special') + '<br/><input type="checkbox" class="toggle-all" data-perm="10"/>';
                }
              }
            ]
          });
          window.addEventListener('resize', function () {
            table.redraw(true);
          });
          $('.toggle-all').on('click', function () {
            toggleAll($(this));
          });
        } else {
          swal.fire({
            text: res.Message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-primary"
          }).then(function () {
            KTUtil.scrollTop();
          });
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

function celPermissionEdited(cell) {
  var data = cell.getData();
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-PGrp-UpdatePermission",
      "nId": data.Id,
      "isOK": (data.isOK ? 1 : 0),
      "ins": (data.Insert ? 1 : 0),
      "upd": (data.Update ? 1 : 0),
      "del": (data.Delete ? 1 : 0),
      "qry": (data.Query ? 1 : 0),
      "prt": (data.Print ? 1 : 0),
      "cmt": (data.Commit ? 1 : 0),
      "rvk": (data.Revoke ? 1 : 0),
      "exp": (data.Export ? 1 : 0),
      "imp": (data.Import ? 1 : 0),
      "spc": (data.Special ? 1 : 0)
    },
    success: function () {
    }
  });
}

function toggleAll($Perm) {
  var nPerm = parseInt($Perm.data('perm'));
  var newPerm = $Perm.prop('checked') ? 1 : 0;
  var rows = table.getRows('active');
  var data;
  var dataToSend = [];
  var nIdx = 0;
  rows.forEach(function (row) {
    data = row.getData();
    if (data[aPerms[nPerm]] !== newPerm) {
      data[aPerms[nPerm]] = newPerm;
      dataToSend[nIdx] = {
        "nId": data.Id,
        "isOK": (data.isOK ? 1 : 0),
        "ins": (data.Insert ? 1 : 0),
        "upd": (data.Update ? 1 : 0),
        "del": (data.Delete ? 1 : 0),
        "qry": (data.Query ? 1 : 0),
        "prt": (data.Print ? 1 : 0),
        "cmt": (data.Commit ? 1 : 0),
        "rvk": (data.Revoke ? 1 : 0),
        "exp": (data.Export ? 1 : 0),
        "imp": (data.Import ? 1 : 0),
        "spc": (data.Special ? 1 : 0)
      };
      nIdx++;
    }
  });
  if (nIdx > 0) {
    table.redraw(true);
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Copy-PGrp-UpdatePermissions",
        "permissions": dataToSend
      },
      success: function () {
      }
    });
  }
}
