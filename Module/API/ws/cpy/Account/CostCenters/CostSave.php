<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if ((($nId == 0) && ($oUserPerms->Insert)) ||
          (($nId > 0) && ($oUserPerms->Update))) {
    $nId = ph_Get_Post('nId');
    $vNum = ph_Get_Post('vNum');
    $vName = ph_Get_Post('vName');
    $vRem = ph_Get_Post('vRem');
    $nType = ph_Get_Post('nType');
    $nStatus = ph_Get_Post('nStatus');

    $oInstance = cAccCost::getInstance($nId);
    $oInstance->Num = $vNum;
    $oInstance->Name = $vName;
    $oInstance->Rem = $vRem;
    $oInstance->TypeId = $nType;
    $oInstance->StatusId = $nStatus;
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