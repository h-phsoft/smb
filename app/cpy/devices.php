<?php
$aDays = cPhsCode::getArray(cPhsCode::YES_NO);
$aStatuss = cPhsCode::getArray(cPhsCode::STATUS);
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
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
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldId" type="hidden" value=""/>
                <input id="fldName" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <label for="fldGuid" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('GUID'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldGuid" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <label for="fldStatusId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Status'); ?></label>
              <div class="col-12 col-sm-2">
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
              <label for="fldAddedAt" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('AddedAt'); ?></label>
              <div class="col-12 col-sm-2">
                <div class="input-group date">
                  <input id="fldAddedAt" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                  <div class="input-group-append datepicker-btn">
                    <span class="input-group-text">
                      <i class="la la-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldShour" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Syart Hour'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldShour" class="form-control form-control-sm" type="text" value="0" required="true" />
              </div>
              <label for="fldSminute" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Start Minute'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldSminute" class="form-control form-control-sm" type="text" value="0" required="true" />
              </div>
              <label for="fldEhour" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('End Hour'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldEhour" class="form-control form-control-sm" type="text" value="23" required="true" />
              </div>
              <label for="fldEminute" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('End Minute'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldEminute" class="form-control form-control-sm" type="text" value="59" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldDay1" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day1'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay1" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldDay2" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day2'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay2" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldDay3" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day3'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay3" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldDay4" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day4'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay4" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldDay5" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day5'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay5" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldDay6" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day6'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay6" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldDay7" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day7'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldDay7" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aDays as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
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
