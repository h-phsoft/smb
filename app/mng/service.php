<?php
$aUnits = cCpyCode::getArray(cCpyCode::UNIT);
?>
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
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
              <label for="fldCode" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Code'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldId" type="hidden" value=""/>
                <input id="fldCode" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <div class="col-12 col-sm-3">
              </div>
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldAccCid" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Cost Account'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldAccCid" type="hidden" value="" required="true" />
                <input id="fldAccCName" class="form-control form-control-sm phAutocomplete" data-acrel="fldAccCid" data-acoperation="cpy-Account-Accounts-ListAutocompleteActives" type="text" value="" required="true" />
              </div>
              <label for="fldAccRid" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Revenue Account'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldAccRid" type="hidden" value="" required="true" />
                <input id="fldAccRName" class="form-control form-control-sm phAutocomplete" data-acrel="fldAccRid" data-acoperation="cpy-Account-Accounts-ListAutocompleteActives" type="text" value="" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldCostId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Cost Center'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldCostId" type="hidden" value="" required="true" />
                <input id="fldCostName" class="form-control form-control-sm phAutocomplete" data-acrel="fldCostId" data-acoperation="cpy-Account-CostCenters-ListAutocompleteActives" type="text" value="" required="true" />
              </div>
              <label for="fldUnitId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Unit'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldUnitId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aUnits as $element) {
                    echo '<option value="' . $element->Id . '">' . $element->Name . '</option>';
                  }
                  ?>
                </select>
              </div>
              <label for="fldCst" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Cost'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldCst" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldRem" class="form-control form-control-sm" type="text" value=""/>
              </div>
              <label for="fldGrp" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Group'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldGrp" class="form-control form-control-sm" type="text" value=""/>
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

