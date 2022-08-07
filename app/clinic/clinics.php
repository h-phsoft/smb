<?php
$aStatuss = cPhsCode::getArray(cPhsCode::STATUS);
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

<div class="container-fluid" id="Cards">

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
              <input id="fldId" type="hidden">
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldPrefix" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Prefix'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldPrefix" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
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
            <div class="row pt-1">
              <label for="fldEmail" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Email'); ?></label>
              <div class="col-12 col-sm-5">
                <input id="fldEmail" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldPhone1" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Phone1'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldPhone1" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldPhone2" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Phone2'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldPhone2" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div>
              <!-- <label for="fldPhone3" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Phone3'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldPhone3" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
              </div> -->
            </div>
            <div class="row pt-1">
              <label for="fldAddress" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Address'); ?></label>
              <div class="col-12 col-sm-11">
                <input id="fldAddress" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
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