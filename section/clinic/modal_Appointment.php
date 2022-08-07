<?php
$aSpecial = cCpyCode::getArray(cCpyCode::CLNC_SPECIAL);
$aDoctors = cCpyUser::getArray();
$aClinics = cClncClinic::getArray();
$aAppTypes = cClncAppType::getArray();
$nStartTime = intval(cCpyPref::getPref('WORK-START-TIME'));
$nEndTime = intval(cCpyPref::getPref('WORK-END-TIME'));
$nAppTime = intval(cCpyPref::getPref('WORK-APP-TIME'));

$modalProgram = cPhsProgram::getInstanceByFile('clinic/appointments');
if ($modalProgram->Id != -999) {
  if (($oUser->oGrp->Id <= 0) ||
          (is_array($oUser->oGrp->aPerms) &&
          isset($oUser->oGrp->aPerms[$modalProgram->Id]) &&
          $oUser->oGrp->aPerms[$modalProgram->Id]->isOK)
  ) {
    ?>
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="addAppointmentModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addAppointmentModalLabel"><?php echo getLabel('Add Appointment'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="ki ki-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="ph_AddAppointment_form">
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Clinic'); ?></label>
                    <div class="col-9 col-sm-10">
                      <input id="appId" class="form-control" type="hidden" value="0">
                      <select id="appClinic" class="form-control form-control-sm form-select" required="true">
                        <?php
                        for ($index = 0; $index < count($oUser->aClinics); $index++) {
                          $selected = '';
                          if ($oUser->aClinics[$index]->Id == intval(ph_Session('UClinicId'))) {
                            $selected = 'selected';
                          }
                          ?>
                          <option value="<?php echo $oUser->aClinics[$index]->Id; ?>" <?php echo $selected; ?>><?php echo $oUser->aClinics[$index]->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Speciality'); ?></label>
                    <div class="col-9 col-sm-10">
                      <select id="appSpecial" class="form-control form-control-sm form-select" data-toggle="tooltip">
                        <?php
                        $selected = 'selected';
                        foreach ($aSpecial as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
                          <?php
                          $selected = '';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Doctor'); ?>*</label>
                    <div class="col-9 col-sm-10">
                      <select id="appDoctor" class="form-control form-control-sm form-select" required="true" data-live-search="true">
                        <option value="" selected>Please Select</option>
                        <?php
                        foreach ($aDoctors as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>
                    <div class="col-9 col-sm-10">
                      <select id="appType" class="form-control form-control-sm form-select" required="true" data-live-search="true">
                        <?php
                        $selected = 'selected';
                        foreach ($aAppTypes as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
                          <?php
                          $selected = '';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Date'); ?></label>
                    <div class="col-12 col-sm-4">
                      <div class="input-group date">
                        <input id="appDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                        <div class="input-group-append datepicker-btn">
                          <span class="input-group-text">
                            <i class="la la-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <label for="appHour" class="col-form-label col-sm-1 text-lg-right text-left "><?php echo getLabel('Time'); ?></label>
                    <div class="col-2 col-sm-2">
                      <select id="appHour" class="form-control form-control-sm form-select" required="true">
                        <?php
                        $selected = 'selected';
                        if ($nEndTime < $nStartTime) {
                          $nAStartTime = 0;
                          $nAEndTime = $nEndTime;
                          for ($index1 = $nAStartTime; $index1 < $nAEndTime; $index1++) {
                            ?>
                            <option value="<?php echo $index1; ?>"><?php echo $index1; ?></option>
                            <?php
                          }
                        }
                        if ($nEndTime < $nStartTime) {
                          $nAStartTime = $nStartTime;
                          $nAEndTime = 24;
                        }
                        for ($index1 = $nAStartTime; $index1 < $nAEndTime; $index1++) {
                          ?>
                          <option value="<?php echo $index1; ?>" <?php echo $selected; ?>><?php echo $index1; ?></option>
                          <?php
                          $selected = '';
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-2 col-sm-2 ml-0 pl-0">
                      <input id="appMinute" class="form-control form-control-sm" type="number" min="0" max="59" step="<?php echo $nAppTime; ?>" value="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="fldPatientName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Patient'); ?></label>
                    <div class="col-12 col-sm-10">
                      <input id="fldPatientId" type="hidden">
                      <input id="fldPatientName" class="form-control form-control-sm  phAutocomplete" data-acrel="fldPatientId" data-acoperation="cpy-Clinic-Patient-ListAutocomplete" value="">
                    </div>
                  </div>
                  <!--
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-2 text-lg-right text-left">Payment Amount</label>
                    <div class="col-9 col-sm-10">
                  -->
                  <input id="appAmount" class="form-control form-control-md form-control-solid text-right" type="hidden" value="0" />
                  <!--
                    </div>
                  </div>
                  -->
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Description'); ?></label>
                    <div class="col-9 col-sm-10">
                      <input id="appDesc" class="form-control form-control-sm" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <span class="text-danger" id="status-Message"></span>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal" data-toggle="tooltip" title="" data-original-title="Close"><i class="icon-2x flaticon2-cancel"></i></button>
            <button id="ph_addAppointment_submit" type="button" class="btn btn-primary font-weight-bold" data-toggle="tooltip" title="" data-original-title="Save Changes"><i class="icon-2x flaticon2-check-mark"></i></button>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}
?>