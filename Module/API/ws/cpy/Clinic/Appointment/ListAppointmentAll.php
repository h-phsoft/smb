<?php

if (isset($oRest)) {

  $nClinicId = ph_Get_Post('UClinic');
  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  if ($size === null || $size === '') {
    $size = 10;
  }
  if ($page === null || $page === '') {
    $page = 1;
  }

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
          'Name' => '`patient_num`',
          'Cond' => '`patient_num` LIKE "%COND_VALUE%"'
      ),
      'PatientNatNum' => array(
          'Name' => '`patient_nat_num`',
          'Cond' => '`patient_nat_num` LIKE "%COND_VALUE%"'
      ),
      'PatientMobile' => array(
          'Name' => '`patient_mobile`',
          'Cond' => '`patient_mobile` LIKE "%COND_VALUE%"'
      ),
      'PatientName' => array(
          'Name' => '`patient_name`',
          'Cond' => '`patient_name` LIKE "%COND_VALUE%"'
      ),
      'SpecialName' => array(
          'Name' => '`special_name`',
          'Cond' => '`special_name` LIKE "%COND_VALUE%"'
      ),
      'TypeName' => array(
          'Name' => '`type_name`',
          'Cond' => '`type_name` LIKE "%COND_VALUE%"'
      ),
      'StatusName' => array(
          'Name' => '`Status_name`',
          'Cond' => '`Status_name` LIKE "%COND_VALUE%"'
      ),
      'Description' => array(
          'Name' => '`description`',
          'Cond' => '`description` LIKE "%COND_VALUE%"'
      ),
      'Amount' => array(
          'Name' => '`amt`',
          'Cond' => '`amt`="COND_VALUE"'
      ),
      'Date' => array(
          'Name' => '`date`',
          'Cond' => '`date` LIKE "%COND_VALUE%"'
      ),
      'IName' => array(
          'Name' => '`iuser_id`',
          'Cond' => '`iuser_id` IN (SELECT `id` FROM `phs_user` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'UName' => array(
          'Name' => '`uuser_id`',
          'Cond' => '`uuser_id` IN (SELECT `id` FROM `phs_user` WHERE `name` LIKE "%COND_VALUE%")'
      ),
  );

  $vWhere = '';
  $vAnd = '';
  if ($oUser->TypeId > 0) {
    $vWhere = '`clinic_id`="' . $nClinicId . '"';
    $vAnd = ' AND ';
  }
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
  //$nCount = cAppointment::getCount($vWhere);
  $nCount = ph_GetDBValue('count(*)', 'clnc_vappointment', $vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncAppointment::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $IName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->IUserId . '"');
    $UName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->UUserId . '"');
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'ClinicId' => $object->ClinicId,
        'ClinicName' => $object->ClinicName,
        'DoctorId' => $object->DoctorId,
        'DoctorName' => $object->DoctorName,
        'PatientId' => $object->PatientId,
        'PatientNum' => $object->PatientNum,
        'PatientMobile' => $object->PatientMobile,
        'PatientNatNum' => $object->PatientNatNum,
        'PatientName' => $object->PatientName,
        'TypeId' => $object->TypeId,
        'TypeName' => $object->TypeName,
        'SpecialId' => $object->SpecialId,
        'SpecialName' => $object->SpecialName,
        'StatusId' => $object->StatusId,
        'StatusName' => $object->StatusName,
        'Date' => date_format(date_create($object->Date), 'd-m-Y'),
        'Hour' => $object->Hour,
        'Minute' => $object->Minute,
        'Time' => str_pad($object->Hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($object->Minute, 2, '0', STR_PAD_LEFT),
        'Description' => $object->Description,
        'Amount' => $object->Amount,
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
      'Data' => array(
          'last_page' => $nPages,
          'data' => $aData
      )
  );
  $oRest->setRowData($response);
}
