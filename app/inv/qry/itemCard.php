<?php
$RelId = ph_Get_Post('RelId');
$RelText = ph_Get_Post('RelText');
$aWarehoues = cStrStore::getArray('status_id=1');
$aTrnTypes = cCpyCode::getArray(cCpyCode::STR_TRN_TYPE);
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
<div id="qryCriteria" class="mb-5 d-print-none">
  <div class="container-fluid">
    <div class="card card-custom">
      <div class="card-body">
        <form id="PhForm" class="form-horizontal">
          <div class="form-group-sm row pt-1">
            <label for="MstStore" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Warehouse'); ?>
            </label>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9">
              <select id="MstStore" class="form-control form-control-sm form-select">
                <?php
                foreach ($aWarehoues as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Num . ' - ' . $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="ItemName" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Item'); ?>
            </label>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9">
              <input id="ItemId" type="hidden" value="<?php echo $RelId; ?>">
              <input id="ItemName" class="form-control form-control-sm phAutocomplete" type="text" data-acoperation='cpy-Warehouse-Material-ListAutocompleteItems' data-acrel="ItemId" title="" autocomplete="off" value="<?php echo $RelText; ?>">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="MstDate" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
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
            <label for="MstTrt" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Trn.Type'); ?></label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="MstTrt" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aTrnTypes as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="MstNum" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Number'); ?></label>
            <div class="col-md-1">
              <input id="MstFNum" class="form-control form-control-sm" type="text" data-rname="MstNum" data-rbid="" title="" autocomplete="off" value="0">
            </div>
            <div class="col-md-1">
              <input id="MstTNum" class="form-control form-control-sm" type="text" data-rname="MstNum" data-rbid="" title="" autocomplete="off" value="9999999999">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="MstDocd" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Doc.Date'); ?></label>
            <div class="col-md-2">
              <div class="input-group date">
                <input id="MstDocD" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo $oWorkperiod->SDate; ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group date">
                <input id="MstDocD1" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo $oWorkperiod->EDate; ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <label for="MstDoc" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Document'); ?></label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="MstDoc" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
              </select>
            </div>
            <label for="MstDocn" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Doc.Number'); ?></label>
            <div class="col-md-1">
              <input id="MstFDocn" class="form-control form-control-sm MstDocn" type="text" data-rname="MstDocn" data-rbid="" title="" autocomplete="off" value="0">
            </div>
            <div class="col-md-1">
              <input id="MstTDocn" class="form-control form-control-sm MstDocn" type="text" data-rname="MstDocn" data-rbid="" title="" autocomplete="off" value="9999999999">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="AccName" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Account'); ?></label>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9">
              <input id="AccId" type="hidden" autocomplete="off" value="">
              <input id="AccName" class="form-control form-control-sm AccName ui-autocomplete-input" type="text" data-rname="AccId" data-rbid="" title="" autocomplete="off" value="">
            </div>
            <label for="CostName" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Cost Center'); ?></label>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9">
              <input id="CostId" type="hidden" autocomplete="off" value="">
              <input id="CostName" class="form-control form-control-sm CostName ui-autocomplete-input" type="text" data-rname="CostId" data-rbid="" title="" autocomplete="off" value="">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="MstRem" class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center"><?php echo getLabel('Remarks'); ?></label>
            <div class="col-lg-4 col-md-4 col-sm-10 col-xs-9">
              <input id="MstRem" class="form-control form-control-sm MstRem" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <hr class="w-100">
          </div>
          <div id="queryOptions" class="form-group-sm row pt-1">
          </div>
          <div class="form-group-sm row pt-1">
            <hr class="w-100">
          </div>
          <div id="displayColumns" class="row g-5 pt-1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div id="tabulatorTable"></div>
      </div>
    </div>
  </div>
</div>
