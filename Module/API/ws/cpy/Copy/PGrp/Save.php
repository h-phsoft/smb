<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $vName = ph_Get_Post('vName');
    $oInstance = new cCpyPGrp();
    $oInstance->Id = $nId;
    $oInstance->Name = $vName;
    if ($nId != 0) {
      $oInstance->UUserId = $oUser->Id;
    } else {
      $oInstance->IUserId = $oUser->Id;
    }
    try {
      $nSavedId = $oInstance->save($oUser->Id);
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done',
        'Id' => $nSavedId
      ));
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}
