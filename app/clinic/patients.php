<?php
$aYES_NO = cPhsCode::getArray(cPhsCode::YES_NO);
$aHowNow = cCpyCode::getArray(cCpyCode::CLNC_HOWNOW);
$aClinics = cClncClinic::getArray();
$aGenders = cPhsCode::getArray(cPhsCode::GENDER);
$aIdtypes = cPhsCode::getArray(cPhsCode::IDTYPE);
$aMartials = cPhsCode::getArray(cPhsCode::MARTIAL);
$aVisas = cPhsCode::getArray(cPhsCode::VISA);
$aNats = cPhsCodNationality::getArray();
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
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