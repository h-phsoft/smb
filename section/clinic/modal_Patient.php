<?php
$aHowNow = cCpyCode::getArray(cCpyCode::CLNC_HOWNOW);
$aSpecial = cCpyCode::getArray(cCpyCode::CLNC_SPECIAL);
$aYES_NO = cPhsCode::getArray(cPhsCode::YES_NO);
$aClinics = cClncClinic::getArray();
$aGenders = cPhsCode::getArray(cPhsCode::GENDER);
$aIdtypes = cPhsCode::getArray(cPhsCode::IDTYPE);
$aMartials = cPhsCode::getArray(cPhsCode::MARTIAL);
$aVisas = cPhsCode::getArray(cPhsCode::VISA);
$aNats = cPhsCodNationality::getArray();
$aAppTypes = cClncAppType::getArray();
$nStartTime = intval(cCpyPref::getPref('WORK-START-TIME'));
$nEndTime = intval(cCpyPref::getPref('WORK-END-TIME'));
$nAppTime = intval(cCpyPref::getPref('WORK-APP-TIME'));
if ($nAppTime <= 0) {
  $nAppTime = 15;
}
$modalProgram = cPhsProgram::getInstanceByFile('clinic/patients');
if ($modalProgram->Id != -999) {
  if (($oUser->oGrp->Id <= 0) ||
          (is_array($oUser->oGrp->aPerms) &&
          isset($oUser->oGrp->aPerms[$modalProgram->Id]) &&
          $oUser->oGrp->aPerms[$modalProgram->Id]->isOK)
  ) {
    ?>
    <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPatientModalLabel"><?php echo getLabel('Add Patient'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="ki ki-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="ph_AddPatient_form">
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Clinic'); ?></label>
                    <div class="col-sm-4">
                      <select id="patAppClinic" class="form-control form-control-sm form-select" required="true">
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
                    <label class="col-form-label col-3 col-sm-2 text-lg-right text-left"><?php echo getLabel('Speciality'); ?></label>
                    <div class="col-sm-4">
                      <select id="patAppSpecial" class="form-control  form-control-sm form-select" data-toggle="tooltip">
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
                    <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Doctor'); ?></label>
                    <div class="col-sm-4">
                      <select id="patAppDoctor" name="patAppDoctor" class="form-control form-control-sm form-select" required="true">
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
                    <label class="col-form-label col-sm-2 text-lg-right text-left "><?php echo getLabel('Type'); ?></label>
                    <div class="col-sm-4">
                      <select id="patAppType" class="form-control  form-control-sm form-select" required="true" data-live-search="true">
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
                    <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Date'); ?></label>
                    <div class="col-12 col-sm-4">
                      <div class="input-group date">
                        <input id="patAppDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                        <div class="input-group-append datepicker-btn">
                          <span class="input-group-text">
                            <i class="la la-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Time'); ?></label>
                    <div class="col-sm-2">
                      <select id="patAppHour" class="form-control form-control-sm form-select" required="true">
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
                    <div class="col-sm-2">
                      <input id="patAppMinute" class="form-control form-control-sm" type="number" min="0" max="59" step="<?php echo $nAppTime; ?>" value="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Description'); ?></label>
                    <div class="col-sm-11">
                      <input id="patAppDesc" class="form-control form-control-sm" type="text" value="">
                    </div>
                  </div>
                  <!--
                  <div class="form-group row">
                    <label class="col-form-label col-3 col-sm-2 text-lg-right text-left">Payment Amount</label>
                    <div class="col-sm-4">
                  -->
                  <input id="patAppAmount" class="form-control form-control-md form-control-solid text-right" type="hidden" value="0" />
                  <!--
                    </div>
                  </div>
                  -->
                  <hr>
                  <div class="row pt-1">
                    <input id="fldId" type="hidden" value="" />
                    <!-- <label for="fldClinicId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Clinic'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldClinicId" class="form-control form-control-sm form-select">
                    <?php
                    foreach ($aClinics as $element) {
                      ?>
                                <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                      <?php
                    }
                    ?>
                      </select>
                    </div> -->
                    <label for="fldNum" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Num'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldNum" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldBirthday" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Birthday'); ?></label>
                    <div class="col-12 col-sm-2">
                      <div class="input-group date">
                        <input id="fldBirthday" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                        <div class="input-group-append datepicker-btn">
                          <span class="input-group-text">
                            <i class="la la-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldNatNum" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('NatNum'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldNatNum" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldIdtypeId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('IdtypeId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldIdtypeId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aIdtypes as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldIdnum" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Idnum'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldIdnum" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldNatId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Nat'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldNatId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aNats as $element) {
                          ?>
                          <option value="<?php echo $element->NumCode; ?>"><?php echo $element->Nationality; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldGenderId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Gender'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldGenderId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aGenders as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldMartialId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Martial'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldMartialId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aMartials as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldVisaId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('VisaId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldVisaId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aVisas as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldMobile" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Mobile'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldMobile" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldLand1" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Land1'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldLand1" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldLand2" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Land2'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldLand2" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldCompany" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Company'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldCompany" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldJobName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('JobName'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldJobName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldEmail" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Email'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldEmail" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldLangs" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Langs'); ?></label>
                    <div class="col-12 col-sm-2">
                      <input id="fldLangs" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldAddr" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Addr'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldAddr" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldDescription" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Description'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldDescription" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Rem'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldRem" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <hr>
                  <div class="row pt-1">
                    <label for="fldHormonalId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('HormonalId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldHormonalId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aYES_NO as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldSmokedId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('SmokedId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldSmokedId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aYES_NO as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldAlcoholicId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('AlcoholicId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldAlcoholicId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aYES_NO as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldPregnancyId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('PregnancyId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldPregnancyId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aYES_NO as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <label for="fldBreastfeedId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('BreastfeedId'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldBreastfeedId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aYES_NO as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldChronicDiseases" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('ChronicDiseases'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldChronicDiseases" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldPreOperations" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('PreOperations'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldPreOperations" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldMedicinesUsed" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('MedicinesUsed'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldMedicinesUsed" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                    <label for="fldPatrem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Patrem'); ?></label>
                    <div class="col-12 col-sm-5">
                      <input id="fldPatrem" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                  <div class="row pt-1">
                    <label for="fldHownow" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Hownow'); ?></label>
                    <div class="col-12 col-sm-2">
                      <select id="fldHownowId" class="form-control form-control-sm form-select">
                        <?php
                        foreach ($aHowNow as $element) {
                          ?>
                          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-12 col-sm-9">
                      <input id="fldHownow" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-warning font-weight-bold" data-dismiss="modal" data-toggle="tooltip" title="" data-original-title="Close"><i class="icon-2x flaticon2-cancel"></i></button>
            <button id="ph_addPatient_submit" type="button" class="btn btn-primary font-weight-bold" data-toggle="tooltip" title="" data-original-title="Save Changes"><i class="icon-2x flaticon2-check-mark"></i></button>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}
?>