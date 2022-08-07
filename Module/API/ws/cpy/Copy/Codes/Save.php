<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
          ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $vCode = ph_Get_Post('code');
    $nId = ph_Get_Post('nId');
    $vName = ph_Get_Post('vName');
    $vRem = ph_Get_Post('vRem');

    $oInstance = cCpyCode::getInstance($vCode, $nId);
    $oInstance->vTable = $vCode;
    $oInstance->Id = $nId;
    $oInstance->Name = $vName;
    $oInstance->Rem = $vRem;
    try {
      $nSavedId = $oInstance->save($oUser->Id);
      $oRest->setRowData(array(
          'Status' => true,
          'Message' => 'Done',
          'Id' => $nSavedId
      ));
    } catch (Exception $exc) {
      $oRest->setRowData(array(
          'Status' => false,
          'Message' => $exc->getTraceAsString()
      ));
    }
  }
}