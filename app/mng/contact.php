<?php
$aNats = cCpyCode::getArray(cCpyCode::NATIONALITY);
$aStatuss = cPhsCode::getArray(cPhsCode::STATUS);
$aTypes = cPhsCode::getArray(cPhsCode::CONTACT_TYPE);
$aClass = cCpyCode::getArray(cCpyCode::CONTACT_CLASS);
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?>
      </h5>
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
        <h5 class="modal-title" id="ph_ModalLabel"><?php echo getLabel($requestProg->Name); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_Form">
          <div class="tab-content">
            <div class="row">
              <label for="fldNum" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Num'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldId" type="hidden" value="" />
                <input id="fldNum" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldTitle" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('cont.Title'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldTitle" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
            </div>
            <div class="row">
              <label for="fldLegal" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Legal'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldLegal" class="form-control form-control-sm" type="text" value="" autocomplete="off" />
              </div>
              <label for="fldOwner" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Owner'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldOwner" class="form-control form-control-sm" type="text" value="" autocomplete="off" />
              </div>
            </div>
            <div class="row">
              <label for="fldPerson" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Person'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldPerson" class="form-control form-control-sm" type="text" value="" autocomplete="off" />
              </div>
              <label for="fldTypeId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>
              <div class="col-12 col-sm-2">
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
            </div>
            <div class="row">
              <label for="fldPhone" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Phone'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldPhone" class="form-control form-control-sm" type="text" value="" required="true" autocomplete="off" />
              </div>
              <label for="fldMobile" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Mobile'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldMobile" class="form-control form-control-sm" type="text" value="" required="true" autocomplete="off" />
              </div>
              <label for="fldEmail" class="col-form-label col-sm-1 text-lg-right text-left px-0"><?php echo getLabel('Email'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldEmail" class="form-control form-control-sm" type="text" dir="ltr" value="" autocomplete="off" />
              </div>
              <label for="fldNatId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Nationality'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldNatId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aNats as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <label for="fldAddress" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Address'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldAddress" class="form-control form-control-sm" type="text" value="" autocomplete="off"/>
              </div>
              <label for="fldNlmt" class="col-form-label col-sm-1 text-lg-right text-left px-0"><?php echo getLabel('Credit Limit'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldNlmt" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <label for="fldDlmt" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Day Limit'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldDlmt" class="form-control form-control-sm" type="text" value="" required="true"/>
              </div>
            </div>
            <div class="row">
              <label for="fldClass1Id" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Class.'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldClass1Id" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aClass as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-sm-2">
                <select id="fldClass2Id" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aClass as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-sm-2">
                <select id="fldClass3Id" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aClass as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-sm-2">
                <select id="fldClass4Id" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aClass as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-sm-2">
                <select id="fldClass5Id" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aClass as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-1 text-right">
                <span id="addRow" class="btn btn-sm btn-primary font-weight-bolder text-uppercase pl-3 pr-2" data-toggle="tooltip" title="<?php echo getLabel('Add new Row'); ?>" data-original-title="<?php echo getLabel('Add new Row'); ?>">
                  <i class="icon-md text-light ki ki-plus"></i>
                </span>
              </div>
            </div>
            <div class="row pt-4">
              <div class="col-12">
                <div id="phTable" style="overflow-x: auto;"></div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2"
                data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
        <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center pl-4 pr-2"><i
            class="icon-2x flaticon2-check-mark"></i></button>
      </div>
    </div>
  </div>
</div>
