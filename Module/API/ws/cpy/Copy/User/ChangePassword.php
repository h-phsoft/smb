<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Sorry you cannot change password'));
  if ($aGUId['UId'] > -9) {
    $vOPassword = ph_Get_Post('vOPassword');
    $vNPassword = ph_Get_Post('vNPassword');
    $vVPassword = ph_Get_Post('vVPassword');
    $oUser = cCpyUser::getInstance($aGUId['UId']);
    if ($oUser->changePassword($vOPassword, $vNPassword, $vVPassword)) {
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done'
      ));
    }
  }
}