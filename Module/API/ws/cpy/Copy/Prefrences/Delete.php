<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if ($oUser->oGrp->getPermission(ph_Get_Post('progId'))->Delete) {
    $oInstance = cCpyPref::getInstance($nId);
    try {
      $oInstance->delete();
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => getLabel('Done')
      ));
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}
