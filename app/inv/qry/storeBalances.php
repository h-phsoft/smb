<?php
$aWarehoues = cStrStore::getArray('status_id=1');
$aStatus = cPhsCode::getArray(cPhsCode::STATUS);
$aUnit = cCpyCode::getArray(cCpyCode::UNIT);
$aSpc1 = cCpyCode::getArray(cCpyCode::STR_CLASSIFICATION1);
$aSpc2 = cCpyCode::getArray(cCpyCode::STR_CLASSIFICATION2);
$aSpc3 = cCpyCode::getArray(cCpyCode::STR_CLASSIFICATION3);
$aLoc1 = cCpyCode::getArray(cCpyCode::STR_LOCATION1);
$aLoc2 = cCpyCode::getArray(cCpyCode::STR_LOCATION2);
$aLoc3 = cCpyCode::getArray(cCpyCode::STR_LOCATION3);
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
            <label for="MstStore" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Warehouse'); ?>
            </label>
            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-9">
              <select id="MstStore" class="form-control form-control-sm form-select">
                <option value=""></option>
                <?php
                foreach ($aWarehoues as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Num . ' - ' . $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="ItemName" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Item'); ?>
            </label>
            <div class="col-md-2">
              <input id="ItemName" class="form-control form-control-sm" type="text" data-rname="ItemId" data-rbid="" title="" autocomplete="off" value="">
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="MstDate" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Date'); ?>
            </label>
            <div class="col-md-2">
              <div class="input-group date">
                <input id="MstDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <label for="ItemStatus" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Status'); ?>
            </label>
            <div class="col-md-2">
              <select id="ItemStatus" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aStatus as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="ItemUnit" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('Unit'); ?>
            </label>
            <div class="col-md-2">
              <select id="ItemUnit" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aUnit as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="ItemSpc1" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('specification1'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="ItemSpc1" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aSpc1 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="ItemSpc2" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('specification2'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="ItemSpc2" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aSpc2 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="ItemSpc3" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('specification3'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="ItemSpc3" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aSpc3 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group-sm row pt-1">
            <label for="SItemLoc1" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('location1'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="SItemLoc1" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aLoc1 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="SItemLoc2" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('location2'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="SItemLoc2" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aLoc2 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <label for="SItemLoc3" class="control-label  col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
              <?php echo getLabel('location3'); ?>
            </label>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-9">
              <select id="SItemLoc3" class="form-control form-control-sm form-select">
                <option value="-1">&nbsp;</option>
                <?php
                foreach ($aLoc3 as $itm) {
                  ?>
                  <option value="<?php echo $itm->Id; ?>"><?php echo $itm->Name; ?></option>
                  <?php
                }
                ?>
              </select>
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
          <div id="displayColumns" class="form-group-sm row pt-1">
          </div>
        </form>
      </div>
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
