<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)
  ) {

    $oInstance = cClncAppType::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Capacity = ph_Get_Post('nCapacity');
    $oInstance->Time = ph_Get_Post('nTime');
    $oInstance->TbgId = ph_Get_Post('nTbgId');
    $oInstance->TfgId = ph_Get_Post('nTfgId');
    $oInstance->NfgId = ph_Get_Post('nNfgId');
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
