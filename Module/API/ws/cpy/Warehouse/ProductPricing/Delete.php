<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');

  $oInstance = cWhsProductPriceMst::getInstance($nId);
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