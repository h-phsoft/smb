/* global Intl, KTUtil */

// Initializing a class definition
var IdGenerator = function () {
  var nLastId = (Math.floor(Math.random() * 999) + 100) + Date.now();
  this.genId = function () {
    return nLastId++;
  };
};
var IdGen = new IdGenerator();

//
var PhTable_SUM = 'sum';
var PhTable_MIN = 'min';
var PhTable_MAX = 'max';
var PhTable_AVG = 'avg';
var PhTable_COUNT = 'count';
//
var PhTable_WIDTH_FIXED = 0;
var PhTable_WIDTH_VAIABLE = 1;
//
var PhTable_HEIGHT_UNIT = 'vh';
var PhTable_HEIGHT = '30';
var PhTable_MAX_HEIGHT = '30';
//
var PhTable = function (vContainer, aCols, aData, options = {}) {
  var phT = this;
  phT.vContainer = vContainer;
  phT.aCols = aCols;
  phT.aData = aData;
  phT.options = options;
  //
  phT.id = IdGen.genId();
  phT.version = '0.1.210602.1145';
  phT.defaultOptions = {
    widthType: PhTable_WIDTH_VAIABLE,
    nRowWidth: 0,
    heightUnit: PhTable_HEIGHT_UNIT,
    height: PhTable_HEIGHT,
    maxHeight: PhTable_MAX_HEIGHT,
  };
  phT.options = $.extend(phT.defaultOptions, phT.options);
  phT.tableHeaderId = 'phTableHeader-' + phT.id;
  phT.tableBodyId = 'phTableBody-' + phT.id;
  phT.tableFooterId = 'phTableFooter-' + phT.id;
  phT.$container = $('#' + vContainer);
  phT.aOriginalData = aData;
  phT.nTabIndex = 0;
  phT.nRows = 0;
  phT.aRows = [];
  phT.$container.css('width', '100%');
  phT.$container.css('overflow-x', 'auto');
  phT.aColumns = [];
  for (var nColumn = 0; nColumn < phT.aCols.length; nColumn++) {
    phT.aColumns[nColumn] = Object.assign(
            {title: '',
              field: '',
              width: '',
              datatype: 'string',
              visible: true,
              aggregate: '',
              component: 'display',
              componentAttr: {},
              componentType: 'text',
              enabled: true,
              required: false,
              ajax: false,
              ajaxType: 'POST',
              async: false,
              ajaxURL: '',
              ajaxData: {},
              options: [],
              callback: '',
              format: '',
              classes: '',
              attr: '',
              action: '',
              defValue: '',
              defLabel: ''
            }, phT.aCols[nColumn]);
  }

  phT.unbindCallback = function () {
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      if (phT.aColumns[nColNum].hasOwnProperty('callback') && phT.aColumns[nColNum].callback !== '' && phT.aColumns[nColNum].field !== '') {
        if (typeof phT.aColumns[nColNum].callback.callback === "function") {
          $('.' + phT.aColumns[nColNum].field).unbind(phT.aColumns[nColNum].callback.event);
        }
      }
    }
  };

  phT.initCallback = function () {
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      if (phT.aColumns[nColNum].hasOwnProperty('callback') && phT.aColumns[nColNum].callback !== '' && phT.aColumns[nColNum].field !== '') {
        if (typeof phT.aColumns[nColNum].callback.callback === "function") {
          var callback = phT.aColumns[nColNum].callback.callback;
          $('.' + phT.aColumns[nColNum].field)
                  .on(phT.aColumns[nColNum].callback.event, callback);
        }
      }
    }
  };

  phT.initAutocomplete0 = function () {
    $(".ph-autocomplete").autocomplete({
      source: function (request, response) {
        var nCol = parseInt($(this).data('col'));
        var oCol = Object.assign({}, phT.aColumns[nCol]);
        var oAjaxData = '';
        if (oCol.hasOwnProperty('ajax') && oCol.ajax === true) {
          if (typeof oCol.ajaxData === "function") {
            oAjaxData = JSON.parse(JSON.stringify(oCol.ajaxData()));
          } else {
            oAjaxData = JSON.parse(JSON.stringify(oCol.ajaxData));
          }
          oAjaxData.term = request.term;
          $.ajax({
            type: oCol.ajaxType,
            async: oCol.ajaxAsync,
            url: oCol.ajaxURL,
            data: oAjaxData,
            success: function (ajaxResponse) {
              response(ajaxResponse.Data);
            }
          });
        } else {
          response(oCol.options);
        }
      },
      minLength: 0,
      focus: function (event, ui) {
        return false;
      },
      select: function (event, ui) {
        $(this).val(ui.item.label);
        var vField = $(this).data('field');
        var nRow = $(this).data('row');
        var nCol = $(this).data('col');
        if (vField !== undefined) {
          phT.aRows[nRow].fields[vField].value = ui.item.value;
          phT.aRows[nRow].fields[vField].label = ui.item.label;
          phT.aRows[nRow].fields[vField].isChanged = true;
        }
        return false;
      }
    });
  };

  phT.initAutocomplete = function () {
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      if (phT.aColumns[nColNum].hasOwnProperty('autocomplete') && phT.aColumns[nColNum].autocomplete === true && phT.aColumns[nColNum].field !== '') {
        if (phT.aColumns[nColNum].hasOwnProperty('ajax') && phT.aColumns[nColNum].ajax === true) {
          $(".ph-ac-" + phT.aColumns[nColNum].field).autocomplete({
            source: function (request, response) {
              var autoCompleteSelectorId = this.element[0].id;
              var nCol = $('#' + autoCompleteSelectorId).data('col');
              var oColumn = Object.assign({}, phT.aColumns[nCol]);
              var oAjaxData = '';
              if (typeof oColumn.ajaxData === "function") {
                oAjaxData = JSON.parse(JSON.stringify(oColumn.ajaxData()));
              } else {
                oAjaxData = JSON.parse(JSON.stringify(oColumn.ajaxData));
              }
              oAjaxData.term = request.term;
              oColumn.ajaxData.term = request.term;
              $.ajax({
                type: oColumn.ajaxType,
                async: oColumn.ajaxAsync,
                url: oColumn.ajaxURL,
                data: oAjaxData, //oColumn.ajaxData,
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
              var vField = $(this).data('field');
              var nRow = $(this).data('row');
              var nCol = $(this).data('col');
              if (vField !== undefined) {
                phT.aRows[nRow].fields[vField].value = ui.item.value;
                phT.aRows[nRow].fields[vField].label = ui.item.label;
                phT.aRows[nRow].fields[vField].isChanged = true;
              }
              return false;
            }
          });
        } else {
          if (phT.aColumns[nColNum].hasOwnProperty('options') && phT.aColumns[nColNum].options !== '') {
            var oColumn = JSON.parse(JSON.stringify(phT.aColumns[nColNum]));
            $(".ph-ac-" + phT.aColumns[nColNum].field).autocomplete({
              source: oColumn.options,
              minLength: 0,
              focus: function (event, ui) {
                return false;
              },
              select: function (event, ui) {
                $(this).val(ui.item.label);
                var vField = $(this).data('field');
                var nRow = $(this).data('row');
                var nCol = $(this).data('col');
                if (vField !== undefined) {
                  phT.aRows[nRow].fields[vField].value = ui.item.value;
                  phT.aRows[nRow].fields[vField].label = ui.item.label;
                  phT.aRows[nRow].fields[vField].isChanged = true;
                }
                return false;
              }
            });
          }
        }
      }
    }
  };

  phT.setWidthType = function (nType = PhTable_WIDTH_VAIABLE) {
    phT.options.widthType = nType;
    phT.render();
  };

  phT.setHeight = function (nHeight) {
    phT.options.height = nHeight;
    phT.options.maxHeight = nHeight;
    phT.render();
  };

  phT.enableField = function (nRow, vField) {
    phT.aRows[nRow].fields[vField].enabled = true;
    phT.render();
  };

  phT.disableField = function (nRow, vField) {
    phT.aRows[nRow].fields[vField].enabled = false;
    phT.render();
  };

  phT.getField = function (nRow, vField) {
    return phT.aRows[nRow].fields[vField];
  };

  phT.getFieldValue = function (nRow, vField) {
    return phT.aRows[nRow].fields[vField].value;
  };

  phT.setFieldValue = function (nRow, vField, vValue) {
    phT.aRows[nRow].fields[vField].value = vValue;
    phT.aRows[nRow].fields[vField].isChanged = true;
    phT.refreshRow(nRow);
  };

  phT.setFieldValueLabel = function (nRow, vField, vValue, vLabel) {
    console.log(nRow, vField, vValue, vLabel);
    phT.aRows[nRow].fields[vField].value = vValue;
    phT.aRows[nRow].fields[vField].label = vLabel;
    phT.aRows[nRow].fields[vField].isChanged = true;
    phT.refreshRow(nRow);
  };

  phT.getSum = function (field) {
    var nRet = 0;
    for (var nRowNum = 0; nRowNum < phT.aRows.length; nRowNum++) {
      try {
        nRet += Number(phT.aRows[nRowNum].fields[field].value);
      } catch (e) {

      }
    }
    return nRet;
  };

  phT.getMax = function (field) {
    var nRet = 0;
    for (var nRowNum = 0; nRowNum < phT.aRows.length; nRowNum++) {
      try {
        nRet = Math.max(nRet, Number(phT.aRows[nRowNum].fields[field].value));
      } catch (e) {

      }
    }
    return nRet;
  };

  phT.getMin = function (field) {
    var nRet = 0;
    for (var nRowNum = 0; nRowNum < phT.aRows.length; nRowNum++) {
      try {
        nRet = Math.min(nRet, Number(phT.aRows[nRowNum].fields[field].value));
      } catch (e) {

      }
    }
    return nRet;
  };

  phT.getAvg = function (field) {
    var nRet = 0;
    if (phT.aOriginalData.length > 0) {
      for (var nRowNum = 0; nRowNum < phT.aRows.length; nRowNum++) {
        try {
          nRet += Number(phT.aRows[nRowNum].fields[field].value);
        } catch (e) {

        }
      }
      nRet = nRet / phT.aOriginalData.length;
    }
    return nRet;
  };

  phT.getCount = function (field) {
    var nRet = 0;
    for (var nRowNum = 0; nRowNum < phT.aRows.length; nRowNum++) {
      try {
        if (!(phT.aRows[nRowNum].fields[field].value === '')) {
          nRet++;
        }
      } catch (e) {

      }
    }
    return nRet;
  };

  phT.getColumnByField = function (field) {
    var column = {};
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      if (field === phT.aColumns[nColNum].field) {
        column = phT.aColumns[nColNum];
      }
    }
    return column;
  };

  phT.setData = function (aData) {
    phT.aOriginalData = aData;
    phT.initRows();
    phT.render();
  };

  phT.getData = function () {
    return phT.aRows;
  };

  phT.initRows = function () {
    var oColumn = {};
    var bEnabled = true;
    var vLabel = '';
    var vValue = '';
    phT.nRows = 0;
    phT.aRows = [];
    if (phT.aOriginalData.length > 0) {
      for (var nRowNum = 0; nRowNum < phT.aOriginalData.length; nRowNum++) {
        phT.aRows[nRowNum] = {
          isNew: false,
          isDeleted: false,
          fields: {}
        };
        for (const [key, value] of Object.entries(phT.aOriginalData[nRowNum])) {
          bEnabled = true;
          vValue = value;
          vLabel = value;
          if (vLabel === null || vLabel === 'null') {
            vLabel = '';
            vValue = '';
          }
          if (phT.aOriginalData[nRowNum][key] !== null) {
            if (phT.aOriginalData[nRowNum][key].hasOwnProperty('enabled')) {
              bEnabled = phT.aOriginalData[nRowNum][key].enabled;
            }
            if (phT.aOriginalData[nRowNum][key].hasOwnProperty('label')) {
              vLabel = phT.aOriginalData[nRowNum][key].label;
            }
          }
          oColumn = phT.getColumnByField(key);
          if (oColumn.hasOwnProperty('rfield')) {
            if (phT.aOriginalData[nRowNum][oColumn.rfield] !== '') {
              vLabel = phT.aOriginalData[nRowNum][oColumn.rfield];
            }
          }
          phT.aRows[nRowNum].fields[key] = {
            field: key,
            origin: vValue,
            value: vValue,
            label: vLabel,
            enabled: bEnabled,
            isChanged: false
          };
        }
        phT.nRows++;
      }
    }
  };

  phT.addEmptyRow = function () {
    var field = '';
    var vValue = '';
    var vLabel = '';
    var bEnabled = true;
    phT.aRows[phT.nRows] = {
      isNew: true,
      isDeleted: false,
      fields: {}
    };
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      field = phT.aColumns[nColNum].field;
      vValue = '';
      vLabel = '';
      if (phT.aColumns[nColNum].hasOwnProperty('defValue') && phT.aColumns[nColNum].defValue !== '') {
        vValue = phT.aColumns[nColNum].defValue;
        bEnabled = phT.aColumns[nColNum].enabled;
      }
      if (phT.aColumns[nColNum].hasOwnProperty('defLabel') && phT.aColumns[nColNum].defLabel !== '') {
        vLabel = phT.aColumns[nColNum].defLabel;
      }
      phT.aRows[phT.nRows].fields[field] = {
        field: phT.aColumns[nColNum].field,
        origin: vValue,
        enabled: bEnabled,
        value: vValue,
        label: vLabel,
        isChanged: false
      };
    }
    phT.nRows++;
  };

  phT.deleteRow = function (nRowNum) {
    if (phT.aRows[nRowNum] !== undefined) {
      if (phT.aRows[nRowNum].isNew) {
        phT.aRows.splice(nRowNum, 1);
        phT.nRows--;
      } else {
        phT.aRows[nRowNum].isDeleted = true;
      }
      phT.render();
    }
  };

  phT.getRow = function (nRowNum) {
    if (phT.aRows[nRowNum] !== undefined) {
      return phT.aRows[nRowNum];
    }
  };

  phT.getRowCount = function () {
    return phT.aRows.length;
  };

  phT.renderDisplay = function (cell, nRowNum, nColNum, vValue) {
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = '';
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    vComponent = '<span class="form-control form-control-md ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '">' + vValue + '</span>';
    return vComponent;
  };

  phT.renderImage = function (cell, nRowNum, nColNum, vValue, bEnabled) {
    //var typeId = cell.field + '-' + phT.id + '-' + nRowNum;
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vComponentAttr = '';
    var vClasses = '';
    var vAttr = '';
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    if (cell.hasOwnProperty('componentAttr')) {
      if (cell.componentAttr.hasOwnProperty('width')) {
        vComponentAttr += ' width="' + cell.componentAttr.width + '"';
      }
      if (cell.componentAttr.hasOwnProperty('height')) {
        vComponentAttr += ' height="' + cell.componentAttr.height + '"';
      }
    }
    vComponent = '<img src="' + vValue + '" ' + vComponentAttr + ' class="' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '"/>';
    return vComponent;
  };

  phT.renderInput = function (cell, nRowNum, nColNum, vCurrValue, vCurrLabel, bEnabled) {
    //var typeId = cell.field + '-' + phT.id + '-' + nRowNum;
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = ' tabindex="' + phT.nTabIndex + '"';
    if (cell.datatype === 'decimal' && vCurrValue !== '') {
      vCurrValue = parseFloat(vCurrValue);
      vCurrValue = decimalFormat(vCurrValue);
    }
    if (cell.hasOwnProperty('autocomplete') && cell.autocomplete === true) {
      vClasses = ' ph-autocomplete ph-ac-' + cell.field;
      typeId = 'ph-ac-' + cell.field + '-' + phT.id + '-' + nRowNum;
      vCurrValue = vCurrLabel;
    }
    if (cell.hasOwnProperty('required') && cell.required === true) {
      vAttr += ' required="" ';
    }
    if (vCurrValue !== '') {
      vAttr += ' value="' + vCurrValue + '" ';
    } else {
      if (cell.hasOwnProperty('autocomplete') && cell.autocomplete === true) {
        if (cell.hasOwnProperty('defLabel') && cell.defLabel !== '') {
          vAttr += ' value="' + cell.defLabel + '" ';
        } else {
          vAttr += ' value="" ';
        }
      } else {
        if (cell.hasOwnProperty('defValue') && cell.defValue !== '') {
          vAttr += ' value="' + cell.defValue + '" ';
        } else {
          vAttr += ' value="" ';
        }
      }
    }
    if (cell.hasOwnProperty('enabled') && !cell.enabled) {
      vAttr += ' disabled';
    }
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses += ' ' + cell.classes;
    }
    vComponent = '<input class="form-control form-control-md ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" type="' + cell.componentType + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '">';
    if (cell.componentType === 'date') {
      vComponent = '<input class="form-control form-control-md ph_datepicker ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" type="text" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '">';
    }
    return vComponent;
  };

  phT.renderButton = function (cell, nRowNum, nColNum, bEnabled) {
    //var typeId = cell.field + '-' + phT.id + '-' + nRowNum;
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = ' tabindex="' + phT.nTabIndex + '"';
    if (cell.hasOwnProperty('required') && cell.required === true) {
      vAttr += ' required="" ';
    }
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('enabled') && !cell.enabled) {
      vAttr += ' disabled';
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    vComponent = '<button class="btn btn-sm ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' px-2" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '">';
    if (cell.hasOwnProperty('format') && cell.format !== '') {
      vComponent += cell.format;
    }
    vComponent += '</button>';
    return vComponent;
  };


  phT.renderSelect = function (cell, nRowNum, nColNum, vCurrValue, bEnabled) {
    //var typeId = cell.field + '-' + phT.id + '-' + nRowNum;
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = ' tabindex="' + phT.nTabIndex + '"';
    if (cell.hasOwnProperty('required') && cell.required === true) {
      vAttr += ' required="" ';
    }
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('enabled') && !cell.enabled) {
      vAttr += ' disabled';
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    vComponent = '<select class="form-control form-control-md selectpicker ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '" style="width: 100% important;">';
    if (cell.hasOwnProperty('options') && cell.options !== '' && Array.isArray(cell.options)) {
      for (var i = 0; i < cell.options.length; i++) {
        var vSelected = '';
        // dont use ===
        if (vCurrValue == cell.options[i].value || (vCurrValue === '' && i === 0)) {
          vSelected = 'selected';
        }
        vComponent += '  <option value="' + cell.options[i].value + '" ' + vSelected + '>' + cell.options[i].label + '</option>';
      }
    } else {
      vComponent += '  <option value="">Please Select</option>';
    }
    vComponent += '</select>';
    return vComponent;
  };

  phT.renderNormalSelect = function (cell, nRowNum, nColNum, vCurrValue, bEnabled) {
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = ' tabindex="' + phT.nTabIndex + '"';
    if (cell.hasOwnProperty('required') && cell.required === true) {
      vAttr += ' required="" ';
    }
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('enabled') && !cell.enabled) {
      vAttr += ' disabled';
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    vComponent = '<select class="form-control form-control-md ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '" style="width: 100% important;">';
    if (cell.hasOwnProperty('options') && cell.options !== '' && Array.isArray(cell.options)) {
      for (var i = 0; i < cell.options.length; i++) {
        var vSelected = '';
        // dont use ===
        if (vCurrValue == cell.options[i].value || (vCurrValue === '' && i === 0)) {
          vSelected = 'selected';
        }
        vComponent += '  <option value="' + cell.options[i].value + '" ' + vSelected + '>' + cell.options[i].label + '</option>';
      }
    } else {
      vComponent += '  <option value="">Please Select</option>';
    }
    vComponent += '</select>';
    return vComponent;
  };

  phT.renderAjaxSelect = function (cell, nRowNum, nColNum, vCurrValue, bEnabled) {
    //var typeId = cell.field + '-' + phT.id + '-' + nRowNum;
    var typeId = phT.id + '-' + nRowNum + '-' + nColNum;
    var vComponent = '';
    var vClasses = '';
    var vAttr = ' tabindex="' + phT.nTabIndex + '"';
    if (cell.hasOwnProperty('required') && cell.required === true) {
      vAttr += ' required="" ';
    }
    if (cell.hasOwnProperty('attr') && cell.required !== '') {
      vAttr += ' ' + cell.attr;
    }
    if (cell.hasOwnProperty('enabled') && !cell.enabled) {
      vAttr += ' disabled';
    }
    if (cell.hasOwnProperty('classes') && cell.classes !== '') {
      vClasses = cell.classes;
    }
    vComponent = '<select class="form-control form-control-md w-100 selectpicker ' + vClasses + ' ' + cell.field + ' cell-' + phT.id + ' col-' + phT.id + '-' + nColNum + '" id="' + typeId + '" ' + vAttr + ' data-field="' + cell.field + '" data-tid="' + phT.id + '" data-row="' + nRowNum + '" data-col="' + nColNum + '">';
    if (cell.hasOwnProperty('options') && cell.options !== '' && Array.isArray(cell.options)) {
      for (var i = 0; i < cell.options.length; i++) {
        var vSelected = '';
        // dont use ===
        if (vCurrValue == cell.options[i].value || (vCurrValue === '' && i === 0)) {
          vSelected = 'selected';
        }
        vComponent += '  <option value="' + cell.options[i].value + '" ' + vSelected + '>' + cell.options[i].label + '</option>';
      }
    } else {
      vComponent += '  <option value="">Please Select</option>';
    }
    vComponent += '</select>';
    return vComponent;
  };

  phT.refreshRow = function (nRowNum) {
    var cell;
    var vValue = '';
    var vLabel = '';
    var bEnabled = true;
    var vId = '';
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      vId = phT.id + '-' + nRowNum + '-' + nColNum;
      cell = phT.aColumns[nColNum];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        vValue = '';
        vLabel = '';
        if (phT.aRows[nRowNum].fields.hasOwnProperty(cell.field)) {
          vValue = phT.aRows[nRowNum].fields[cell.field].value;
          vLabel = phT.aRows[nRowNum].fields[cell.field].label;
          bEnabled = phT.aRows[nRowNum].fields[cell.field].enabled;
        }
        if (cell !== '') {
          if (cell.hasOwnProperty('component') && cell.component !== '') {
            $('#' + vId).prop('disabled', !bEnabled);
            switch (cell.component) {
              case 'display':
                $('#' + vId).text(vLabel);
                break;
              case 'input':
                if (cell.hasOwnProperty('ajax') && cell.ajax === true) {
                  $('#' + vId).val(vLabel);
                } else {
                  if (cell.datatype === 'decimal') {
                    vValue = parseFloat(vValue);
                    vValue = decimalFormat(vValue);
                  } else if (cell.datatype === 'integer') {
                    vValue = parseInt(vValue);
                    vValue = integerFormat(vValue);
                  }
                  $('#' + vId).val(vValue);
                }
                break;
              case 'select':
              case 'nselect':
                $('#' + vId).val(vValue);
                break;
              case 'button':

                break;
              case 'image':
                $('#' + vId).attr('src', vValue);
                break;
              default:
                $('#' + vId).text(vLabel);
                break;
            }
          }
        }
      }
    }
    phT.refreshFooter();
  };

  phT.renderRow = function (nRowNum) {
    var vHtml = '';
    var cell;
    var vComponent;
    var vValue = '';
    var vLabel = '';
    var bEnabled = true;
    var vWidth;
    for (var nColNum = 0; nColNum < phT.aColumns.length; nColNum++) {
      phT.nTabIndex++;
      cell = phT.aColumns[nColNum];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        vValue = '';
        vLabel = '';
        if (phT.aRows[nRowNum].fields.hasOwnProperty(cell.field)) {
          vValue = phT.aRows[nRowNum].fields[cell.field].value;
          vLabel = phT.aRows[nRowNum].fields[cell.field].label;
          bEnabled = phT.aRows[nRowNum].fields[cell.field].enabled;
        }
        vComponent = '';
        vWidth = '';
        if (cell.hasOwnProperty('width') && cell.width !== '') {
          vWidth = 'width: ' + cell.width + ';';
        }
        if (cell !== '') {
          if (cell.hasOwnProperty('component') && cell.component !== '') {
            switch (cell.component) {
              case 'display':
                vComponent = phT.renderDisplay(cell, nRowNum, nColNum, vValue);
                break;
              case 'input':
                vComponent = phT.renderInput(cell, nRowNum, nColNum, vValue, vLabel, bEnabled);
                break;
              case 'select':
                if (cell.hasOwnProperty('ajax') && cell.ajax === true) {
                  vComponent = phT.renderAjaxSelect(cell, nRowNum, nColNum, vValue, bEnabled);
                } else {
                  vComponent = phT.renderSelect(cell, nRowNum, nColNum, vValue, bEnabled);
                }
                break;
              case 'nselect':
                vComponent = phT.renderNormalSelect(cell, nRowNum, nColNum, vValue, bEnabled);
                break;
              case 'button':
                vComponent = phT.renderButton(cell, nRowNum, nColNum, bEnabled);
                break;
              case 'image':
                vComponent = phT.renderImage(cell, nRowNum, nColNum, vValue, bEnabled);
                break;
              default:
                vComponent = phT.renderDisplay(cell, nRowNum, nColNum, vValue);
                break;
            }
          }
        }
        vHtml += '<div style="' + vWidth + '" class="ph-table-cell p-0">' + vComponent + '</div>';
      }
    }
    if (phT.options.widthType === PhTable_WIDTH_VAIABLE) {
      vHtml = '<div class="ph-table-row ' + ((nRowNum % 2 === 0) ? 'ph-table-row-even' : 'ph-table-row-odd Number') + ' align-items-center" style="width: ' + phT.options.nRowWidth + 'px; display: flex;">' + vHtml + '</div>';
    } else {
      vHtml = '<div class="ph-table-row ' + ((nRowNum % 2 === 0) ? 'ph-table-row-even' : 'ph-table-row-odd Number') + ' align-items-center" style="width: 100%; display: flex;">' + vHtml + '</div>';
    }
    return vHtml;
  };

  phT.renderRows = function () {
    var vHtml = '';
    for (var nRowNum = 0; nRowNum < phT.nRows; nRowNum++) {
      if (!phT.aRows[nRowNum].isDeleted) {
        vHtml += phT.renderRow(nRowNum);
      }
    }
    return vHtml;
  };

  phT.renderHeader = function () {
    var vHtml = '';
    for (var i = 0; i < phT.aColumns.length; i++) {
      var cell = phT.aColumns[i];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        var vWidth = '';
        if (cell.hasOwnProperty('width') && cell.width !== '') {
          vWidth = 'width: ' + cell.width + ';';
        }
        vHtml += '<div id="head-' + phT.id + '-' + i + '" style="' + vWidth + '" class="ph-table-col float-left border border-1 text-center p-1">' + cell.title + '</div>';
      }
    }
    if (phT.options.widthType === PhTable_WIDTH_VAIABLE) {
      vHtml = '<div class="ph-table-header" style="width: ' + phT.options.nRowWidth + 'px; display: flex;">' + vHtml + '</div>';
    } else {
      vHtml = '<div class="ph-table-header" style="width: calc(100% - 18px); display: flex;">' + vHtml + '</div>';
    }
    return vHtml;
  };

  phT.renderBody = function () {
    var vHtml = '';
    if (phT.options.widthType === PhTable_WIDTH_VAIABLE) {
      vHtml += '<div class="ph-table-body" style="width: ' + (phT.options.nRowWidth + 20) + 'px; max-height: ' + phT.options.maxHeight + phT.options.heightUnit + '; height: ' + phT.options.maxHeight + phT.options.heightUnit + '; overflow-y: auto; overflow-x: hidden;">';
    } else {
      vHtml += '<div class="ph-table-body" style="width: 100%; max-height: ' + phT.options.maxHeight + phT.options.heightUnit + '; height: ' + phT.options.maxHeight + phT.options.heightUnit + '; overflow-y: auto; overflow-x: hidden;">';
    }
    vHtml += phT.renderRows();
    vHtml += '</div>';
    return vHtml;
  };

  phT.refreshFooter = function () {
    var vValue = '';
    var cell;
    for (var i = 0; i < phT.aColumns.length; i++) {
      cell = phT.aColumns[i];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        vValue = '&nbsp;';
        if (cell.hasOwnProperty('aggregate') && cell.aggregate !== '') {
          switch (cell.aggregate) {
            case PhTable_SUM:
              vValue = phT.getSum(cell.field);
              break;
            case PhTable_AVG:
              vValue = phT.getAvg(cell.field);
              break;
            case PhTable_MIN:
              vValue = phT.getMin(cell.field);
              break;
            case PhTable_MAX:
              vValue = phT.getMax(cell.field);
              break;
            case PhTable_COUNT:
              vValue = phT.getCount(cell.field);
              break;
            default:
              break;
          }
          if (cell.datatype === 'decimal') {
            vValue = parseFloat(vValue);
            vValue = decimalFormat(vValue);
          } else if (cell.datatype === 'integer') {
            vValue = parseInt(vValue);
            vValue = integerFormat(vValue);
          }
          $('#foot-' + phT.id + '-' + i).text(vValue);
        }
      }
    }
  };

  phT.renderFooter = function () {
    var vHtml = '';
    var vWidth = '';
    var vValue = '';
    var cell;
    for (var i = 0; i < phT.aColumns.length; i++) {
      cell = phT.aColumns[i];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        vWidth = '';
        vValue = '&nbsp;';
        if (cell.hasOwnProperty('width') && cell.width !== '') {
          vWidth = 'width: ' + cell.width + ';';
        }
        if (cell.hasOwnProperty('aggregate') && cell.aggregate !== '') {
          switch (cell.aggregate) {
            case PhTable_SUM:
              vValue = phT.getSum(cell.field);
              break;
            case PhTable_AVG:
              vValue = phT.getAvg(cell.field);
              break;
            case PhTable_MIN:
              vValue = phT.getMin(cell.field);
              break;
            case PhTable_MAX:
              vValue = phT.getMax(cell.field);
              break;
            case PhTable_COUNT:
              vValue = phT.getCount(cell.field);
              break;
            default:
              break;
          }
          if (cell.datatype === 'decimal') {
            vValue = parseFloat(vValue);
            vValue = decimalFormat(vValue);
          } else if (cell.datatype === 'integer') {
            vValue = parseInt(vValue);
            vValue = integerFormat(vValue);
          }
        }
        vHtml += '<div id="foot-' + phT.id + '-' + i + '" style="' + vWidth + '" class="ph-table-col float-left border border-1 p-1">' + vValue + '</div>';
      }
    }
    if (phT.options.widthType === PhTable_WIDTH_VAIABLE) {
      vHtml = '<div class="ph-table-footer" style="width: ' + phT.options.nRowWidth + 'px; display: flex;">' + vHtml + '</div>';
    } else {
      vHtml = '<div class="ph-table-footer" style="width: calc(100% - 18px); display: flex;">' + vHtml + '</div>';
    }
    return vHtml;
  };

  phT.render = function () {
    var vHtml = '';
    phT.options.nRowWidth = phT.getRowWidth();
    vHtml += phT.renderHeader();
    vHtml += phT.renderBody();
    vHtml += phT.renderFooter();
    phT.$container.html(vHtml);
    $('.selectpicker').selectpicker('refresh');
    $('.selectpicker').selectpicker('render');
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
      templates: arrows
    });
    // dont change order of 4 next rows
    $('.cell-' + phT.id).unbind('change');
    phT.unbindCallback();
    $('.cell-' + phT.id).on('change', phT.onChange);
    $('.cell-' + phT.id).on('blur', phT.onBlur);
    phT.initCallback();
    phT.initAutocomplete();
    //$('.selectpicker').change();
  };

  phT.getRowWidth = function () {
    var innerWidth = window.innerWidth - 25;
    var nPos = -1;
    var nWidth = 15;
    phT.$container.html('<div style="width: 100%;">&nbsp;</div>');
    if (phT.$container.width() > 0) {
      innerWidth = phT.$container.width();
    }
    for (var i = 0; i < phT.aColumns.length; i++) {
      var cell = phT.aColumns[i];
      if (cell.hasOwnProperty('visible') && cell.visible) {
        if (cell.hasOwnProperty('width') && cell.width !== '') {
          nPos = cell.width.indexOf('%');
          if (nPos > -1) {
            nWidth += parseInt(cell.width.replaceAll('%', '')) * innerWidth / 100;
          } else {
            nWidth += parseInt(cell.width.replaceAll('px', '').replaceAll('%', ''));
          }
        }
      }
    }
    return nWidth;
  };

  phT.onChange = function (e) {
    var vField = $(this).data('field');
    var nRow = $(this).data('row');
    var nCol = $(this).data('col');
    if (!(phT.aColumns[nCol].hasOwnProperty('autocomplete') && phT.aColumns[nCol].autocomplete === true)) {
      if (vField !== undefined && $(this).val() !== 'NaN') {
        phT.aRows[nRow].fields[vField].value = $(this).val();
        phT.aRows[nRow].fields[vField].isChanged = true;
      }
    }
    phT.refreshRow(nRow);
  };

  phT.onBlur = function (e) {

  };

  phT.initRows();
  phT.render();
};
