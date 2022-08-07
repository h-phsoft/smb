/* global PhSettings, PhUtility, PhTabulatorLocale */
var table;
jQuery(document).ready(function () {

  refreshList();

});

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (parseInt(PhSettings.current.print) === 1) {
    aColumns[nIdx++] = {
      title: "Print",
      align: "center",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.printButton();
      },
      cellClick: cellEditClick
    };
  }
  /*
   aColumns[nIdx++] = {
   title: "Sub",
   align: "center",
   width: "4%",
   headerSort: false,
   formatter: function (cell, formatterParams) {
   return PhUtility.toggleButton();
   },
   cellClick: function (e, row, formatterParams) {
   const id = row.getData().Id;
   $(".subTable" + id + "").toggle();
   }
   };
   */
  aColumns[nIdx++] = {
    title: "Clinic",
    field: "ClinicName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Patient",
    field: "PatientName",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Patient No",
    field: "PatientNum",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Mobile",
    field: "PatientMobile",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Number",
    field: "Num",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Date",
    field: "Date",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Amount",
    field: "Amount",
    hozAlign: "right",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: "VAT",
    field: "VAT",
    hozAlign: "right",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: "Discount",
    field: "Discount",
    hozAlign: "right",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: "Reason",
    field: "Reason",
    hozAlign: "right",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: "Net",
    field: "Net",
    hozAlign: "right",
    headerFilter: "input"
  };
  aColumns[nIdx++] = {
    title: "Description",
    field: "Description",
    hozAlign: "right",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Added",
    field: "IName",
    width: "7%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Modified",
    field: "UName",
    width: "7%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  if (parseInt(PhSettings.current.delete) === 1) {
    aColumns[nIdx++] = {
      title: "",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        return PhUtility.deleteButton();
      },
      cellClick: cellDeleteClick
    };
  }
  table = getAjaxTabulator("cpy-Clinic-Finance-Invoice-ListInvoices", aColumns);
  /*
   table = new Tabulator("#tabulatorTable", {
   layout: "fitColumns",
   textDirection: 'ltr',
   locale: true,
   langs: PhTabulatorLocale,
   height: "100%",
   cellVertAlign: "middle",
   pagination: "remote",
   paginationSize: 10,
   paginationSizeSelector: [10, 25, 50, 75, 100],
   ajaxFiltering: true,
   ajaxSorting: true,
   ajaxURL: PhSettings.serviceURL,
   ajaxParams: {"vOperation": "cpy-Clinic-Finance-Invoice-ListInvoices"},
   ajaxConfig: "post",
   ajaxResponse: function (url, params, response) {
   if (response.Status) {
   return response.Data;
   } else {
   return null;
   }
   },
   columns: aColumns,
   rowFormatter: function (row) {
   //create and style holder elements
   var holderEl = document.createElement("div");
   var tableEl = document.createElement("div");

   const id = row.getData().Id;

   holderEl.style.boxSizing = "border-box";
   holderEl.style.padding = "5px 5px 5px 5px";
   holderEl.style.borderTop = "1px solid #333";
   holderEl.style.borderBotom = "1px solid #333";
   holderEl.style.background = "#ddd";
   holderEl.setAttribute('class', "subTable subTable" + id + "");

   tableEl.style.border = "1px solid #333";
   tableEl.setAttribute('class', "subTable subTable" + id + "");

   holderEl.appendChild(tableEl);

   row.getElement().appendChild(holderEl);

   var subTable = new Tabulator(tableEl, {
   layout: "fitColumns",
   data: row.getData().aProcs,
   columns: [
   {title: "Category", width: "30%", headerSort: false, field: "CatName"},
   {title: "Procedure", width: "30%", headerSort: false, field: "ProcedureName"},
   {title: "Qnt", width: "10%", headerSort: false, field: "Qnt"},
   {title: "Price", width: "10%", headerSort: false, field: "Price"},
   {title: "Amount", width: "10%", headerSort: false, field: "Amount"},
   {title: "Vat", width: "10%", headerSort: false, field: "VatAmount"},
   ]
   });
   }
   });
   */
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $.redirect(PhSettings.rootPath + "pages/finPrintInvoice", {'invId': data.Id}, 'POST', '_BLANK');
}

function cellDeleteClick(e, cell) {
  var data = cell.getData();
  PhUtility.doDelete('Invoice', {"vOperation": "cpy-Clinic-Finance-Invoice-Delete", "id": data.Id}, refreshList, false);
}
