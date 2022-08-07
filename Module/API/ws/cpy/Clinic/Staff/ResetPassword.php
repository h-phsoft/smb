<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Sorry you cannot change password'));
  $nUId = ph_Get_Post('nUserId');
  $vNPassword = ph_Get_Post('vNPassword');
  $vVPassword = ph_Get_Post('vVPassword');
  $oUser = cClncStaff::getInstance($nUId);
  if ($oUser->Id > 0) {
    if ($oUser->resetPassword($vNPassword, $vVPassword)) {
      $oRest->setRowData(array(
          'Status' => true,
          'Message' => 'Done'
      ));
    }
  }
}
