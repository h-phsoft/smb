<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('id');
  $nCliniId = ph_Get_Post('nClinic');
  $nSpecialId = ph_Get_Post('nSpecial');
  $nDoctorId = ph_Get_Post('nDoctor');
  $vDate = ph_Get_Post('vDate');
  $nHour = ph_Get_Post('nHour');
  $nMinute = ph_Get_Post('nMinute');
  $nMinutes = intval(ph_Get_Post('nMinutes'));
  $nTypeId = ph_Get_Post('nType');
  $nPatient = ph_Get_Post('nPatient');
  $nAmount = floatval(ph_Get_Post('nAmount'));
  $vDesc = ph_Get_Post('vDesc');

  if ($nMinutes <= 0) {
    $oAppType = cClncAppType::getInstance($nTypeId);
    $nMinutes = $oAppType->Time;
  }
  $oInstance = cClncAppointment::getInstance($nId);
  $oInstance->ClinicId = $nCliniId;
  $oInstance->TypeId = $nTypeId;
  $oInstance->SpecialId = $nSpecialId;
  $oInstance->DoctorId = $nDoctorId;
  $oInstance->Date = $vDate;
  $oInstance->Hour = $nHour;
  $oInstance->Minute = $nMinute;
  $oInstance->Minutes = $nMinutes;
  $oInstance->PatientId = $nPatient;
  $oInstance->Amount = $nAmount;
  $oInstance->Description = $vDesc;
  if ($nId != 0) {
    $oInstance->UUserId = $oUser->Id;
  } else {
    $oInstance->IUserId = $oUser->Id;
  }
  $nSavedId = $oInstance->save($oUser->Id);

  if ($nId === 0 && $nSavedId > 0 && $nAmount > 0) {
    $oPInstance = new cClncPayment();
    $oPInstance->ClinicId = $nCliniId;
    $oPInstance->DoctorId = $nDoctorId;
    $oPInstance->MethodId = 1;
    $oPInstance->PatientId = $nPatient;
    $oPInstance->Date = $vDate;
    $oPInstance->Amount = $nAmount;
    $oPInstance->Description = $vDesc;
    $oPInstance->save($oUser->Id);
  }

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}