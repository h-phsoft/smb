<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if (($nId > 0) && ($oUserPerms->Delete)) {
    $oInstance = cFundBox::getInstance($nId);
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