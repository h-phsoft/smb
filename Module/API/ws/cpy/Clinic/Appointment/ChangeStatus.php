<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nId = ph_Get_Post('nId');
  $nStatus = intval(ph_Get_Post('nStatus'));
  $oInstance = cClncAppointment::getInstance($nId);
  $oInstance->UUserId = $oUser->Id;
  $oInstance->updateStatus($nStatus, $oUser->Id);
  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}
