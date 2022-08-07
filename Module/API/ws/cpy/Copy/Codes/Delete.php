<?php

if (isset($oRest)) {

  if ($oUser->oGrp->getPermission(ph_Get_Post('progId'))->Delete) {
    $nId = ph_Get_Post('nId');
    $vCode = ph_Get_Post('code');
    $oInstance = cCpyCode::getInstance($vCode, $nId);
    try {
      $oInstance->delete();
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done'
      ));
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}