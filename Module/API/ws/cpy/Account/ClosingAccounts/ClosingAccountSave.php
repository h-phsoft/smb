<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $nOrd = ph_Get_Post('nOrd');
  $vName = ph_Get_Post('vName');
  $vRem = ph_Get_Post('vRem');

  $oInstance = new cAccClose();
  $oInstance->Id = $nId;
  $oInstance->Ord = $nOrd;
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
    $oRest->setMessage($exc->getMessage());
  }
}