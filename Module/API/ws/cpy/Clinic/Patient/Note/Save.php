<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nId = ph_Get_Post('id');
  $nPId = ph_Get_Post('nPId');
  $nDId = ph_Get_Post('nDId');
  $vNote = ph_Get_Post('vNote');

  $oInstance = new cClncPatientNote();
  $oInstance->Id = $nId;
  $oInstance->PatientId = $nPId;
  $oInstance->DoctorId = $nDId;
  $oInstance->Note = $vNote;
  if ($nId != 0) {
    $oInstance->UUserId = $oUser->Id;
  } else {
    $oInstance->IUserId = $oUser->Id;
  }
  $nSavedId = $oInstance->save($oUser->Id);

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}