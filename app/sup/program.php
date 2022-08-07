<?php
$aProgs = cPhsProgram::getArray();
$aStatuss = cPhsCode::getArray(cPhsCode::STATUS);
$aSyss = cPhsSystem::getArray();
$aTypes = cPhsCode::getArray(cPhsCode::PROGRAM_TYPE);
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
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
            <div class="row">
              <label for="fldId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Id'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldId" class="form-control form-control-sm" type="text" value="" dir="ltr" required="true" />
              </div>
              <label for="fldOrd" class="col-form-label col-sm-1 text-lg-right text-left">#</label>
              <div class="col-12 col-sm-1">
                <input id="fldOrd" class="form-control form-control-sm" type="text" value="0" dir="ltr" required="true" />
              </div>
              <label for="fldGrpId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Group'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldGrp" class="form-control form-control-sm" type="text" value="127" dir="ltr" required="true" />
              </div>
              <label for="fldOpen" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Open'); ?></label>
              <div class="col-12 col-sm-1">
                <input id="fldOpen" class="form-control form-control-sm" type="text" value="0" dir="ltr" required="true" />
              </div>
            </div>
            <div class="row">
              <label for="fldProgId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Parent'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldProgId" type="hidden" value="">
                <input id="fldProgName" class="form-control form-control-sm phAutocomplete" data-acoperation="phs-Management-Programs-ListAutocomplete" data-acrel="fldProgId" required="true" dir="ltr" value="">
              </div>
              <label for="fldSysId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('System'); ?></label>
              <div class="col-12 col-sm-4">
                <select id="fldSysId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aSyss as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <label for="fldTypeId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>
              <div class="col-12 col-sm-4">
                <select id="fldTypeId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aTypes as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldStatusId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Status'); ?></label>
              <div class="col-12 col-sm-4">
                <select id="fldStatusId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aStatuss as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <label for="fldName" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" dir="ltr" required="true" />
              </div>
              <label for="fldIcon" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Icon'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldIcon" class="form-control form-control-sm" type="text" value="" dir="ltr"/>
              </div>
            </div>
            <div class="row">
              <label for="fldFile" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('File'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldFile" class="form-control form-control-sm" type="text" value="" dir="ltr"/>
              </div>
              <label for="fldCss" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('CSS'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldCss" class="form-control form-control-sm" type="text" value="" dir="ltr"/>
              </div>
            </div>
            <div class="row">
              <label for="fldJs" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('JS'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldJs" class="form-control form-control-sm" type="text" value="" dir="ltr" required="true" />
              </div>
              <label for="fldAttributes" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Attributes'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldAttributes" class="form-control form-control-sm" type="text" value="" dir="ltr"/>
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

