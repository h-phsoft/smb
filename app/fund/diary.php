<?php
$aFundBoxes = cFundBox::getArray('status_id=1');
$aCurns = cMngCurrency::getArray('id>0 AND status_id=1');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid">
    <div class="row d-flex justify-content-between">
      <div class="col-md-3 d-flex align-items-center">
        <select id="lstBox" class="form-control form-control-sm form-select w-100">
          <?php
          $selected = 'selected';
          foreach ($aFundBoxes as $element) {
            ?>
            <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
            <?php
            $selected = '';
          }
          ?>
        </select>
      </div>
      <div class="col-md-3 text-right d-flex align-items-center">
        <a href="javascript:;" id="btnPrevious" class="btn btn-outline-warning btn-md py-2 pl-3 pr-2 font-size-base text-center">
          <i class="la la-lg la-chevron-<?php echo strtolower($vDir) == 'ltr' ? 'left' : 'right'; ?>"></i>
        </a>
        <div class="input-group date">
          <input id="diaryDate" class="form-control form-control-sm ph_datepicker" readonly="" value="<?php echo date("Y-m-d"); ?>">
          <div class="input-group-append datepicker-btn">
            <span class="input-group-text">
              <i class="la la-calendar"></i>
            </span>
          </div>
        </div>
        <a href="javascript:;" id="btnNext" class="btn btn-outline-warning btn-md py-2 pl-3 pr-2 font-size-base text-center">
          <i class="la la-lg la-chevron-<?php echo strtolower($vDir) == 'ltr' ? 'right' : 'left'; ?>"></i>
        </a>
      </div>
      <div class="col-md-3 text-right d-flex align-items-center justify-content-between">
        <a href="javascript:;" id="btnRefresh" class="btn btn-light-info font-weight-bold btn-md py-2 pl-3 pr-2 font-size-base text-center" title="<?php echo getLabel("Refresh"); ?>">
          <i class="la la-lg la-refresh"></i>
        </a>
        <a href="javascript:;" id="btnPayment" class="btn btn-light-danger font-weight-bold btn-md py-2 pl-3 pr-2 font-size-base text-center" title="<?php echo getLabel("Fund Payment"); ?>">
          <i class="la la-lg la-caret-square-o-up"></i>
        </a>
        <a href="javascript:;" id="btnCollect" class="btn btn-light-success font-weight-bold btn-md py-2 pl-3 pr-2 font-size-base text-center" title="<?php echo getLabel("Fund Collection"); ?>">
          <i class="la la-lg la-caret-square-o-down"></i>
        </a>
        <a href="javascript:;" id="btnExchange" class="btn btn-light-warning font-weight-bold btn-md py-2 pl-3 pr-2 font-size-base text-center" title="<?php echo getLabel("Fund Exchange"); ?>">
          <i class="la la-lg la-minus-square-o"></i>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="col-12 card card-body">
    <div class="row">
      <div class="col-12" style="overflow-x: auto; min-height: 50vh;">
        <table class="table table-hover table-bordered table-striped form-table w-100" id="ListDataTable">
          <thead>
            <tr>
              <th style="padding: 5px 15px !important; width: 2%;"><i class="la la-flash"></i></th>
              <th style="padding: 5px 15px !important; width: 15%;"><?php echo getLabel("Box.Credit"); ?></th>
              <th style="padding: 5px 15px !important; width: 15%;"><?php echo getLabel("Box.Debit"); ?></th>
              <th style="padding: 5px 15px !important; width: 3%;"><?php echo getLabel("Currency"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Account"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Description"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Cost Center"); ?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-12 text-center" id="totals" style="overflow-x: auto;">
        <table class="table table-hover table-bordered table-striped form-table w-100" id="TotalDataTable">
          <thead>
            <tr>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Currency"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Open.Balance"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Trn.Credits"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Trn.Debits"); ?></th>
              <th style="padding: 5px 15px !important; width: 20%;"><?php echo getLabel("Blnc.Balance"); ?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <span id="phForm-Status" class="text-danger"></span>
    </div>
    <a id="downloadLink"></a>
  </div>
</div>

<div class="modal fade" id="fundModal" tabindex="-1" role="dialog" aria-labelledby="fundModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fundModalTitle"><?php echo getLabel($requestProg->Name); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="fundForm">
          <div class="row">
            <div class="col-8">
              <div class="form-group row">
                <div class="col-12 col-sm-2 text-right">
                  <input id="fldId" type="hidden" value="">
                  <input id="fldType" type="hidden" value="0">
                  <label><?php echo getLabel("Date"); ?></label>
                </div>
                <div class="col-8 col-sm-4">
                  <input id="fldDate" class="form-control form-control-sm ph_datepicker" value="<?php echo date("Y-m-d"); ?>">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12 col-sm-2 text-right">
                  <label><?php echo getLabel("Amount"); ?></label>
                </div>
                <div class="col-12 col-sm-4">
                  <input id="fldAmt" class="form-control form-control-sm font-size-h4" style="color: blue;" type="number" step="1" value="" lang="en-UK">
                </div>
                <div class="col-12 col-sm-2 text-right">
                  <label><?php echo getLabel("Currency"); ?></label>
                </div>
                <div class="col-12 col-sm-4">
                  <select id="fldCurn" class="form-control form-control-sm form-select">
                    <?php
                    foreach ($aCurns as $element) {
                      ?>
                      <option value='<?php echo $element->Id; ?>'><?php echo $element->Code; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12 col-sm-2 text-right">
                  <label><?php echo getLabel("Account"); ?></label>
                </div>
                <div class="col-12 col-sm-10">
                  <input id="fldAccId" type="hidden" value="">
                  <input id="fldAccName" class="form-control form-control-sm phAutocomplete" data-acrel="fldAccId" data-acoperation="cpy-Account-Accounts-ListAutocompleteActives" value="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12 col-sm-2 text-right">
                  <label><?php echo getLabel("Cost Center"); ?></label>
                </div>
                <div class="col-12 col-sm-10">
                  <input id="fldCntrId" type="hidden" value="">
                  <input id="fldCntrName" class="form-control form-control-sm phAutocomplete" data-acrel="fldCntrId" data-acoperation="cpy-Account-CostCenters-ListAutocompleteActives" value="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12 col-sm-2 text-right">
                  <label><?php echo getLabel("Description"); ?></label>
                </div>
                <div class="col-12 col-sm-10">
                  <input id="fldRem" class="form-control form-control-sm" value="" lang="ar">
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group row">
                <div class="col-12">
                  <label for="fldFile" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" style="position: absolute; right: 0px; top: -10px;" data-toggle="tooltip" title="" data-original-title="Change image">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                  </label>
                  <input id="fldFile" type="file" class="fileField d-none" value="" data-previewer="attPreview" data-relfld="fldAttach" data-filename="fldFileName"  data-relname="fldFName" data-relext="fldFExt" data-folder="item">
                  <input id="fldFName" type="hidden" value="">
                  <input id="fldFileName" type="hidden" value="">
                  <input id="fldFExt" type="hidden" value="">
                  <input id="fldAttach" type="hidden" value="">
                  <img id="attPreview" class="border border-info border-1" src="" style="width: 100%; min-height: 185px;">
                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow attache-clear" style="position: absolute; right: 0px; bottom: -10px;" data-rfield="fldFile" data-toggle="tooltip" title="Cancel image">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal">
          <i class="icon-2x flaticon2-cancel"></i>
        </button>
        <button id="ph_save" type="button" class="btn btn-light-primary font-weight-bold">
          <i class="icon-2x flaticon2-check-mark"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="fundExchangeModal" tabindex="-1" role="dialog" aria-labelledby="fundExchangeModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fundExchangeModalTitle"><?php echo getLabel($requestProg->Name); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="fundExchangeForm">
          <div class="col-12">
            <div class="form-group row">
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Date"); ?></label>
              </div>
              <div class="col-10 col-md-5 pt-1">
                <input id="fldExDate" class="form-control form-control-sm ph_datepicker" value="<?php echo date("Y-m-d"); ?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("From"); ?></label>
              </div>
              <div class="col-10 col-md-5 pt-1">
                <select id="lstFBox" class="form-control form-control-sm form-select w-100">
                  <?php
                  $selected = 'selected';
                  foreach ($aFundBoxes as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
                    <?php
                    $selected = '';
                  }
                  ?>
                </select>
              </div>
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Amount"); ?></label>
              </div>
              <div class="col-10 col-md-2 pt-1">
                <input id="fldExFAmt" class="form-control form-control-sm font-size-h4" style="color: red;" type="number" step="1" min="0" value="" lang="en-UK">
              </div>
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Currency"); ?></label>
              </div>
              <div class="col-10 col-md-2 pt-1">
                <select id="fldExFCurn" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aCurns as $element) {
                    ?>
                    <option value='<?php echo $element->Id; ?>'><?php echo $element->Code; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("To"); ?></label>
              </div>
              <div class="col-10 col-md-5 pt-1">
                <select id="lstTBox" class="form-control form-control-sm form-select w-100">
                  <?php
                  $selected = 'selected';
                  foreach ($aFundBoxes as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
                    <?php
                    $selected = '';
                  }
                  ?>
                </select>
              </div>
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Amount"); ?></label>
              </div>
              <div class="col-10 col-md-2 pt-1">
                <input id="fldExTAmt" class="form-control form-control-sm font-size-h4" style="color: blue;" type="number" step="1" min="0" value="" lang="en-UK">
              </div>
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Currency"); ?></label>
              </div>
              <div class="col-10 col-md-2 pt-1">
                <select id="fldExTCurn" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aCurns as $element) {
                    ?>
                    <option value='<?php echo $element->Id; ?>'><?php echo $element->Code; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Account"); ?></label>
              </div>
              <div class="col-10 col-md-5 pt-1">
                <input id="fldExAccId" type="hidden" value="">
                <input id="fldExAccName" class="form-control form-control-sm phAutocomplete" data-acrel="fldExAccId" data-acoperation="cpy-Account-Accounts-ListAutocompleteActives" value="">
              </div>
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Cost Center"); ?></label>
              </div>
              <div class="col-10 col-md-5 pt-1">
                <input id="fldExCntrId" type="hidden" value="">
                <input id="fldExCntrName" class="form-control form-control-sm phAutocomplete" data-acrel="fldExCntrId" data-acoperation="cpy-Account-CostCenters-ListAutocompleteActives" value="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-2 col-md-1 text-right">
                <label class="pt-3"><?php echo getLabel("Description"); ?></label>
              </div>
              <div class="col-10 col-md-11 pt-1">
                <input id="fldExRem" class="form-control form-control-sm" value="" lang="ar">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal">
          <i class="icon-2x flaticon2-cancel"></i>
        </button>
        <button id="ph_exchangeSave" type="button" class="btn btn-light-primary font-weight-bold">
          <i class="icon-2x flaticon2-check-mark"></i>
        </button>
      </div>
    </div>
  </div>
</div>
