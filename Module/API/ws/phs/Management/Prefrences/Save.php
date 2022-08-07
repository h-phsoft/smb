<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cPhsPref::getInstanceById($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->Key = ph_Get_Post('vKey');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Value = ph_Get_Post('vValue');
    $oInstance->Rem = ph_Get_Post('vRem');
    $bIsAllOk = true;
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save();
      if ($nSavedId > 0) {

      } else {
        $bIsAllOk = false;
      }
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
    try {
      if ($bIsAllOk) {
        ph_CommitTransaction();
        $oRest->setRowData(array(
          'Status' => true,
          'Message' => getLabel('Done'),
          'Id' => $nSavedId
        ));
      } else {
        ph_RollbackTransaction();
      }
    } catch (Exception $exc) {
      $vMessage = $exc->getMessage();
    }
  }
}
