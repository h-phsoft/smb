<?php
$aStatus = cPhsCode::getArray(cPhsCode::STATUS);
$aUsers = cCpyUser::getArray();
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

<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemModalLabel"><?php echo getLabel($requestProg->Name); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="itemForm">
          <div class="tab-content">
            <div class="row py-1">
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-sm-4">
                <input id="boxId" type="hidden" value="0" />
                <input id="boxName" class="form-control form-control-sm" type="text" value="" required="true" />
              </div>
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Status'); ?></label>
              <div class="col-sm-4">
                <select id="boxStatus" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aStatus as $element) {
                    echo '<option value="' . $element->Id . '">' . $element->Name . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row py-1">
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Account'); ?></label>
              <div class="col-sm-4">
                <input id="boxAcc" type="hidden" value="">
                <input id="boxAccName" class="form-control form-control-sm phAutocomplete" data-acrel="boxAcc" data-acoperation="cpy-Account-Accounts-ListAutocompleteActives" autocomplete="off">
              </div>
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Cashier'); ?></label>
              <div class="col-sm-4">
                <select id="boxUser" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aUsers as $element) {
                    echo '<option value="' . $element->Id . '">' . $element->Name . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row py-1">
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>
              <div class="col-sm-10">
                <input id="boxRem" class="form-control form-control-sm" type="text" value=""/>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal"><i
            class="icon-2x flaticon2-cancel"></i></button>
        <button id="ph_save" type="button" class="btn btn-light-primary font-weight-bold"><i
            class="icon-2x flaticon2-check-mark"></i></button>
      </div>
    </div>
  </div>
</div>
