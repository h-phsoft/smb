<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nCId = ph_Get_Post('nCId');
  $nPId = ph_Get_Post('nPId');

  $nTreatId = intval(ph_GetDBValue('`id`', '`clnc_treatment`', '`clinic_id`="' . $nCId . '" AND `patient_id`="' . $nPId . '" AND `status_id`=1'));

  if ($nTreatId > 0) {
    $oInstance = cClncTreatment::getInstance($nTreatId);
    $oInstance->UUserId = $oUser->Id;
    $oInstance->closeTreatment();
  }

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}