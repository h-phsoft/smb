<?php

if (isset($oRest)) {
  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  $oUser = unserialize(ph_Session('User'));

  $aFields = array(
      'ClinicName' => array(
          'Name' => '`clinic_name`',
          'Cond' => '`clinic_name` LIKE "%COND_VALUE%"'
      ),
      'DoctorName' => array(
          'Name' => '`doctor_name`',
          'Cond' => '`doctor_name` LIKE "%COND_VALUE%"'
      ),
      'PatientNum' => array(
          'Name' => '`patient_nnum`',
          'Cond' => '`patient_nnum` LIKE "%COND_VALUE%"'
      ),
      'PatientName' => array(
          'Name' => '`patient_name`',
          'Cond' => '`patient_name` LIKE "%COND_VALUE%"'
      ),
      'PatientMobile' => array(
          'Name' => '`patient_mobile`',
          'Cond' => '`patient_mobile` LIKE "%COND_VALUE%"'
      ),
      'Date' => array(
          'Name' => '`date`',
          'Cond' => '`date`="%COND_VALUE%"'
      ),
      'StatusName' => array(
          'Name' => '`status_name`',
          'Cond' => '`status_name` LIKE "%COND_VALUE%"'
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
  $nCount = cClncTreatment::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncTreatment::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $IName = ph_GetDBValue('`name`', '`cpy_user`', '`id`="' . $object->IUserId . '"');
    $UName = ph_GetDBValue('`name`', '`cpy_user`', '`id`="' . $object->UUserId . '"');
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'date' => $object->Date,
        'ClinicName' => $object->ClinicName,
        'DoctorName' => $object->DoctorName,
        'PatientNum' => $object->PatientNum,
        'PatientName' => $object->PatientName,
        'PatientMobile' => $object->PatientMobile,
        'StatusName' => $object->StatusName,
        'StatusId' => $object->StatusId,
        'aProcs' => cClncTreatmentProcedures::getArray('`treatment_id`="' . $object->Id . '"'),
        'IUserId' => $object->IUserId,
        'IUserName' => $IName,
        'IName' => $IName . ' ' . $object->IDate,
        'IDate' => $object->IDate,
        'UUserId' => $object->UUserId,
        'UUserName' => $UName,
        'UName' => $UName . ' ' . $object->UDate,
        'UDate' => $object->UDate
    );
    $nIdx++;
  }
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => array(
          'last_page' => $nPages,
          'data' => $aData
      )
  );
  $oRest->setRowData($response);
}