<?php

if (isset($oRest)) {

  $nClinicId = ph_Get_Post('nClinic');
  $nSpecial = ph_Get_Post('nSpecial');
  $dDay = ph_Get_Post('dDay');

  $vDrWhere = '';
  //$vDrWhere .= '`status_id`=1 AND `type_id`=2 AND `id` IN (SELECT `user_id` FROM `cpy_user_clinic` WHERE `clinic_id`="' . $nClinicId . '")';
  $vDrWhere .= '`status_id`=1 AND `type_id`=2';
  if ($oUser->TypeId == 2) {
    $vDrWhere .= ' AND `id`="' . $oUser->Id . '"';
  }
  if ($nSpecial != 0) {
    $vDrWhere .= ' AND `special_id`="' . $nSpecial . '"';
  }
  $aDocs = cCpyUser::getArray($vDrWhere);
  $nDocIdx = 0;
  $aDoctors = array();
  foreach ($aDocs as $doctor) {
    $aDoctors[$nDocIdx]['Id'] = $doctor->Id;
    $aDoctors[$nDocIdx]['Name'] = $doctor->Name;
    $aDoctors[$nDocIdx]['GenderId'] = $doctor->GenderId;
    $aDoctors[$nDocIdx]['GenderName'] = $doctor->GenderName;
    $aDoctors[$nDocIdx]['SpecialId'] = $doctor->SpecialId;
    $aDoctors[$nDocIdx]['SpecialName'] = $doctor->SpecialName;
    $aDoctors[$nDocIdx]['TypeId'] = $doctor->TypeId;
    $aDoctors[$nDocIdx]['TypeName'] = $doctor->TypeName;
    $nDocIdx++;
  }

  $nStartTime = intval(cCpyPref::getPrefValue('WORK-START-TIME'));
  $nEndTime = intval(cCpyPref::getPrefValue('WORK-END-TIME'));
  $nAppTime = intval(cCpyPref::getPrefValue('WORK-APP-TIME'));
  if ($nAppTime <= 0) {
    $nAppTime = 15;
  }
  if ($nEndTime < $nStartTime) {
    $nAStartTime = $nStartTime;
    $nAEndTime = 24;
  }

  $aApps = array();
  $vSQL = 'SELECT `hour`, `minute`'
          . ' FROM ('
          . 'SELECT 1 AS `type`, `hour`, `minute` FROM `clnc_worktime` WHERE `hour`>=' . $nStartTime
          . ' UNION ALL '
          . 'SELECT DISTINCT 1 AS `type`, `hour`, `minute` FROM `clnc_appointment` WHERE `clinic_id`="' . $nClinicId . '" AND `date`=STR_TO_DATE("' . $dDay . '", "%Y-%m-%d") AND `hour`>=' . $nStartTime . ' AND (`hour`, `minute`) NOT IN (SELECT `hour`, `minute` FROM `clnc_worktime`)'
          . ' UNION ALL '
          . 'SELECT 2 AS `type`, `hour`, `minute` FROM `clnc_worktime` WHERE `hour`<' . $nStartTime
          . ' UNION ALL '
          . 'SELECT DISTINCT 2 AS `type`, `hour`, `minute` FROM `clnc_appointment` WHERE  `clinic_id`="' . $nClinicId . '" AND `date`=STR_TO_DATE("' . $dDay . '", "%Y-%m-%d") AND `hour`<' . $nStartTime . ' AND (`hour`, `minute`) NOT IN (SELECT `hour`, `minute` FROM `clnc_worktime`)'
          . ') AS mm'
          . ' ORDER BY `type`, `hour`, `minute`';
  $res = ph_Execute($vSQL);
  if ($res != '') {
    while (!$res->EOF) {
      $nHour = $res->fields("hour");
      $nMinute = $res->fields("minute");
      $vKey = str_pad($nHour, 2, '0', STR_PAD_LEFT) . str_pad($nMinute, 2, '0', STR_PAD_LEFT);
      $vTime = str_pad($nHour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($nMinute, 2, '0', STR_PAD_LEFT);
      $aApps[$vKey] = array();
      $aApps[$vKey]['Date'] = $dDay;
      $aApps[$vKey]['Time'] = $vTime;
      $aApps[$vKey]['Hour'] = $nHour;
      $aApps[$vKey]['Minute'] = $nMinute;
      $aApps[$vKey]['Count'] = 0;
      $aApps[$vKey]['Apps'] = array();
      $res->MoveNext();
    }
    $res->Close();
  }
  $aAppointments = cClncAppointment::getArray('`clinic_id`="' . $nClinicId . '" AND `date`=STR_TO_DATE("' . $dDay . '", "%Y-%m-%d")');
  foreach ($aAppointments as $appointment) {
    $vKey = str_pad($appointment->Hour, 2, '0', STR_PAD_LEFT) . str_pad($appointment->Minute, 2, '0', STR_PAD_LEFT);
    $aApps[$vKey]['Count']++;
    $aApps[$vKey]['Apps'][$appointment->DoctorId] = array(
        'Id' => $appointment->Id,
        'ClinicId' => $appointment->ClinicId,
        'DoctorId' => $appointment->DoctorId,
        'PatientId' => $appointment->PatientId,
        'Name' => $appointment->PatientName,
        'PatientNum' => $appointment->PatientNum,
        'PatientMobile' => $appointment->PatientMobile,
        'Type' => $appointment->TypeId,
        'Special' => $appointment->SpecialId,
        'Status' => $appointment->StatusId,
        'Date' => date_format(date_create($appointment->Date), 'd-m-Y'),
        'Hour' => $appointment->Hour,
        'Minute' => $appointment->Minute,
        'Minutes' => $appointment->Minutes,
        'Rowspan' => ceil($appointment->Minutes / 15),
        'Desc' => $appointment->Description,
        'Amount' => $appointment->Amount,
        'IUserId' => $appointment->IUserId,
        'IUserName' => ph_GetDBValue('`name`', '`cpy_vuser`', '`id`="' . $appointment->IUserId . '"'),
        'IDate' => $appointment->IDate,
        'UUserId' => $appointment->UUserId,
        'UUserName' => ph_GetDBValue('`name`', '`cpy_vuser`', '`id`="' . $appointment->UUserId . '"'),
        'UDate' => $appointment->UDate
    );
  }
  $aData = array();
  $nIdx = 0;
  foreach ($aApps as $app) {
    $aData[$nIdx] = $app;
    $nIdx++;
  }
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Doctors' => $aDoctors,
      'Data' => $aData
  );
  $oRest->setRowData($response);
}
