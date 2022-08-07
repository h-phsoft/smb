<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
    </div>
    <div class="d-flex align-items-center">
      <?php include "section/button_add.php"; ?>
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="card card-custom">
      <div class="card-body">
        <div id="tabulatorTable"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ph_Modal" tabindex="-1" role="dialog" aria-labelledby="ph_Modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ph_ModalLabel"><?php echo getLabel($requestProg->Name); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_Form">
          <div class="tab-content">
            <div class="row pt-1">
              <label for="fldName" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldId" type="hidden" value=""/>
                <input id="fldName" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <label for="fldCode" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Code'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldCode" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldDir" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Direction'); ?></label>
              <div class="col-12 col-sm-4">
                <select id="fldDir" class="form-control form-control-sm form-select">
                  <option value="ltr">Left to Right</option>
                  <option value="rtl">Right to Left</option>
                </select>
              </div>
              <label for="fldRem" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldRem" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
        <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
      </div>
    </div>
  </div>
</div>

