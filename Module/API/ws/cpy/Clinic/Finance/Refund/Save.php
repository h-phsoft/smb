<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {

    $oInstance = cClncRefund::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->ClinicId = ph_Get_Post('nClinicId');
    $oInstance->PatientId = ph_Get_Post('nPatientId');
    $oInstance->Date = ph_Get_Post('dDate');
    $oInstance->Amt = ph_Get_Post('nAmt');
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
