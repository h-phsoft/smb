<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  $aFields = array(
    'nId' => array(
      'Name' => '`id`',
      'Cond' => '`id`="COND_VALUE"'
    ),
    'nClinicId' => array(
      'Name' => '`clinic_id`',
      'Cond' => '`clinic_id`="COND_VALUE"'
    ),
    'nPatientId' => array(
      'Name' => '`patient_id`',
      'Cond' => '`patient_id`="COND_VALUE"'
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
    'vPatientName' => array(
      'Name' => '`patient_id`',
      'Cond' => '`patient_id` IN (SELECT `id` FROM `clnc_patient` WHERE `name` LIKE "%COND_VALUE%")'
    )
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
  $nCount = cClncDiscount::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncDiscount::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nClinicId' => $element->ClinicId,
      'nPatientId' => $element->PatientId,
      'dDate' => date_format(date_create($element->Date), 'Y-m-d'),
      'nAmt' => $element->Amt,
      'vDescription' => $element->Description,
      'vClinicName' => $element->oClinic->Name,
      'vPatientName' => $element->oPatient->Name,
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
