<?php

if (isset($oRest)) {

  $vMessage = 'Time not available';
  $nDoctorId = ph_Get_Post('nDoctor');
  $vDate = ph_Get_Post('vDate');
  $nHour = ph_Get_Post('nHour');
  $nMinute = ph_Get_Post('nMinute');
  $nType = ph_Get_Post('nType');
  $oAppType = cClncAppType::getInstance($nType);

  $nAppSTime = ($nHour * 60) + $nMinute;
  $nAppETime = ($nHour * 60) + $nMinute + $oAppType->Time;
  $vDatetimeWhere = '`date`=STR_TO_DATE("' . $vDate . '", "%d-%m-%Y")'
          . ' AND (' . $nAppSTime . ' BETWEEN ((`hour`*60)+`minute`) AND (((`hour`*60)+`minute`)+(minutes-1))'
          . 'OR ' . $nAppETime . ' BETWEEN ((`hour`*60)+`minute`) AND (((`hour`*60)+`minute`)+(minutes-1))'
          . ')';
  $nCount = ph_GetDBValue('count(*)', '`clnc_appointment`', '`doctor_id`="' . $nDoctorId . '" AND ' . $vDatetimeWhere);
  if ($nCount <= 0 && $oAppType->Capacity > 0) {
    $vMessage = 'Appointment Type Capacity Exceeded';
    $nCount = ph_GetDBValue('count(*)', '`clnc_appointment`', '`type_id`="' . $oAppType->Id . '" AND ' . $vDatetimeWhere);
  }

  $response = array(
      'Status' => true,
      'Message' => $vMessage,
      'bAvailable' => $nCount <= 0
  );
  $oRest->setRowData($response);
}