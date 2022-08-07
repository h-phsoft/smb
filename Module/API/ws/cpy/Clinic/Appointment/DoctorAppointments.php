<?php

if (isset($oRest)) {

  $dDay = ph_Get_Post('dDay');
  $nClinicId = ph_Get_Post('nClinic');

  $vWhere = '`clinic_id`="' . $nClinicId . '" AND `date`=STR_TO_DATE("' . $dDay . '", "%Y-%m-%d")';
  if ($oUser->TypeId == 2) {
    //$vWhere .= ' AND `doctor_id`="' . $oUser->Id . '"';
  }

  $aAppointments = cClncAppointment::getArray($vWhere);
  $aData = array();
  $nIdx = 0;
  foreach ($aAppointments as $appointment) {
    $aData[$nIdx] = array(
        'Id' => $appointment->Id,
        'ClinicId' => $appointment->ClinicId,
        'DoctorId' => $appointment->DoctorId,
        'PatientId' => $appointment->PatientId,
        'PatientNum' => $appointment->PatientNum,
        'PatientName' => $appointment->PatientName,
        'PatientMobile' => $appointment->PatientMobile,
        'PatientGenderId' => $appointment->PatientGenderId,
        'PatientGenderName' => $appointment->PatientGenderName,
        'TypeId' => $appointment->TypeId,
        'Type' => $appointment->TypeName,
        'TypeNameFG' => $appointment->TypeNamefgId,
        'TypeTitleBG' => $appointment->TypeTitlebgId,
        'TypeTitleFG' => $appointment->TypeTitlfgId,
        'SpecialId' => $appointment->SpecialId,
        'Special' => $appointment->SpecialName,
        'StatusId' => $appointment->StatusId,
        'Status' => $appointment->StatusName,
        'StatusColor' => $appointment->StatusColor,
        'Date' => date_format(date_create($appointment->Date), 'Y-m-d'),
        'Hour' => $appointment->Hour,
        'Minute' => $appointment->Minute,
        'Desc' => $appointment->Description,
        'IUserId' => $appointment->IUserId,
        'IUserName' => ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $appointment->IUserId . '"'),
        'IDate' => $appointment->IDate,
        'UUserId' => $appointment->UUserId,
        'UUserName' => ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $appointment->UUserId . '"'),
        'UDate' => $appointment->UDate
    );
    $nIdx++;
  }
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aData
  );
  $oRest->setRowData($response);
}
