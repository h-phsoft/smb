<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  try {
    ph_BeginTransaction();
    $oInstance = cStrInMst::getInstance($nId);
    $oInstance->delete();
    ph_CommitTransaction();
    $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done'
    ));
  } catch (Exception $exc) {
    $oRest->setMessage($exc->getMessage());
    ph_RollbackTransaction();
  }
}