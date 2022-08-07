<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if ((($nId == 0) && ($oUserPerms->Insert)) || (($nId > 0) && ($oUserPerms->Update))) {

    $nClinicId = ph_Get_Post('nClinicId');

    $oInstance = cClncPatient::getInstance($nId);
    $oInstance->ClinicId = $nClinicId;
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Num = ph_Get_Post('vNum');
    $oInstance->Birthday = ph_Get_Post('dBirthday');
    $oInstance->GenderId = ph_Get_Post('nGenderId');
    $oInstance->MartialId = ph_Get_Post('nMartialId');
    $oInstance->NatId = ph_Get_Post('nNatId');
    $oInstance->VisaId = ph_Get_Post('nVisaId');
    $oInstance->HormonalId = ph_Get_Post('nHormonalId');
    $oInstance->SmokedId = ph_Get_Post('nSmokedId');
    $oInstance->AlcoholicId = ph_Get_Post('nAlcoholicId');
    $oInstance->PregnancyId = ph_Get_Post('nPregnancyId');
    $oInstance->BreastfeedId = ph_Get_Post('nBreastfeedId');
    $oInstance->NatNum = ph_Get_Post('vNatNum');
    $oInstance->IdtypeId = ph_Get_Post('nIdtypeId');
    $oInstance->Idnum = ph_Get_Post('vIdnum');
    $oInstance->Mobile = ph_Get_Post('vMobile');
    $oInstance->Land1 = ph_Get_Post('vLand1');
    $oInstance->Land2 = ph_Get_Post('vLand2');
    $oInstance->JobName = ph_Get_Post('vJobName');
    $oInstance->Addr = ph_Get_Post('vAddr');
    $oInstance->ChronicDiseases = ph_Get_Post('vChronicDiseases');
    $oInstance->PreOperations = ph_Get_Post('vPreOperations');
    $oInstance->MedicinesUsed = ph_Get_Post('vMedicinesUsed');
    $oInstance->Patrem = ph_Get_Post('vPatrem');
    $oInstance->Rem = ph_Get_Post('vRem');
    $oInstance->Hownow = ph_Get_Post('vHownow');
    $oInstance->HownowId = ph_Get_Post('nHownowId');
    $oInstance->Email = ph_Get_Post('vEmail');
    $oInstance->Company = ph_Get_Post('vCompany');
    $oInstance->Langs = ph_Get_Post('vLangs');
    $oInstance->Description = ph_Get_Post('vDescription');
    try {
      $oRest->setRowData(array(
          'Status' => false,
          'Message' => getLabel('Master Not Saved')
      ));
      $nSavedId = $oInstance->save($oUser->Id);
      if ($nSavedId > 0) {
        $oRest->setRowData(array(
            'Status' => true,
            'Message' => getLabel('Master Saved'),
            'Id' => $nSavedId
        ));
        $nSpecialId = ph_Get_Post('nAppSpecial');
        $nDoctorId = ph_Get_Post('nAppDoctor');
        $vDate = ph_Get_Post('vAppDate');
        $nHour = ph_Get_Post('nAppHour');
        $nMinute = ph_Get_Post('nAppMinute');
        $nTypeId = ph_Get_Post('nAppType');
        $nAppAmount = ph_Get_Post('nAppAmount');
        $vAppDesc = ph_Get_Post('vAppDesc');
        if ($nDoctorId > 0) {
          $oTInstance = cClncAppointment::getInstance(0);
          $oTInstance->ClinicId = $nClinicId;
          $oTInstance->TypeId = $nTypeId;
          $oTInstance->SpecialId = $nSpecialId;
          $oTInstance->DoctorId = $nDoctorId;
          $oTInstance->PatientId = $nSavedId;
          $oTInstance->Date = $vDate;
          $oTInstance->Hour = $nHour;
          $oTInstance->Minute = $nMinute;
          $oTInstance->Amount = $nAppAmount;
          $oTInstance->Description = $vAppDesc;
          $oTInstance->save($oUser->Id);
        }
        ph_CommitTransaction();
        $oRest->setRowData(array(
            'Status' => true,
            'Message' => getLabel('Done'),
            'Id' => $nSavedId
        ));
      }
    } catch (Exception $exc) {
      ph_RollbackTransaction();
      $oRest->setRowData(array(
          'Status' => false,
          'Message' => $exc->getMessage()
      ));
    }
  }
}
