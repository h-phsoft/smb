<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nId = ph_Get_Post('nId');
  cSetting::setSettingValue('Current-Offer', $nId);

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}