<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('id');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {

    $oInstance = cClncPayment::getInstance($nId);
    $oInstance->Id = ph_Get_Post('id');
    $oInstance->ClinicId = ph_Get_Post('nCId');
    $oInstance->ClinicId = 1;
    $oInstance->PatientId = ph_Get_Post('nPId');
    $oInstance->DoctorId = ph_Get_Post('nDId');
    $oInstance->MethodId = ph_Get_Post('nMId');
    $oInstance->Date = ph_Get_Post('dDate');
    $oInstance->Amt = ph_Get_Post('nAmount');
    $oInstance->Description = ph_Get_Post('vDesc');
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
