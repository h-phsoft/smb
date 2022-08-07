<?php
$aCurns = cMngCurrency::getArray('id>0');
$aTypes = cPhsCode::getArray(cPhsCode::FIN_ELEMENT_TYPE,'id<3');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
      <?php
      if ($oUser->oGrp->getPermission($requestProg->Id)->Insert || $oUser->oGrp->getPermission($requestProg->Id)->Update) {
        include "section/button_submit.php";
      }
      if ($oUser->oGrp->getPermission($requestProg->Id)->Query) {
        include "section/button_search.php";
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
      <div class="card-body">
        <form id="ph_Form">
          <div class="tab-content">
            <div class="row pt-1">
              <input id="fldId" type="hidden"  />
              <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldName" class="form-control form-control-sm" type="text" value="" />
              </div>
              <label for="fldCurnId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Currency'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldCurnId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aCurns as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Code; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label for="fldSdate" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Sdate'); ?></label>
              <div class="col-12 col-sm-2">
                <div class="input-group date">
                  <input id="fldSdate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                  <div class="input-group-append datepicker-btn">
                    <span class="input-group-text">
                      <i class="la la-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <label for="fldEdate" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Edate'); ?></label>
              <div class="col-12 col-sm-2">
                <div class="input-group date">
                  <input id="fldEdate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                  <div class="input-group-append datepicker-btn">
                    <span class="input-group-text">
                      <i class="la la-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Rem'); ?></label>
              <div class="col-12 col-sm-11">
                <input id="fldRem" class="form-control form-control-sm" type="text" value="" autocomplete="off" />
              </div>
            </div>
          </div>
        <hr width="50%">
          <div class="tab-content">
            <div class="row pt-1">
              <input id="fldtId" type="hidden" value="" />
              <input id="fldTIndex" type="hidden" value="-1" />
              <label for="fldtTypeId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>
              <div class="col-12 col-sm-2">
                <select id="fldtTypeId" class="form-control form-control-sm form-select">
                  <?php
                  foreach ($aTypes as $element) {
                    ?>
                    <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
              <div class="col-12 col-sm-7">
                <input id="fldDNameId" type="hidden" value="">
                <input id="fldDName1" class="form-control form-control-sm fldDName  phAutocomplete" data-acrel="fldDNameId" data-acoperation="cpy-Warehouse-Material-ListAutocompleteItems"  value="" >
                <input id="fldDName2" class="form-control form-control-sm fldDName d-none phAutocomplete" data-acrel="fldDNameId" data-acoperation="cpy-Management-Service-ListAutocomplete"  value="" >
              </div>
            </div>
            <div class="row pt-1">
              <label for="fldtPrice" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Price'); ?></label>
              <div class="col-12 col-sm-2">
                <input id="fldtPrice" class="form-control form-control-sm" type="number" min="0" step="0.01" value="" autocomplete="off" required="true" />
              </div>
              <label for="fldtRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Rem'); ?></label>
              <div class="col-12 col-sm-7">
                <input id="fldtRem" class="form-control form-control-sm" type="text" value="" autocomplete="off" />
              </div>
              <div class="col-12 col-sm-1 text-center">
                <span id="addRow" class="btn btn-sm btn-primary font-weight-bolder text-uppercase pl-3 pr-2" data-toggle="tooltip" title="<?php echo getLabel('Add new Row'); ?>" data-original-title="<?php echo getLabel('Add new Row'); ?>">
                  <i class="icon-md text-light ki ki-plus"></i>
                </span>
              </div>
            </div>
            <div class="row p-1">
              <div class="col-12">
                <table id="dataTable" class="table table-bordered table-striped table-details" style="width: 100%;">
                  <thead>
                    <tr>
                      <td style="width: 3%;"></td>
                      <td><?php echo getLabel('Type'); ?></td>
                      <td><?php echo getLabel('Name'); ?></td>
                      <td><?php echo getLabel('Price'); ?></td>
                      <td><?php echo getLabel('Rem'); ?></td>
                      <td style="width: 3%;"></td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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
        <div id="tabulatorTable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
      </div>
    </div>
  </div>
</div>

