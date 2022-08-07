/* global KTAppSettings, KTUtil, swal, FormValidation, PhSettings, Intl, Notification, toastr */

"use strict";
var catProcs;
var integerFormat = function (nValue) {
  return (new Intl.NumberFormat('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(nValue));
};
var decimalFormat = function (nValue) {
  return (new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(nValue));
};
function currentTime() {
  return formatDate(new Date(), 'hh:ii');
}
function currentDate() {
  return formatDate(new Date(), 'YY-mm-dd');
}
function currentDateTime() {
  return formatDate(new Date(), 'YY-mm-dd hh:ii');
}
function formatDate(date, format) {
  const map = {
    mm: String(date.getMonth() + 1).padStart(2, '0'),
    dd: String(date.getDate()).padStart(2, '0'),
    yy: date.getFullYear().toString().slice(-2),
    YY: date.getFullYear(),
    hh: String(date.getHours()).padStart(2, '0'),
    ii: String(date.getMinutes()).padStart(2, '0'),
    ss: String(date.getSeconds()).padStart(2, '0')
  };
  return format.replace(/mm|dd|yy|yyyy|hh|ii|ss/gi, matched => map[matched]);
}
function getNear15Minute() {
  var dDate = new Date();
  var minutes = dDate.getMinutes();
  var nRet = 45;
  if (minutes <= 15) {
    nRet = 0;
  } else if (minutes <= 30) {
    nRet = 15;
  } else if (minutes <= 45) {
    nRet = 30;
  }
  return nRet;
}

var PhIDGenerator = function () {
  var nLastId = (Math.floor(Math.random() * 999) + 100) + Date.now();
  this.genId = function () {
    return nLastId++;
  };
};
function prepareArabiNumber(vNumber) {
  vNumber = vNumber.replace(/\s/g, '');
  var nn = "";
  for (var i = 1; i < 10; i++) {
    var x = vNumber.charAt(vNumber.length - i);
    switch (x) {
      case "٠":
        x = "0";
        break;
      case "١":
        x = "1";
        break;
      case "٢":
        x = "2";
        break;
      case "٣":
        x = "3";
        break;
      case "٤":
        x = "4";
        break;
      case "٥":
        x = "5";
        break;
      case "٦":
        x = "6";
        break;
      case "٧":
        x = "7";
        break;
      case "٨":
        x = "8";
        break;
      case "٩":
        x = "9";
        break;
    }
    nn = nn + x;
  }
  var w = "0";
  for (var y = 1; y < 10; y++) {
    var o = nn.charAt(nn.length - y);
    w = w + o;
  }
  return w;
}
var PhIdGen = new PhIDGenerator();
var PhTabulatorLocale = {
  "ar": {
    "columns": {
      "name": "Name" //replace the title of column name with the value "Name"
    },
    "ajax": {
      "loading": "يرجى الإنتظار", //ajax loader text
      "error": "خطأ" //ajax error text
    },
    "groups": {//copy for the auto generated item count in group header
      "item": "item", //the singular  for item
      "items": "items" //the plural for items
    },
    "pagination": {
      "page_size": "", //label for the page size select element
      "page_title": "", //tooltip text for the numeric page button, appears in front of the page number (eg. "Show Page" will result in a tool tip of "Show Page 1" on the page 1 button)
      "first": "|<", //text for the first page button
      "first_title": "الأول", //tooltip text for the first page button
      "last": ">|",
      "last_title": "الأخير",
      "prev": "<",
      "prev_title": "السابق",
      "next": ">",
      "next_title": "التالي",
      "all": "الكل"
    },
    "headerFilters": {
      "default": "الفلتر", //default header filter placeholder text
      "columns": {
        "name": "filter name..." //replace default header filter text for column name
      }
    }
  },
  "en": {
    "columns": {
      "name": "Name" //replace the title of column name with the value "Name"
    },
    "ajax": {
      "loading": "Please Wait...", //ajax loader text
      "error": "Erro" //ajax error text
    },
    "groups": {//copy for the auto generated item count in group header
      "item": "item", //the singular  for item
      "items": "items" //the plural for items
    },
    "pagination": {
      "page_size": "", //label for the page size select element
      "page_title": "", //tooltip text for the numeric page button, appears in front of the page number (eg. "Show Page" will result in a tool tip of "Show Page 1" on the page 1 button)
      "first": "|<", //text for the first page button
      "first_title": "First", //tooltip text for the first page button
      "last": ">|",
      "last_title": "Last",
      "prev": "<",
      "prev_title": "Previous",
      "next": ">",
      "next_title": "Next",
      "all": "All"
    },
    "headerFilters": {
      "default": "Filter", //default header filter placeholder text
      "columns": {
        "name": "filter name..." //replace default header filter text for column name
      }
    }
  }
};
function isValidEmail(vEmail) {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w+([\.-]?\w+))+$/;
  return vEmail.match(mailformat);
}
function getPref(vKey) {
  var vRet = '';
  if (PhSettings['Prefs'][vKey.toLowerCase()] !== undefined) {
    vRet = PhSettings['Prefs'][vKey.toLowerCase()];
  }
  return (vRet);
}
function getLabel(vKey) {
  var vRet = vKey;
  if (PhSettings['labels'][vKey.toLowerCase()] !== undefined) {
    vRet = PhSettings['labels'][vKey.toLowerCase()];
  }
  return (vRet);
}
var PhUtility = function () {
  var settings = {
    'uid': 999,
    'utype': 999
  };
  var statusFormatter = function (nValue, vLabel) {
    return '<span class="label label-lg font-weight-bold label-light-' + (nValue === 1 ? 'success' : 'danger') + ' label-inline">' + vLabel + '</span>';
  };
  var executeButton = function (e) {
    return '<span class="btn btn-sm btn-light-warning font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Get') + '" data-original-title="' + getLabel('Get') + '"><i class="icon-md la la-flash"></i></span>';
  };
  var viewButton = function (e) {
    return '<span class="btn btn-sm btn-info font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('View') + '" data-original-title="' + getLabel('View') + '"><i class="icon-md text-light flaticon-eye"></i></span>';
  };
  var printButton = function (e) {
    return '<span class="btn btn-sm btn-success font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Print') + '" data-original-title="' + getLabel('Print') + '"><i class="icon-md text-light flaticon2-print"></i></span>';
  };
  var printLightButton = function (e) {
    return '<span class="btn btn-sm btn-light-success font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Print') + '" data-original-title="' + getLabel('Print') + '"><i class="icon-md text-light flaticon2-print"></i></span>';
  };
  var editButton = function (e) {
    return '<span class="btn btn-sm btn-primary font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Edit') + '" data-original-title="' + getLabel('Edit') + '"><i class="icon-md text-light flaticon2-edit"></i></span>';
  };
  var editLightButton = function (e) {
    return '<span class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Edit') + '" data-original-title="' + getLabel('Edit') + '"><i class="icon-md text-light flaticon2-edit"></i></span>';
  };
  var taskButton = function (e) {
    return '<span class="btn btn-sm btn-info font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Task') + '" data-original-title="' + getLabel('Task') + '"><i class="icon-md text-light fas fa-tasks"></i></span>';
  };
  var resetButton = function (e) {
    return '<span class="btn btn-sm btn-warning font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Reset Password') + '" data-original-title="' + getLabel('Reset Password') + '"><i class="icon-md fas fa-key"></i></span>';
  };
  var deleteButton = function (e) {
    return '<span class="btn btn-sm btn-danger font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Delete') + '" data-original-title="' + getLabel('Delete') + '"><i class="icon-md text-light flaticon-delete"></i></span>';
  };
  var deleteLightButton = function (e) {
    return '<span class="btn btn-sm btn-light-danger font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Delete') + '" data-original-title="' + getLabel('Delete') + '"><i class="icon-md text-light flaticon-delete"></i></span>';
  };
  var deleteIdButton = function (nId, vClass = "delete-button") {
    return '<span class="btn btn-sm btn-danger ' + vClass + ' font-weight-bolder text-uppercase pl-2 pr-1" data-toggle="tooltip" title="' + getLabel('Delete') + '" data-original-title="' + getLabel('Delete') + '" data-id="' + nId + '"><i class="icon-md text-light flaticon-delete"></i></span>';
  };
  var doDelete = function (vName, data, callback, showMessages = true, reloadPage = true) {
    data.progId = PhSettings.progId;
    data.vCDId = PhSettings.CDId;
    data.vGUId = PhSettings.GUId;
    swal.fire({
      title: getLabel('Are you sure ?'),
      text: vName,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "<i class='flaticon2-check-mark'></i> " + getLabel('Yes, Delete It'),
      cancelButtonText: "<i class='flaticon2-cross'></i> " + getLabel('No, Cancel'),
      reverseButtons: true,
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-default"
      }
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: 'POST',
          async: false,
          url: PhSettings.serviceURL,
          data: data,
          success: function (response) {
            try {
              var res = response;
              if (res.Status) {
                if (showMessages) {
                  swal.fire({
                    text: "Deleted succsessfully",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    confirmButtonClass: "btn font-weight-bold btn-light-primary"
                  }).then(function () {
                    if (typeof callback === "function") {
                      callback(response);
                    } else {
                      if (reloadPage) {
                        location.reload();
                      }
                    }
                  });
                } else {
                  if (typeof callback === "function") {
                    callback(response);
                  } else {
                    if (reloadPage) {
                      location.reload();
                    }
                  }
                }
              } else {
                if (showMessages) {
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
              }
            } catch (ex) {
            }
          },
          error: function (response) {
            try {
              var res = JSON.parse(response);
              if (showMessages) {
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
          }
        });
      } else if (result.dismiss === "cancel") {

      }
    });
  };
  var doSave = function (data, callback, showMessages = true, reloadPage = true) {
    data.progId = PhSettings.progId;
    data.vCDId = PhSettings.CDId;
    data.vGUId = PhSettings.GUId;
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: data,
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            if (showMessages) {
              swal.fire({
                text: "Updated succsessfully",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                confirmButtonClass: "btn font-weight-bold btn-light-primary"
              }).then(function () {
                if (typeof callback === "function") {
                  callback(response);
                } else {
                  if (reloadPage) {
                    location.reload();
                  }
                }
              });
            } else {
              if (typeof callback === "function") {
                callback(response);
              } else {
                if (reloadPage) {
                  location.reload();
                }
              }
            }
          } else {
            if (showMessages) {
              swal.fire({
                text: res.Message,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: getLabel('OK'),
                confirmButtonClass: "btn font-weight-bold btn-light-warning"
              }).then(function () {
                KTUtil.scrollTop();
              });
            }
          }
        } catch (ex) {

        }
      },
      error: function (response) {
        try {
          //$('#debugMessage').html(response.responseText);
          var res = JSON.parse(response);
          if (showMessages) {
            swal.fire({
              text: res.Message,
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: getLabel('OK'),
              confirmButtonClass: "btn font-weight-bold btn-light-warning"
            }).then(function () {
              KTUtil.scrollTop();
            });
          }
        } catch (ex) {

        }
      }
    });
  };
  var doSaveWithAttache = function (fileField, folder, data, callback, showMessages = true, reloadPage = true) {
    var $fileField = $('#' + fileField);
    var vBase64 = $('#' + $fileField.data('relfld')).val();
    var nPos = vBase64.indexOf(";base64,/");
    var type = vBase64.substr(0, nPos).substr(5).replace("_", "/");
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-AttachFile",
        'vFile': vBase64,
        'vFileName': $('#' + $fileField.data('relname')).val(),
        'vType': type,
        'vExt': $('#' + $fileField.data('relext')).val(),
        'vFolder': folder
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            data['vFilename'] = res.Filename;
            doSave(data, callback, showMessages, reloadPage);
          } else {
            if (showMessages) {
              swal.fire({
                text: res.Message,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: getLabel('OK'),
                confirmButtonClass: "btn font-weight-bold btn-light-warning"
              }).then(function () {
                KTUtil.scrollTop();
              });
            }
          }
        } catch (ex) {

        }
      },
      error: function (response) {
        if (showMessages) {
          swal.fire({
            text: response.responseText,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: getLabel('OK'),
            confirmButtonClass: "btn font-weight-bold btn-light-warning"
          }).then(function () {
            KTUtil.scrollTop();
          });
        }
      }
    });

  };
  var doSaveAttached = function (fileField) {
    var $fileField = $('#' + fileField);
    var $fileName = $('#' + $fileField.data('filename'));
    var folder = $fileField.data('folder');
    var vBase64 = $('#' + $fileField.data('relfld')).val();
    var nPos = vBase64.indexOf(";base64,/");
    var type = vBase64.substr(0, nPos).substr(5).replace("_", "/");
    $fileName.val('');
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-AttachFile",
        'vFile': vBase64,
        'vFileName': $('#' + $fileField.data('relname')).val(),
        'vType': type,
        'vExt': $('#' + $fileField.data('relext')).val(),
        'vFolder': folder
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            $fileName.val(res.Filename);
          } else {
            swal.fire({
              text: res.Message,
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: getLabel('OK'),
              confirmButtonClass: "btn font-weight-bold btn-light-warning"
            }).then(function () {
              KTUtil.scrollTop();
            });
          }
        } catch (ex) {

        }
      },
      error: function (response) {
        swal.fire({
          text: response.responseText,
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: getLabel('OK'),
          confirmButtonClass: "btn font-weight-bold btn-light-warning"
        }).then(function () {
          KTUtil.scrollTop();
        });
      }
    });

  };
  var isOk = function (vPerm = "permission") {

    return false;
  };
  var initApp = function (uSettings) {
    $.extend(settings, uSettings);
  };
  return {
    statusFormatter: statusFormatter,
    executeButton: executeButton,
    viewButton: viewButton,
    printButton: printButton,
    printLightButton: printLightButton,
    editButton: editButton,
    taskButton: taskButton,
    resetButton: resetButton,
    deleteButton: deleteButton,
    deleteLightButton: deleteLightButton,
    deleteIdButton: deleteIdButton,
    doDelete: doDelete,
    doSave: doSave,
    doSaveWithAttache: doSaveWithAttache,
    doSaveAttached: doSaveAttached,
    init: function () {
      initApp();
    }
  };
}();

function ph_ChangePassword_submit(e) {
  e.preventDefault();
  var validation;
  var form = KTUtil.getById('ph_ChangePassword_form');
  validation = FormValidation.formValidation(
    form,
    {
      fields: {
        opassword: {
          validators: {
            notEmpty: {
              message: getLabel('Currenct is required')
            }
          }
        },
        npassword: {
          validators: {
            notEmpty: {
              message: getLabel('new password is required')
            },
            stringLength: {
              min: 5,
              max: 50,
              message: getLabel('Password Length range 5 and 50')
            }
          }
        },
        vpassword: {
          validators: {
            notEmpty: {
              message: getLabel('The password confirmation is required')
            },
            stringLength: {
              min: 5,
              max: 50,
              message: getLabel('Password Length range 5 and 50')
            },
            identical: {
              compare: function () {
                return form.querySelector('[name="npassword"]').value;
              },
              message: getLabel('The password and its confirm are not the same')
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap()
      }
    }
  );
  validation.validate().then(function (status) {
    if (status === 'Valid') {
      var vOPassword = $('#opassword').val();
      var vNPassword = $('#npassword').val();
      var vVPassword = $('#vpassword').val();
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Copy-User-ChangePassword",
          "vOPassword": vOPassword,
          "vNPassword": vNPassword,
          "vVPassword": vVPassword
        },
        success: function (response) {
          try {
            var res = response;
            if (res.Status) {
              swal.fire({
                text: getLabel("Password changed succsessfully"),
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: getLabel("Ok"),
                confirmButtonClass: "btn font-weight-bold btn-light-primary"
              }).then(function () {
                $('#changePasswordModal').modal('hide');
              });
            } else {
              swal.fire({
                text: res.Message,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: getLabel('OK'),
                confirmButtonClass: "btn font-weight-bold btn-light-primary"
              }).then(function () {

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
              $('#changePasswordModal').modal('hide');
            });
          } catch (ex) {
          }
        }
      });
    } else {
      swal.fire({
        text: getLabel("Sorry, looks like there are some errors detected, please try again."),
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: getLabel('OK'),
        confirmButtonClass: "btn font-weight-bold btn-light"
      }).then(function () {

      });
    }
  });
}

function getAjaxTabulator(operation = "cpy-Item-ListItems", aColumns, containerId = "#tabulatorTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    height: "100%",
    cellVertAlign: "middle",
    pagination: "remote",
    paginationSize: 10,
    paginationSizeSelector: [10, 25, 50, 75, 100, true],
    ajaxFiltering: true,
    ajaxSorting: true,
    ajaxURL: PhSettings.serviceURL,
    ajaxParams: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": operation,
      "progId": PhSettings.progId
    },
    ajaxConfig: "post",
    ajaxResponse: function (url, params, response) {
      if (response.Status) {
        return response.Data;
      } else {
        return null;
      }
    },
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function ajaxQueryTabulatorAll(aColumns, aParams, containerId = "#tabulatorTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  aParams.progId = PhSettings.progId;
  aParams.vCDId = PhSettings.CDId;
  aParams.vGUId = PhSettings.GUId;
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    height: "70vh",
    cellVertAlign: "middle",
    ajaxFiltering: false,
    ajaxSorting: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxParams: aParams,
    ajaxConfig: "post",
    ajaxResponse: function (url, params, response) {
      if (response.Status) {
        return response.Data;
      } else {
        return null;
      }
    },
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function getAjaxTabulatorAllWithParams(aColumns, aParams, containerId = "#tabulatorTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  aParams.progId = PhSettings.progId;
  aParams.vCDId = PhSettings.CDId;
  aParams.vGUId = PhSettings.GUId;
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    height: "50vh",
    cellVertAlign: "middle",
    ajaxFiltering: false,
    ajaxSorting: false,
    ajaxURL: PhSettings.serviceURL,
    ajaxParams: aParams,
    ajaxConfig: "post",
    ajaxResponse: function (url, params, response) {
      if (response.Status) {
        return response.Data;
      } else {
        return null;
      }
    },
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function getAjaxTabulatorWithParams(aColumns, aParams, containerId = "#tabulatorTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  aParams.progId = PhSettings.progId;
  aParams.vCDId = PhSettings.CDId;
  aParams.vGUId = PhSettings.GUId;
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    height: "100%",
    cellVertAlign: "middle",
    pagination: "remote",
    paginationSize: 10,
    paginationButtonCount: 5,
    paginationSizeSelector: [10, 25, 50, 75, 100, true],
    ajaxFiltering: true,
    ajaxSorting: true,
    ajaxURL: PhSettings.serviceURL,
    ajaxParams: aParams,
    ajaxConfig: "post",
    ajaxResponse: function (url, params, response) {
      if (response.Status) {
        return response.Data;
      } else {
        return null;
      }
    },
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function getTabulator(aColumns, data, containerId = "#tabulatorTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    height: "100%",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    cellVertAlign: "middle",
    pagination: "local",
    paginationSize: 10,
    paginationSizeSelector: [10, 25, 50, 75, 100, true],
    rowDblClick: rowDblClick,
    rowDblTap: rowDblClick,
    cellDblClick: cellDblClick,
    cellDblTap: cellDblClick,
    data: data,
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function getTrnTabulator(aColumns, data, containerId = "#tabulatorTrnTable", direction = PhSettings.direction, locale = PhSettings.locale) {
  var table = new Tabulator(containerId, {
    layout: "fitColumns",
    width: "100%",
    height: "350",
    textDirection: direction,
    locale: true,
    langs: PhTabulatorLocale,
    cellVertAlign: "middle",
    variableHeight: true,
    data: data,
    columns: aColumns
  });
  table.setLocale(locale);
  return table;
}

function rowDblClick(e, row) {
  //var data = row.getData(); //get data object for row
  //var cell = row.getCell('Name');
  //cell.getElement().style.backgroundColor = "red"; //apply css change to row element
}

function cellDblClick(e, cell) {
  var value = cell.getValue();
  var field = cell.getField();
  //cell.getElement().style.backgroundColor = "red"; //apply css change to row element
}

function cellClick(e, cell) {
  var value = cell.getData().Id;
}

function ph_export(table, type, fileName) {
  if (table !== undefined) {
    switch (type) {
      case 1:
        table.download("csv", fileName + "_" + table.getPage() + "_" + PhIdGen.genId() + ".csv", { delimiter: ";", bom: true });
        break;
      case 2:
        table.download("xlsx", fileName + "_" + table.getPage() + "_" + PhIdGen.genId() + ".xlsx", { sheetName: "Inbounds" });
        break;
      case 3:
        table.download("pdf", fileName + "_" + table.getPage() + "_" + PhIdGen.genId() + ".pdf", {
          orientation: "l", //set page orientation to landscape
          title: "Report", //add title to report
          jsPDF: {
            unit: "mm", //set units to mm
            format: [420, 297] // A3
          },
          autoTable: function (doc) {
            //doc.addFont('assets/css/fonts/DroidKufi/DroidKufi-Regular.ttf');
            doc.setFont('sans-serif');
            doc.setFontSize(10);
            return {
              styles: {
                font: "sans-serif",
                fontStyle: "bold",
                fontSize: 10
              },
              theme: 'striped',
              margin: { top: 35 }
            };
          }
        });
        break;
    }
  }
}

function checkToken() {
  PhSettings.GUId = JSON.parse(localStorage.getItem(PhSettings.Copy));
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "phs-Security-getGUID"
    },
    success: function (response) {
      if (response.Status) {
        PhSettings.GUId = response.Data;
        localStorage.setItem(PhSettings.Copy, JSON.stringify(response.Data));
      }
    }
  });
}

function attacheFile() {
  $("body").on("change", ".fileField", function () {
    var acceptedFileSize = (1024 * 1024 * 1);
    var vPreviewer = $(this).data('previewer');
    var vRelField = $(this).data('relfld');
    var vNameField = $(this).data('relname');
    var vExtField = $(this).data('relext');
    var bFile = $(this)[0].files[0];
    var fSize = $(this)[0].files[0].size;
    if (bFile && fSize <= acceptedFileSize) {
      var fileReader = new FileReader();
      fileReader.addEventListener("load", function (e) {
        $('#' + vPreviewer).attr('src', e.target.result);
        $('#' + vRelField).val(e.target.result);
        $('#' + vNameField).val(bFile.name);
        $('#' + vExtField).val(bFile.name.substr(bFile.name.lastIndexOf('.') + 1));
      });
      fileReader.readAsDataURL(bFile);
    }
  });
}

function setAttacheFile(relField, vFileName) {
  var $fldFile = $('#' + relField);
  var vPreviewer = $fldFile.data('previewer');
  var vRelField = $fldFile.data('relfld');
  var vNameField = $fldFile.data('relname');
  var vExtField = $fldFile.data('relext');
  $('#' + vPreviewer).attr('src', vFileName);
  $('#' + vRelField).val(vFileName);
  $('#' + vNameField).val(vFileName);
  $('#' + vExtField).val(vFileName.substr(vFileName.lastIndexOf('.') + 1));
}

function clearAttache(relField) {
  var $fldFile = $('#' + relField);
  var vPreviewer = $fldFile.data('previewer');
  var vRelField = $fldFile.data('relfld');
  var vNameField = $fldFile.data('relname');
  var vExtField = $fldFile.data('relext');
  $('#' + vPreviewer).attr('src', '');
  $('#' + vRelField).val('');
  $('#' + vNameField).val('');
  $('#' + vExtField).val('');
}

function saveAttache(relField) {
  PhUtility.doSaveAttached(relField);
}

function base64_to_JSON(vBase64, fileExt, folder = '.') {
  var nPos = vBase64.indexOf(";base64,/");
  var type = vBase64.substr(0, nPos).substr(5).replace("_", "/");
  var parts = {};
  parts['vType'] = type;
  parts['vImage'] = vBase64.substr(nPos + 9);
  parts['vExt'] = fileExt;
  parts['vFolder'] = folder;
  return parts;
}

function emptySelect(vId) {
  $('#' + vId).html('<option value="0" SELECTED>' + getLabel('Please Select') + '</option>');
  $('#' + vId).selectpicker('refresh');

}

function phAutocomplete() {
  $('.phAutocomplete').each(function (i, el) {
    var $this = $(el);
    var vOperation = $this.data('acoperation');
    var vCallback = $this.data('callback');
    $this.autocomplete({
      source: function (request, response) {
        var oAjaxData = {};
        oAjaxData.vCopy = PhSettings.Copy;
        oAjaxData.vCDId = PhSettings.CDId;
        oAjaxData.vGUId = PhSettings.GUId;
        oAjaxData.vOperation = vOperation;
        oAjaxData.term = request.term;
        $.ajax({
          type: 'POST',
          async: false,
          url: PhSettings.serviceURL,
          data: oAjaxData,
          success: function (ajaxResponse) {
            response(ajaxResponse.Data);
          }
        });
      },
      minLength: 0,
      focus: function (event, ui) {
        return false;
      },
      select: function (event, ui) {
        $(this).val(ui.item.label);
        var vField = $(this).data('acrel');
        if (vField !== undefined) {
          $('#' + vField).val(ui.item.id);
          if (vCallback !== "") {
            if (typeof window[vCallback] === "function") {
              window[vCallback](event, ui);
            }
          }
        }
        return false;
      }
    });
  });
}

function getInfo() {
  var MyFullDate = new Date();
  var MyTimeString = MyFullDate.toTimeString();
  var MyOffset = MyTimeString.slice(12, 17);
  console.log('Browser', navigator.appName);
  console.log('Platform', navigator.userAgentData.platform);
  console.log('Language', navigator.language);
  console.log('fullDatetimeOpened', MyFullDate);
  console.log('timeOpened', MyTimeString);
  console.log('timezone', MyOffset);
}

jQuery(document).ready(function () {
  if (PhSettings.ds > 0 || PhSettings.rs > 0) {
    PhSettings.CDId = JSON.parse(localStorage.getItem(PhSettings.copy));
    if (typeof PhSettings.CDId === 'undefined' || PhSettings.CDId === null || PhSettings.CDId === 'null' || PhSettings.CDId === '') {
      $.redirect(PhSettings.copyRootPath + 'logout', { 'UName': 'Unregistered Copy' }, 'POST');
    }
  }
  attacheFile();
  $('.attache-clear').on('click', function () {
    clearAttache($(this).data('rfield'));
  });
  $('.attache-save').on('click', function () {
    saveAttache($(this).data('rfield'));
  });
  $('#ph_ChangePassword_submit').on('click', function (e) {
    ph_ChangePassword_submit(e);
  });
  phAutocomplete();
  initPhTApp();
  initToasts();
  //initNotification();
  $('#qrscaner').on('click', function (e) {
  });
  $('.modal-dialog').draggable({
    cursor: "move",
    handle: ".modal-header"
  });
  $('#ph_addPatient_submit').on('click', function (e) {
    addPatient();
  });
  $('#addAppointment').on('click', function () {
    openAddApointment();
  });
  $('#ph_addAppointment_submit').on('click', function (e) {
    addMainAppointment();
  });
  $('#addPayment').on('click', function () {
    openAddPayment();
  });
  $('#ph_payment_submit').on('click', function (e) {
    addMainPayment();
  });
  $('#treatCat').on('change', function () {
    getCategoryProcedures();
  });
  $('#lstProcedure').on('change', function () {
    getProcedurePrice();
  });
  $('#procQnt, #procPrice').on('keyup', function () {
    getUpdateAmt();
  });
  $('#ph_addProc').on('click', function () {
    procaAddTData();
  });
});

function initPhTApp() {
  var arrows;
  if (KTUtil.isRTL()) {
    arrows = {
      leftArrow: '<i class="la la-angle-right"></i>',
      rightArrow: '<i class="la la-angle-left"></i>'
    };
  } else {
    arrows = {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>'
    };
  }
  $('.ph_datepicker').datepicker({
    rtl: KTUtil.isRTL(),
    format: 'yyyy-mm-dd',
    startDate: '2000-01-01',
    todayBtn: 'linked',
    todayHighlight: true,
    showOnFocus: false,
    autoclose: true,
    forceParse: false,
    templates: arrows
  });
  $('.datepicker-btn').off('click').on('click', function () {
    $(this).prev('.ph_datepicker').datepicker('show');
  });
  $('.ph_timepicker').timepicker({
    rtl: KTUtil.isRTL(),
    format: "hh:ii",
    minuteStep: 1,
    autoclose: true,
    forceParse: false,
    showSeconds: false,
    showMeridian: false,
    snapToStep: true
  });
  $('.timepicker-btn').off('click').on('click', function () {
    $(this).prev('.ph_timepicker').timepicker('show');
  });
  $('.ph_datetimepicker').datetimepicker({
    rtl: KTUtil.isRTL(),
    showMeridian: false,
    todayHighlight: true,
    todayBtn: 'linked',
    autoclose: true,
    forceParse: false,
    showSeconds: false,
    snapToStep: true,
    pickerPosition: 'bottom-left'
  });
  $('.datetimepicker-btn').off('click').on('click', function () {
    $(this).prev('.ph_datetimepicker').datetimepicker('show');
  });

  $('.topbar-item-link').on('click', function () {
    var vModal = $(this).data('modal');
    if (vModal !== null && vModal !== '' && vModal !== undefined) {
      $('#' + vModal).modal('show');
    }
  });
  $('.change-language').on('click', function () {
    var vCCode = $('#current-language').data('code');
    var vCode = $(this).data('code');
    if (vCCode !== vCode) {
      PhSettings.GUId.vLang = vCode;
      PhSettings.GUId.vDir = $(this).data('dir');
      localStorage.setItem(PhSettings.copy + '_GUID', JSON.stringify(PhSettings.GUId));
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Copy-User-ChangeLanguage",
          "vLang": vCode
        },
        success: function (response) {
          if (response.Status) {
            location.reload();
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
  });
  $('.change-period').on('click', function () {
    var nCId = $('#current-period').data('id');
    var nId = $(this).data('id');
    if (nCId !== nId) {
      PhSettings.GUId.WPId = nId;
      localStorage.setItem(PhSettings.copy + '_GUID', JSON.stringify(PhSettings.GUId));
      $.ajax({
        type: 'POST',
        async: false,
        url: PhSettings.serviceURL,
        data: {
          "vCopy": PhSettings.copy,
          "vCDId": PhSettings.CDId,
          "vGUId": PhSettings.GUId,
          "vOperation": "cpy-Copy-User-ChangePeriod",
          "nId": nId
        },
        success: function (response) {
          if (response.Status) {
            location.reload();
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
  });
  $('.change-clinic').on('click', function () {
    var nId = parseInt($(this).data('id'));
    var vName = $(this).data('name');
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        'progId': PhSettings.progId,
        'vCDId': PhSettings.CDId,
        'vGUId': PhSettings.GUId,
        "vOperation": "cpy-Clinic-Main-ChangeClinic",
        "nCId": nId
      },
      success: function (response) {
        try {
          var res = response;
          if (res.Status) {
            $('.current-clininc').data('id', nId);
            $('.current-clininc').text(vName);
            location.reload();
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
  });
  $('.logout').on('click', function () {
    localStorage.removeItem(PhSettings.copy + '_GUID');
    $.redirect(PhSettings.copyRootPath + 'logout', {}, 'POST');
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        "vCopy": PhSettings.copy,
        "vCDId": PhSettings.CDId,
        "vGUId": PhSettings.GUId,
        "vOperation": "cpy-Copy-User-logout"
      },
      success: function (response) {
      },
      error: function (response) {
      }
    });
  });
}

function getNotifications() {
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      "vCopy": PhSettings.copy,
      "vCDId": PhSettings.CDId,
      "vGUId": PhSettings.GUId,
      "vOperation": "cpy-Copy-Notification-List",
      "nUId": PhSettings.uid
    },
    success: function (response) {
      if (response.Status) {
        for (var i = 0; i < response.Data.length; i++) {
          showNotification(response.Data[i].vTitle, response.Data[i].vBody, response.Data[i].vIcon);
          showToast('success', response.Data[i].vTitle, response.Data[i].vBody);
        }
      }
    },
    error: function (response) {
    }
  });
}

function showNotification(vTitle, vMessage, vIcon = 'logos/favicon.png') {
  if (Notification.permission === 'granted') {
    const notification = new Notification(vTitle, {
      body: vMessage,
      icon: PhSettings.rootPath + 'assets/media/' + vIcon
    });

    notification.onclick = (e) => {
      console.log('Notification Clicked');
    };
  }
}

function initNotification() {
  if (Notification.permission === 'granted') {
    setInterval(getNotifications, 1500);
  } else if (Notification.permission !== 'denied') {
    Notification.requestPermission().then(permission => {
      if (permission === 'granted') {
        showNotification(PhSettings.Title, getLabel('Thank You') + ' ' + PhSettings.UName);
      }
    });
  }
}

function showToast(vType, vTitle, vMessage) {
  //var vType = ['success', 'info', 'warning', 'error'];
  var $toast = toastr[vType](vMessage, vTitle); // Wire up an event handler to a button in the toast, if it exists
}

function initToasts() {
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    showDuration: 300,
    hideDuration: 1000,
    timeOut: 10000,
    extendedTimeOut: 0,
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
    tapToDismiss: false,
    onclick: null
  };
  //setInterval(getNotifications, 1500);
}
/*
 * begin Query Functions
 */
function queryDrawOptions(container, aOptions, prefix) {
  var vHtml = '';
  for (const fld in aOptions) {
    vHtml += '<div class="col-3 col-sm-2 col-lg-2 form-group form-inline">'
      + '  <span class="switch switch-sm switch-outline switch-icon switch-info">'
      + '    <label>'
      + '      <input id="' + prefix + '-' + fld + '" type="checkbox" ' + (aOptions[fld].Status === 1 ? 'checked="checked"' : '') + '>'
      + '      <span></span>'
      + '    </label>'
      + '  </span>'
      + '  <label for="Disp-' + fld + '">' + aOptions[fld].Title + '</label>'
      + '</div>';
  }
  $(container).html(vHtml);
}
function queryGetDisplay(aColumns, aDispCols, prefix) {
  var aRet = {
    'Display': {},
    'Columns': []
  };
  var nIdx = 0;
  for (const fld in aDispCols) {
    aDispCols[fld].Status = 0;
    if ($('#' + prefix + '-' + fld).is(':checked')) {
      aDispCols[fld].Status = 1;
    }
  }
  for (var i = 0; i < aColumns.length; i++) {
    var fld = aColumns[i]['display'];
    if (aDispCols.hasOwnProperty(fld)) {
      aRet.Display[fld] = 0;
      if (aDispCols[fld].Status === 1) {
        aRet.Display[fld] = 1;
        aRet.Columns[nIdx++] = aColumns[i];
      }
    } else {
      aRet.Columns[nIdx++] = aColumns[i];
    }
  }
  return aRet;
}
function queryGetOptions(aOptions, prefix) {
  var options = {};
  for (const fld in aOptions) {
    aOptions[fld].Status = 0;
    if ($('#' + prefix + '-' + fld).is(':checked')) {
      options[fld] = 1;
    }
  }
  return options;
}
/*
 * End Query Functions
 */


function addPatient() {
  var vName = $('#patName').val();
  var vMobile = $('#patName').val();
  var nDoctor = parseInt($('#patAppDoctor').val());
  var form = KTUtil.getById('ph_AddPatient_form');
  form.classList.remove('was-validated');
  $('#patAppMinute').attr('step', 1);
  if (form.checkValidity()) {
    $('#patAppMinute').attr('step', PhSettings.appTime);
    if (vName !== null && vName !== '' && vMobile !== null && vMobile !== '' && nDoctor !== null && nDoctor > 0) {
      PhUtility.doSave({
        "vOperation": "cpy-Clinic-Main-PatientAppointmentSave",
        "nAppClinic": $('#patAppClinic').val(),
        "nAppSpecial": $('#patAppSpecial').val(),
        "nAppDoctor": $('#patAppDoctor').val(),
        "vAppDate": $('#patAppDate').val(),
        "nAppHour": $('#patAppHour').val(),
        "nAppMinute": $('#patAppMinute').val(),
        "nAppType": $('#patAppType').val(),
        "nAppAmount": $('#patAppAmount').val(),
        "vAppDesc": $('#patAppDesc').val(),
        'nId': $('#fldId').val(),
        'nClinicId': $('#patAppClinic').val(),
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
      }, $("#ph_AddPatient_form").trigger("reset"));
    }
  } else {
    $('#patAppMinute').attr('step', PhSettings.appTime);
    form.classList.add('was-validated');
  }
}

function openAddApointment() {
  $("#ph_AddAppointment_form").trigger("reset");
  var nClinic = $('#current-clininc').data('id');
  $('#appClinic').val(nClinic);
  $('#appId').val('0');
  $('#addAppointmentModalLabel').text('Add Appointment');
  $('#addAppointmentModal').modal('show');
}

function addMainAppointment() {
  var nAppId = parseInt($('#appId').val());
  var nPatient = $('#fldPatientId').val();
  var nDoctor = $('#appDoctor').val();
  var nMinut = $('#appMinute').val();
  var form = KTUtil.getById('ph_AddAppointment_form');
  $('#appMinute').attr('step', 1);
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    if (nPatient > 0 && nDoctor > 0 && (nMinut >= 0 && nMinut <= 59)) {
      $('#appMinute').attr('step', PhSettings.appTime);
      if (nAppId === 0) {
        $.ajax({
          type: 'POST',
          async: false,
          url: PhSettings.serviceURL,
          data: {
            'progId': PhSettings.progId,
            'vCDId': PhSettings.CDId,
            'vGUId': PhSettings.GUId,
            "vOperation": "cpy-Clinic-Main-CheckAvailable",
            "nDoctor": nDoctor,
            "nType": $('#appType').val(),
            "vDate": $('#appDate').val(),
            "nHour": $('#appHour').val(),
            "nMinute": $('#appMinute').val()
          },
          success: function (response) {
            try {
              var res = response;
              if (res.Status && res.bAvailable) {
                PhUtility.doSave({
                  "vOperation": "cpy-Clinic-Main-AppointmentSave",
                  "id": nAppId,
                  "nClinic": $('#appClinic').val(),
                  "nSpecial": $('#appSpecial').val(),
                  "nDoctor": nDoctor,
                  "vDate": $('#appDate').val(),
                  "nHour": $('#appHour').val(),
                  "nMinute": $('#appMinute').val(),
                  "nMinutes": $('#appMinutes').val(),
                  "nType": $('#appType').val(),
                  "nPatient": nPatient,
                  "nAmount": $('#appAmount').val(),
                  "vDesc": $('#appDesc').val()
                }, $("#ph_AddAppointment_form").trigger("reset"));
              } else {
                swal.fire({
                  text: res.Message,
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "OK",
                  confirmButtonClass: "btn font-weight-bold btn-light-primary"
                }).then(function () {

                });
                $('#status-Message').text(res.Message);
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
      } else {
        PhUtility.doSave({
          "vOperation": "cpy-Clinic-Main-AppointmentSave",
          "id": nAppId,
          "nClinic": $('#appClinic').val(),
          "nSpecial": $('#appSpecial').val(),
          "nDoctor": nDoctor,
          "vDate": $('#appDate').val(),
          "nHour": $('#appHour').val(),
          "nMinute": $('#appMinute').val(),
          "nMinutes": $('#appMinutes').val(),
          "nType": $('#appType').val(),
          "nPatient": nPatient,
          "nAmount": $('#appAmount').val(),
          "vDesc": $('#appDesc').val()
        }, $("#ph_AddAppointment_form").trigger("reset"));
      }
      $('#appMinute').attr('step', PhSettings.appTime);
    } else {
      $('#appMinute').attr('step', PhSettings.appTime);
      form.classList.add('was-validated');
    }
  }
}

function openAddPayment() {
  $("#ph_AddPayment_form").trigger("reset");
  var nClinic = $('#current-clininc').data('id');
  $('#payClinic').val(nClinic);
  $('#payPatient').val(0);
  $('#addPaymentModal').modal('show');
}

function addMainPayment() {
  var form = KTUtil.getById('ph_AddPayment_form');
  form.classList.remove('was-validated');
  if (form.checkValidity()) {
    PhUtility.doSave({
      "vOperation": "cpy-Clinic-Main-PaymentSave",
      "id": 0,
      "nCId": $('#payClinic').val(),
      "nDId": $('#payDcotor').val(),
      "nMId": $('#payMethod').val(),
      "nPId": $('#payPatient').val(),
      "dDate": $('#payDate').val(),
      "nAmount": $('#payAmount').val(),
      "vDesc": $('#payDesc').val()
    });
  } else {
    form.classList.add('was-validated');
  }
}

function getAppType(nId) {
  var oAppType;
  oAppType = PhSettings['appType'].find(function (element) {
    if (parseInt(element.Id) === parseInt(nId)) {
      return element;
    }
  });
  return oAppType;
}

function getAppStatus(nId) {
  var oAppStatus;
  oAppStatus = PhSettings['appStatus'].find(function (element) {
    if (parseInt(element.Id) === parseInt(nId)) {
      return element;
    }
  });
  return oAppStatus;
}

function getColor(nId) {
  var oColor;
  oColor = PhSettings['color'].find(function (element) {
    if (parseInt(element.Id) === parseInt(nId)) {
      return element;
    }
  });
  return oColor;
}

function getCategoryProcedures() {
  var nCat = parseInt($('#treatCat').val());
  if (nCat > 0) {
    $.ajax({
      type: 'POST',
      async: false,
      url: PhSettings.serviceURL,
      data: {
        'progId': PhSettings.progId,
        'vCDId': PhSettings.CDId,
        'vGUId': PhSettings.GUId,
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
              $('#lstProcedure').empty().append(vProcOptions);
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

function getProcedurePrice() {
  var nIdx = $('#lstProcedure').val();
  if (nIdx >= 0) {
    var proc = catProcs[nIdx];
    $('#procPrice').val(proc.Price);
    getUpdateAmt();
  }
}

function procSave() {
  var nCat = parseInt($('#treatCat').val());
  if (nCat > 0) {
    var nClinic = $('#current-clininc').data('id');
    var nPatient = $('#treatPatient').val();
    var proc = catProcs[$('#lstProcedure').val()];
    PhUtility.doSave({
      "vOperation": "cpy-Clinic-Patient-Treatment-Save",
      "nCId": nClinic,
      "nPId": nPatient,
      "nDId": PhSettings.uid,
      "nProcId": proc.Id,
      "nQnt": parseFloat($('#procQnt').val()),
      "nPrice": parseFloat($('#procPrice').val()),
      "nAmt": parseFloat($('#procAmt').val())
    }, getTreatment, false);
  }
}

var tData = [];

function procaAddTData() {
  var index = tData.length;
  tData[index] = {};
  tData[index].isDeleted = false;
  tData[index].nDoctorId = PhSettings.uid;
  tData[index].vDoctorName = PhSettings.UName;
  tData[index].nLstProcedureId = $('#lstProcedure').val();
  tData[index].vLstProcedureName = $('#lstProcedure :selected').text();
  tData[index].nQnt = $('#procQnt').val();
  tData[index].nPrice = $('#procPrice').val();
  tData[index].nAmt = $('#procAmt').val();
  getTreatment();
  tData[index].nVat = 5;
  tData[index].nTotal = tData[index].nVat + tData[index].nAmt;
  drawTData();
}

function drawTData() {
  var vHtml = "";
  for (let index = 0; index < tData.length; index++) {
    if (!tData[index].isDeleted) {
      vHtml += '<tr>';
      vHtml += '  <td>' + tData[index].vDoctorName + '</td>';
      vHtml += '  <td>' + tData[index].vLstProcedureName + '</td>';
      vHtml += '  <td>' + tData[index].nQnt + '</td>';
      vHtml += '  <td>' + tData[index].nPrice + '</td>';
      vHtml += '  <td>' + tData[index].nAmt + '</td>';
      vHtml += '  <td>' + tData[index].nVat + '</td>';
      vHtml += '  <td>' + tData[index].nTotal + '</td>';
      vHtml += '  <td>';
      vHtml += '    <a href="javascript:;" class="btn btn-light-danger p-1 delete-item" data-id="' + index + '">';
      vHtml += '      <i class="icon-x flaticon2-rubbish-bin"></i>';
      vHtml += '    </a>';
      vHtml += '  </td>';
      vHtml += '</tr>';
    }
  }
  $('#dataTable tbody').html(vHtml);
}

function getUpdateAmt() {
  var nQnt = parseFloat($('#procQnt').val());
  var nPrice = parseFloat($('#procPrice').val());
  $('#procAmt').val(nQnt * nPrice);
}

function deleteProcedure(nId) {
  if (PhSettings.Treats.Del) {
    PhUtility.doDelete('Procedure', { "vOperation": "cpy-Patient-Treatment-Delete", "id": nId }, getTreatment, false);
  }
}

function getTreatment(response) {
  var nClinic = $('#current-clininc').data('id');
  var nPatient = $('#treatPatient').val();
  $('#procQnt').val(1);
  $('#procPrice').val(0);
  $('#procAmt').val(0);
  $('#totalAmt').html(0);
  $('#totalVat').html(0);
  $('#totalTotal').html(0);
  $.ajax({
    type: 'POST',
    async: false,
    url: PhSettings.serviceURL,
    data: {
      'progId': PhSettings.progId,
      'vCDId': PhSettings.CDId,
      'vGUId': PhSettings.GUId,
      "vOperation": "cpy-Clinic-Patient-Treatment-getTreatmentProcedures",
      "nCId": nClinic,
      "nSSId": 1,
      "nSEId": 1,
      "nPId": nPatient
    },
    success: function (response) {
      try {
        var res = response;
        if (res.Status) {
          if (Array.isArray(res.Data)) {
            var vProcHtml = '';
            var proc;
            vProcHtml += '<table class="table table-striped table-bordered my-0 w-100">';
            vProcHtml += '<tbody>';
            var nTotAmt = 0;
            var nTotVat = 0;
            for (var i = 0; i < res.Data.length; i++) {
              proc = res.Data[i];
              vProcHtml += '<tr>';
              if (PhSettings.Treats.Del) {
                vProcHtml += '<td style="width: 5%;">' + (parseInt(proc.DoctorId) === parseInt(PhSettings['uid']) ? PhUtility.deleteIdButton(proc.Id, 'delete-procedure') : '') + '</td>';
              }
              vProcHtml += '<td style="width: 10%;">' + proc.Datetime + '</td>';
              vProcHtml += '<td style="width: 10%;">' + proc.DoctorName + '</td>';
              vProcHtml += '<td style="width: 30%;" class="text-wrap">' + proc.Category + ' - ' + proc.Procedure + '</td>';
              vProcHtml += '<td style="width: 5%;" class="text-right">' + Math.round(proc.Qnt, 0) + '</td>';
              vProcHtml += '<td style="width: 10%;" class="text-right">' + Math.round(proc.Price, 0) + '</td>';
              vProcHtml += '<td style="width: 10%;" class="text-right">' + Math.round(proc.Amt, 0) + '</td>';
              vProcHtml += '<td style="width: 10%;" class="text-right">' + Math.round(proc.VatAmt, 0) + '</td>';
              vProcHtml += '<td style="width: 10%;" class="text-right">' + (Math.round(proc.Amt, 0) + Math.round(proc.VatAmt, 0)) + '</td>';
              vProcHtml += '</tr>';
              nTotAmt += Math.round(proc.Amt, 0);
              nTotVat += Math.round(proc.VatAmt, 0);
            }
            vProcHtml += '</tbody>';
            vProcHtml += '</table>';
            $('#treatProcs').html(vProcHtml);
            $('#totalAmt').html(nTotAmt);
            $('#totalVat').html(nTotVat);
            $('#totalTotal').html(nTotAmt + nTotVat);
            if (PhSettings.Treats.Del) {
              $('.delete-procedure').unbind('click').on('click', function () {
                deleteProcedure($(this).data('id'));
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
  $('#treatFormModal').modal('show');
}