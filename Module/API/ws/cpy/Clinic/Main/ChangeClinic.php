<?php

if (isset($oRest)) {
  $nUId = -99;
  $vName = '';
  $nType = -99;
  $response = array(
    'Status' => false,
    'Message' => 'Sorry you cannot change Clinic'
  );
  $nCId = ph_Get_Post('nCId');
  $oUser = unserialize(ph_Session('User'));
  $nUType = intval(ph_Session('UType'));
  // $isOK = ($oUser->TypeId === 0 || $oUser->TypeId === -1) ? 1 : intval(ph_GetDBValue('1', '`phs_user_clinic`', '`user_id`="' . $oUser->Id . '" AND `clinic_id`="' . $nCId . '"'));
  $isOK = 1;
  if ($isOK === 1) {
    $vCName = ph_GetDBValue('`name`', '`clnc_clinic`', '`id`="' . $nCId . '"');
    ph_SetSession('UClinicId', $nCId);
    ph_SetSession('UClinicName', $vCName);
    $response = array(
      'Status' => true,
      'Message' => 'Done'
    );
  }
  $oRest->setHttpStatus(200);
  $oRest->setRowData($response);
}
