<?php

if (isset($oRest)) {
  $nCId = ph_Get_Post('nCId');
  $nSSId = ph_Get_Post('nSSId');
  $nSEId = ph_Get_Post('nSEId');
  $nPId = ph_Get_Post('nPId');

  $vWhere = '`clinic_id`="' . $nCId . '" AND `patient_id`="' . $nPId . '"';
  if ($nSSId != '' && $nSEId != '') {
    $vWhere .= ' AND `status_id` BETWEEN "' . $nSSId . '" AND "' . $nSEId . '"';
  }
  $aList = cClncTreatmentProcedures::getArray($vWhere);
  $nBalance = floatval(ph_GetDBValue('sum(`net`)', '`clnc_vpatient_card`', '`patient_id`="' . $nPId . '"'));
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'StatusId' => $object->StatusId,
        'StatusName' => $object->StatusName,
        'PatientId' => $object->PatientId,
        'PatientName' => $object->PatientName,
        'DoctorId' => $object->DoctorId,
        'DoctorName' => $object->DoctorName,
        'Datetime' => $object->Datetime,
        'Category' => $object->CatName,
        'Procedure' => $object->ProcedureName,
        'Qnt' => $object->Qnt,
        'Price' => $object->Price,
        'Amt' => $object->Amount,
        'VatAmt' => $object->VatAmount
    );
    $nIdx++;
  }
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Balance' => $nBalance,
      'Data' => $aData
  );
  $oRest->setRowData($response);
}