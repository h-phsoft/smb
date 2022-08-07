<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Invalid username or password'));
  if ($aGUId['GId'] != '' && $aGUId['Status'] == 1) {
    $dDatetime = date('Y-m-d H:i:s');
    $oToken = cCpyToken::getInstanceByGUID($aGUId['GId']);
    if ($oToken->Id != -999 && $oToken->UserId != -9 && $oToken->StatusId == 1 && $oToken->Edate >= $dDatetime) {
      $vMessage = '2';
      $oUser = cCpyUser::getInstance($oToken->UserId);
      ph_SetSession('User', serialize($oUser));
      ph_SetSession('GUId', serialize($aGUId));
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => getLabel('Welcome') . ' ' . $oUser->Name
      ));
    }
  }
}