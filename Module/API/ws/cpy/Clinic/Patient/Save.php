<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {

    $oInstance = cClncPatient::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->ClinicId = ph_Get_Post('nClinicId');
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
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save($oUser->Id);
      $oRest->addRowDataValue('Id', $nSavedId);
      if ($nSavedId > 0) {
        ph_CommitTransaction();
        $oRest->setStatus(true);
        $oRest->setMessage(getLabel('Done'));
      }
    } catch (Exception $exc) {
      ph_RollbackTransaction();
      $oRest->setStatus(false);
      $oRest->setMessage($exc->getMessage());
    }
  }
}
