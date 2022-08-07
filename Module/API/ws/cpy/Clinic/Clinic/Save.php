<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)
  ) {

    $oInstance = cClncClinic::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Prefix = ph_Get_Post('vPrefix');
    $oInstance->Email = ph_Get_Post('vEmail');
    $oInstance->Phone1 = ph_Get_Post('vPhone1');
    $oInstance->Phone2 = ph_Get_Post('vPhone2');
    $oInstance->Phone3 = ph_Get_Post('vPhone3');
    $oInstance->Address = ph_Get_Post('vAddress');
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
