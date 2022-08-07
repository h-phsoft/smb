<?php
$aFundBoxes = cFundBox::getArray('status_id=1');
$aCurns = cMngCurrency::getArray('id>0 AND status_id=1');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
    </div>
    <div class="d-flex align-items-center">
      <?php include 'section/button_toggleCriteria.php'; ?>
      <?php include "section/button_export.php"; ?>
      <?php include "section/button_execute.php"; ?>
    </div>
  </div>
</div>
<div id="qryCriteria" class="mb-5 px-3 d-print-none">
  <div class="card card-custom">
    <div class="card-body">
      <form id="PhForm" class="form-horizontal">
        <div class="form-group-sm row pt-1">
          <label for="BoxId" class="control-label col-sm-1 text-center" data-acrel=''><?php echo getLabel('Fund Box'); ?></label>
          <div class="col-sm-4">
            <select id="BoxId" class="form-control form-control-sm form-select w-100">
              <option value="-1" selected>&nbsp;</option>
              <?php
              foreach ($aFundBoxes as $element) {
                ?>
                <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                <?php
                $selected = '';
              }
              ?>
            </select>
          </div>
          <label for="CurnId" class="control-label col-sm-1 text-center"><?php echo getLabel('Currency'); ?></label>
          <div class="col-md-2">
            <select id="CurnId" class="form-control form-control-sm form-select">
              <option value="-1" selected>&nbsp;</option>
              <?php
              foreach ($aCurns as $element) {
                echo '<option value="' . $element->Id . '">' . $element->Code . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group-sm row pt-1">
          <label for="AccName" class="control-label col-sm-1 text-center" data-acrel=''><?php echo getLabel('Account'); ?></label>
          <div class="col-sm-4">
            <input id="AccName" class="form-control form-control-sm phAutocomplete" data-acoperation='cpy-Account-Accounts-ListAutocompleteActives' type="text" data-rname="AccId" data-rbid="" title="" autocomplete="off" value="">
          </div>
          <label for="CostName" class="control-label col-sm-1 text-center"><?php echo getLabel('Cost Center'); ?></label>
          <div class="col-sm-2">
            <input id="CostName" class="form-control form-control-sm phAutocomplete" data-acoperation='cpy-Account-CostCenters-ListAutocompleteActives' type="text" data-rname="CostId" data-rbid="" title="" autocomplete="off" value="">
          </div>
        </div>
        <div class="form-group-sm row pt-1">
          <label for="FDate" class="control-label col-sm-1 text-center"><?php echo getLabel('Date'); ?></label>
          <div class="col-md-2">
            <div class="input-group date">
              <input id="FDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo '01-01-' . date('Y'); ?>" required="true" />
              <div class="input-group-append datepicker-btn">
                <span class="input-group-text">
                  <i class="la la-calendar"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group date">
              <input id="TDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
              <div class="input-group-append datepicker-btn">
                <span class="input-group-text">
                  <i class="la la-calendar"></i>
                </span>
              </div>
            </div>
          </div>
          <label for="vRem" class="control-label col-sm-1 text-center"><?php echo getLabel('Remarks'); ?></label>
          <div class="col-sm-4">
            <input id="MstRem" class="form-control form-control-sm" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
          </div>
        </div>
        <div class="form-group-sm row pt-1">
          <hr class="w-100">
        </div>
        <div id="queryOptions"  class="form-group-sm row pt-1">
        </div>
        <div class="form-group-sm row pt-1">
          <hr class="w-100">
        </div>
        <div id="displayColumns" class="form-group-sm row pt-1">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="container-fluid mt-5">
  <div class="row">
    <div class="col">
      <div id="tabulatorTable"></div>
    </div>
  </div>
</div>
