/* global PhSettings, PhTabulatorLocale, swal, KTUtil, PhUtility */

jQuery(document).ready(function () {
  $('#ph_save').on('click', function () {
    save();
  });
});

function save() {
  var aRates = [];
  $('.curn-rate').each(function (index, element) {
    // element == this
    aRates.push({
      nId: $(element).data("id"),
      nRate: $(element).val()
    });
  });
  if (aRates.length > 0) {
    PhUtility.doSave({
      'vOperation': "cpy-Management-Currency-UpdateRates",
      'dDate': $('#editDate').val(),
      'aRates': aRates
    });
  }
}
