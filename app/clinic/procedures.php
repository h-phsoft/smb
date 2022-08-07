<?php
$aCats = cClncProcedureCategory::getArray();
$aVats = cPhsCode::getArray(cPhsCode::VAT);
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
    </div>
    <div class="d-flex align-items-center">
      <?php
      if ($oUser->oGrp->getPermission($requestProg->Id)->Insert) {
        include "section/button_add.php";
      }
      ?>
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
                <input id="fldId" type="hidden" value="" />
              <label for="fldCatId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Cat'); ?></label>
              <div class="col-12 col-sm-8">
                <select id="fldCatId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aCats as $element) {
                  ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldCode" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Code'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldCode" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-11">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldPrice" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Price'); ?></label>
              <div class="col-12 col-sm-4">
                <input id="fldPrice" class="form-control form-control-sm" type="number" step="0.01" min="0" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldVatId" class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('VatId'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldVatId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aVats as $element) {
                  ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldVat" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Vat'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldVat" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
        <?php
        if ($oUser->oGrp->getPermission($requestProg->Id)->Insert) {
        ?>
          <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>