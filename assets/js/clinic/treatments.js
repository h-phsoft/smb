/* global PhSettings, PhUtility, PhTabulatorLocale */
jQuery(document).ready(function () {

  $('#ph_edit_submit').on('click', function () {
    save();
  });

  refreshList();

});

function refreshList() {
  var aColumns = [];
  var nIdx = 0;
  if (parseInt(PhSettings.current.update) === 1) {
    aColumns[nIdx++] = {
      title: 'Edit',
      align: "center",
      width: "4%",
      headerSort: false,
      formatter: function (cell, formatterParams) {
        var data = cell.getData();
        if (data.StatusId === 0) {
          return PhUtility.editButton();
        }
        return '';
      },
      cellClick: cellEditClick
    };
  }
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
  aColumns[nIdx++] = {
    title: 'Clinic',
    field: "ClinicName",
    width: "10%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: 'Doctor',
    field: "DoctorName",
    width: "10%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: 'Patient Num.',
    field: "PatientNum",
    width: "8%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: 'Patient',
    field: "PatientName",
    width: "30%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: 'Mobile',
    field: "PatientMobile",
    width: "8%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: 'Status',
    field: "StatusName",
    width: "8%",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Added",
    field: "IName",
    width: "8%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  aColumns[nIdx++] = {
    title: "Modified",
    field: "UName",
    width: "8%",
    hozAlign: "left",
    headerFilter: "input",
    formatter: "textarea"
  };
  var table = new Tabulator("#tabulatorTable", {
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
    ajaxParams: {"vOperation": "cpy-Clinic-Treatment-ListTreatments"},
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
      holderEl.style.padding = "10px 10px 10px 10px";
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
  return table;
}

function cellEditClick(e, cell) {
  var data = cell.getData();
  $('#editId').val(data.Id);
  $('#editName').val(data.Name);
  $('#editNum').val(data.Num);
  $('#editNatNo').val(data.NatNum);
  $('#editMobile').val(data.Mobile);
  $('#editGender').val(data.GenderId);
  $('#editGender').change();
  $('#editNatId').val(data.NatId);
  $('#editNatId').change();
  $('#editBirthday').val(data.Birthday);
  $('#editDesc').val(data.Description);
  $('#editModal').modal('show');
}
