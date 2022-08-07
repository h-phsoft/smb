<?php

if (isset($oRest)) {

  if ($oUser->oGrp->getPermission(ph_Get_Post('progId'))->Delete) {
    $nId = ph_Get_Post('nId');
    $oInstance = cCpyWPeriod::getInstance($nId);
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
