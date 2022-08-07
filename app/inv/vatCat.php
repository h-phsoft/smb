<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
      <?php
      if ($oUser->oGrp->getPermission($requestProg->Id)->Insert || $oUser->oGrp->getPermission($requestProg->Id)->Update) {
        include "section/button_submit.php";
      }
      ?>
    </div>
    <div class="d-flex align-items-center">
      <?php
      if ($oUser->oGrp->getPermission($requestProg->Id)->Insert) {
        include "section/button_add.php";
      }
      if ($oUser->oGrp->getPermission($requestProg->Id)->Delete) {
        include "section/button_delete.php";
      }
      ?>
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="card card-custom">
      <div class="card-body py-2">
        <form id="ph_Form">
          <div class="tab-content">
            <div class="row pt-1">
              <input id="fldId" type="hidden" value="0" />
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldVal" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Value'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldVal" class="form-control form-control-sm" type="number" value="0" min="0" step="0.01" />
              </div>
              <label for="fldRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldRem" class="form-control form-control-sm" type="text" value="" />
              </div>
            </div>
          </div>
        </form>
        <hr width="80%">
      </div>
      <div class="card-body py-2">
        <div id="tabulatorTable"></div>
      </div>
    </div>
  </div>
</div>