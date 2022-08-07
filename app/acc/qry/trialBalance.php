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
            <label for="MstFDate" class="control-label col-sm-1 text-center"><?php echo getLabel('Date'); ?></label>
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
          </div>
          <!--
          <div class="form-group-sm row pt-1">
            <label for="MstFDocD" class="control-label col-sm-1 text-center"><?php echo getLabel('Doc.Date'); ?></label>
            <div class="col-md-2">
              <div class="input-group date">
                <input id="MstFDocD" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group date">
                <input id="MstTDocD" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <label for="MstDocn" class="control-label col-sm-1 text-center"><?php echo getLabel('Doc.Number'); ?></label>
            <div class="col-md-1">
              <input id="MstFDocN" class="form-control form-control-sm" type="text" data-rname="MstDocn" data-rbid="" title="" autocomplete="off" value="0">
            </div>
            <div class="col-md-1">
              <input id="MstTDocN" class="form-control form-control-sm" type="text" data-rname="MstDocn" data-rbid="" title="" autocomplete="off" value="9999999999">
            </div>
            <label for="MstDoc" class="control-label col-sm-1 text-center"><?php echo getLabel('Doc.Name'); ?></label>
            <div class="col-sm-3">
              <select id="MstDoc" class="form-control form-control-sm form-select>
                <option value="-1">&nbsp;</option>
              </select>
            </div>
          </div>
          -->
          <div class="form-group-sm row pt-1">
            <label for="MstRem" class="control-label col-sm-1 text-center"><?php echo getLabel('Remarks'); ?></label>
            <div class="col-sm-4">
              <input id="MstRem" class="form-control form-control-sm" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
            </div>
            <label for="MsTrnRem" class="control-label col-sm-1 text-center"><?php echo getLabel('Description'); ?></label>
            <div class="col-sm-4">
              <input id="TrnRem" class="form-control form-control-sm" type="text" data-rname="MstRem" data-rbid="" title="" autocomplete="off" value="">
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
</div>
<div class="container-fluid mt-5">
  <div class="row">
    <div class="col">
      <div id="tabulatorTable"></div>
    </div>
  </div>
</div>
