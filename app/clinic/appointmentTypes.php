<?php
$aColors = cPhsCodColor::getArray();
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
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="card card-custom">
      <div class="card-body">
        <div id="tabulatorTable"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ph_Modal" tabindex="-1" role="dialog" aria-labelledby="ph_Modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
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
              <div class="col-sm-8">
                <div class="row pt-1">
                  <input id="fldId" type="hidden" value="" />
                  <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
                  <div class="col-12 col-sm-11">
                    <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                  </div>
                </div>
                <div class="row pt-1">
                  <label for="fldCapacity" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Capacity'); ?></label>
                  <div class="col-12 col-sm-5">
                    <input id="fldCapacity" class="form-control form-control-sm" type="number" value="0" min="0" max="250" autocomplete="off" required="true" />
                  </div>
                  <label for="fldTime" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Time'); ?></label>
                  <div class="col-12 col-sm-5">
                    <input id="fldTime" class="form-control form-control-sm" type="number" value="<?php echo $nAppTime; ?>" min="<?php echo $nAppTime; ?>" max="2400" step="<?php echo $nAppTime; ?>" />
                  </div>
                </div>
                <div class="row pt-1">
                  <label for="fldTbgId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Box'); ?></label>
                  <div class="col-12 col-sm-11">
                    <select id="fldTbgId" class="form-control form-control-sm form-select" data-style="btn-success">
                      <?php
                      foreach ($aColors as $element) {
                        $vClass = $element->Bgclass;
                        ?>
                        <option class="<?php echo $vClass ?>" value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="row pt-1">
                  <label for="fldTfgId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
                  <div class="col-12 col-sm-11">
                    <select id="fldTfgId" class="form-control form-control-sm form-select" data-style="btn-success">
                      <?php
                      foreach ($aColors as $element) {
                        $vClass = $element->Bgclass;
                        ?>
                        <option class="<?php echo $vClass ?>" value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="row pt-1">
                  <label for="fldNfgId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Patient'); ?></label>
                  <div class="col-12 col-sm-11">
                    <select id="fldNfgId" class="form-control form-control-sm form-select" data-style="btn-success">
                      <?php
                      foreach ($aColors as $element) {
                        $vClass = $element->Bgclass;
                        ?>
                        <option class="<?php echo $vClass ?>" value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <label class="col-form-label col-sm-12 text-center"><?php echo getLabel('Appointment Sample'); ?></label>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <div class="card border-success m-0 text-wrap" style="height: 100%;">
                          <div id="atTypeName" class="card-header p-3"><?php echo getLabel('Type'); ?></div>
                          <div class="card-body p-5 m-0">
                            <h5 id="atPatientName" class="card-title m-0 p-1"><?php echo getLabel('Patient'); ?></h5>
                          </div>
                          <div class="card-footer px-5 py-1 bg-light">
                            <i id="statusIcon" class="icon-md flaticon-calendar-with-a-clock-time-tools"></i> <?php echo getLabel('Status'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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