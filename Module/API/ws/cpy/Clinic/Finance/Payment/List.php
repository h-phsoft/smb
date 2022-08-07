<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  $aFields = array(
    'nClinicId' => array(
      'Name' => '`clinic_id`',
      'Cond' => '`clinic_id`="COND_VALUE"'
    ),
    'nPatientId' => array(
      'Name' => '`patient_id`',
      'Cond' => '`patient_id`="COND_VALUE"'
    ),
    'nDoctorId' => array(
      'Name' => '`doctor_id`',
      'Cond' => '`doctor_id`="COND_VALUE"'
    ),
    'nMethodId' => array(
      'Name' => '`method_id`',
      'Cond' => '`method_id`="COND_VALUE"'
    ),
    'dDate' => array(
      'Name' => '`date`',
      'Cond' => '`date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'nAmt' => array(
      'Name' => '`amt`',
      'Cond' => '`amt`="COND_VALUE"'
    ),
    'vDescription' => array(
      'Name' => '`description`',
      'Cond' => '`description` LIKE "%COND_VALUE%"'
    ),
    'vClinicName' => array(
      'Name' => '`clinic_id`',
      'Cond' => '`clinic_id` IN (SELECT `id` FROM `clnc_clinic` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vDoctorName' => array(
      'Name' => '`doctor_id`',
      'Cond' => '`doctor_id` IN (SELECT `id` FROM `cpy_user` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vMethodName' => array(
      'Name' => '`method_id`',
      'Cond' => '`method_id` IN (SELECT `id` FROM `phs_cod_payment_type` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vPatientName' => array(
      'Name' => '`patient_id`',
      'Cond' => '`patient_id` IN (SELECT `id` FROM `clnc_patient` WHERE `name` LIKE "%COND_VALUE%")'
    ),
  );
  $vWhere = '';
  $vAnd = '';
  if (isset($filter) && is_array($filter)) {
    foreach ($filter as $field) {
      if (isset($aFields[$field['field']])) {
        $vWhere .= $vAnd . str_replace('COND_VALUE', $field['value'], $aFields[$field['field']]['Cond']);
        $vAnd = ' AND ';
      }
    }
  }
  $vOrder = '';
  $vComma = '';
  if (isset($sorters) && is_array($sorters)) {
    foreach ($sorters as $field) {
      if (isset($aFields[$field['field']])) {
        $vOrder .= $vComma . $aFields[$field['field']]['Name'] . ' ' . strtoupper($field['dir']);
        $vComma = ', ';
      }
    }
  }
  $nPages = 0;
  $nCount = cClncPayment::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncPayment::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nClinicId' => $element->ClinicId,
      'nPatientId' => $element->PatientId,
      'nDoctorId' => $element->DoctorId,
      'nMethodId' => $element->MethodId,
      'dDate' => date_format(date_create($element->Date), 'Y-m-d'),
      'nAmt' => $element->Amt,
      'vDescription' => $element->Description,
      'vClinicName' => $element->oClinic->Name,
      'vDoctorName' => $element->oDoctor->Name,
      'vMethodName' => $element->oMethod->Name,
      'vPatientName' => $element->oPatient->Name,
      'vPatientNumber' => $element->oPatient->Num,
      'vPatientMobile' => $element->oPatient->Mobile,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => array(
      'last_page' => $nPages,
      'data' => $aData
    )
  ));
}
