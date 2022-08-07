<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nId = ph_Get_Post('id');
  $nStatusId = ph_Get_Post('nStatusId');
  $dSDate = ph_Get_Post('dSDate');
  $dEDate = ph_Get_Post('dEDate');
  $vName = ph_Get_Post('vName');
  $vDesc = ph_Get_Post('vDesc');
  $aTClinics = ph_Get_Post('aClinics');
  $aClinics = array();
  $nIdx = 0;
  if (is_array($aTClinics) && count($aTClinics)) {
    foreach ($aTClinics as $aCllinic) {
      $aClinics[$nIdx] = $aCllinic[0];
      $nIdx++;
    }
  }

  $oInstance = new cClncOffer();
  $oInstance->Id = $nId;
  $oInstance->StatusId = $nStatusId;
  $oInstance->SDate = $dSDate;
  $oInstance->EDate = $dEDate;
  $oInstance->Name = $vName;
  $oInstance->Description = $vDesc;
  $oInstance->aClinicIds = $aClinics;
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