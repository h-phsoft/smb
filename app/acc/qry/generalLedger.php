<?php
$aCurrens = cMngCurrency::getArray('id>0');
$RelId = ph_Get_Post('RelId');
$RelText = ph_Get_Post('RelText');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?>
      </h5>
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
          <label for="AccName" class="control-label col-sm-1 text-center"><?php echo getLabel('Account'); ?></label>
          <div class="col-sm-4">
            <input id="AccId" type="hidden" value="<?php echo $RelId; ?>">
            <input id="AccName" class="form-control form-control-sm phAutocomplete" data-acoperation='cpy-Account-Accounts-ListAutocompleteActives' type="text" data-acrel="AccId" value="<?php echo $RelText; ?>">
          </div>
          <label for="CostName"
                 class="control-label col-sm-1 text-center"><?php echo getLabel('Cost Center'); ?></label>
          <div class="col-sm-2">
            <input id="CostName" class="form-control form-control-sm phAutocomplete" data-acoperation='cpy-Account-CostCenters-ListAutocompleteActives' type="text" value="">
          </div>
        </div>
        <div class="form-group-sm row pt-1">
          <label for="MstDate" class="control-label col-sm-1 text-center">
            <?php echo getLabel('Date'); ?>
          </label>
          <div class="col-md-2">
            <div class="input-group date">
              <input id="MstFDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo $oWorkperiod->SDate; ?>" required="true" />
              <div class="input-group-append datepicker-btn">
                <span class="input-group-text">
                  <i class="la la-calendar"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group date">
              <input id="MstTDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo $oWorkperiod->EDate; ?>" required="true" />
              <div class="input-group-append datepicker-btn">
                <span class="input-group-text">
                  <i class="la la-calendar"></i>
                </span>
              </div>
            </div>
          </div>
          <label for="MstNum" class="control-label col-sm-1 text-center"><?php echo getLabel('Number'); ?></label>
          <div class="col-md-1">
            <input id="MstFNum" class="form-control form-control-sm" type="text" data-rname="MstNum" data-rbid="" title="" autocomplete="off" value="0">
          </div>
          <div class="col-md-1">
            <input id="MstTNum" class="form-control form-control-sm" type="text" data-rname="MstNum" data-rbid="" title="" autocomplete="off" value="9999999999">
          </div>
          <label for="MstNum" class="control-label col-sm-1 text-center"><?php echo getLabel('Currency'); ?></label>
          <div class="col-md-1">
            <select id="CurnId" class="form-control form-control-sm form-select">
              <option value="-1" selected>&nbsp;</option>
              <?php
              foreach ($aCurrens as $element) {
                echo '<option value="' . $element->Id . '">' . $element->Code . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <!--
        <div class="form-group-sm row pt-1">
          <label for="MstDocd"
            class="control-label col-sm-1 text-center"><?php echo getLabel('تاريخ المستند'); ?></label>
        <div class="col-md-2">
          <div class="input-group date">
            <input id="MstFDocD" class="form-control form-control-sm ph_datepicker" type="text"
              readonly="readonly"
              value="<?php echo date('Y-m-d'); ?>"
              required="true" />
            <div class="input-group-append datepicker-btn">
              <span class="input-group-text">
                <i class="la la-calendar"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group date">
            <input id="MstTDocD" class="form-control form-control-sm ph_datepicker" type="text"
              readonly="readonly"
              value="<?php echo date('Y-m-d'); ?>"
              required="true" />
            <div class="input-group-append datepicker-btn">
              <span class="input-group-text">
                <i class="la la-calendar"></i>
              </span>
            </div>
          </div>
        </div>
        <label for="MstDocn" class="control-label col-sm-1 text-center"><?php echo getLabel('رقم المستند'); ?></label>
        <div class="col-md-1">
          <input id="MstFDocn" class="form-control form-control-sm" type="text" data-rname="MstDocn"
            data-rbid="" title="" autocomplete="off" value="0">
        </div>
        <div class="col-md-1">
          <input id="MstTDocn" class="form-control form-control-sm" type="text" data-rname="MstDocn"
            data-rbid="" title="" autocomplete="off" value="9999999999">
        </div>
        <label for="MstDoc" class="control-label col-sm-1 text-center"><?php echo getLabel('المستند'); ?></label>
        <div class="col-sm-3">
          <select id="MstDoc" class="form-control form-control-sm form-select">
            <option value="-1">&nbsp;</option>
          </select>
        </div>
    </div>
        -->
        <div class="form-group-sm row pt-1">
          <label for="MstRem" class="control-label col-sm-1 text-center"><?php echo getLabel('Remark'); ?></label>
          <div class="col-sm-4">
            <input id="MstRem" class="form-control form-control-sm" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
          </div>
          <label for="TrnRem" class="control-label col-sm-1 text-center"><?php echo getLabel('Description'); ?></label>
          <div class="col-sm-6">
            <input id="TrnRem" class="form-control form-control-sm" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
          </div>
        </div>
        <div class="form-group-sm row pt-1">
          <hr class="w-100">
        </div>
        <div id="queryOptions"  class="form-group-sm row">
        </div>
        <div class="form-group-sm row pt-1">
          <hr class="w-100">
        </div>
        <div id="displayColumns" class="form-group-sm row">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="container-fluid pt-5">
  <div class="row">
    <div class="col">
      <div id="tabulatorTable"></div>
    </div>
  </div>
</div>