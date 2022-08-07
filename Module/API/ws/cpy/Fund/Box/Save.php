<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if (($nId == 0 && $oUserPerms->Insert) ||
          ($nId > 0 && $oUserPerms->Update)) {
    $vName = ph_Get_Post('vName');
    $vRem = ph_Get_Post('vRem');
    $nAccId = ph_Get_Post('nAcc');
    $nUserId = ph_Get_Post('nUser');
    $nStatus = ph_Get_Post('nStatus');

    $oInstance = cFundBox::getInstance($nId);
    $oInstance->Name = $vName;
    $oInstance->AccId = $nAccId;
    $oInstance->UserId = $nUserId;
    $oInstance->StatusId = $nStatus;
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
}
