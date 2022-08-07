<?php

if (isset($oRest)) {
  $nPatientId = ph_Get_Post('nPatientId');

  $vWhere = '(`patient_id`="' . $nPatientId . '")';
  $aList = cClncPatientNote::getArray($vWhere);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'PatientId' => $object->PatientId,
        'PatientName' => $object->PatientName,
        'DoctorId' => $object->DoctorId,
        'DoctorName' => $object->DoctorName,
        'Datetime' => $object->Datetime,
        'Note' => $object->Note,
        'IUserId' => $object->IUserId,
        'IUserName' => ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->IUserId . '"'),
        'IDate' => $object->IDate,
        'UUserId' => $object->UUserId,
        'UUserName' => ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->UUserId . '"'),
        'UDate' => $object->UDate
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