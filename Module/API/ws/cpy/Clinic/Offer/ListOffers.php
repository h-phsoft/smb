<?php

if (isset($oRest)) {
  $nClinicId = ph_Session('UClinicId');
  $oUser = unserialize(ph_Session('User'));

  $nCurrentOffer = intval(cSetting::getSetting('Current-Offer'));

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');

  $aFields = array(
      'Name' => array(
          'Name' => '`name`',
          'Cond' => '`name` LIKE "%COND_VALUE%"'
      ),
      'StatusName' => array(
          'Name' => '`status_name`',
          'Cond' => '`status_name` LIKE "%COND_VALUE%"'
      ),
      'SDate' => array(
          'Name' => '`sdate`',
          'Cond' => '`sdate` LIKE "%COND_VALUE%"'
      ),
      'EDate' => array(
          'Name' => '`edate`',
          'Cond' => '`edate` LIKE "%COND_VALUE%"'
      ),
      'Description' => array(
          'Name' => '`description`',
          'Cond' => '`description` LIKE "%COND_VALUE%"'
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
  $nCount = cClncOffer::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncOffer::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $nActive = 0;
    if ($nCurrentOffer === $object->Id) {
      $nActive = 1;
    }
    $vClincs = '';
    $vComma = '';
    foreach ($object->aClinics as $clinic) {
      $vClincs .= $vComma . $clinic->Name;
      $vComma = ', ';
    }
    $IName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->IUserId . '"');
    $UName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->UUserId . '"');
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'nActive' => $nActive,
        'Name' => $object->Name,
        'StatusId' => $object->StatusId,
        'StatusName' => $object->StatusName,
        'SDate' => date_format(date_create($object->SDate), 'd-m-Y'),
        'EDate' => date_format(date_create($object->EDate), 'd-m-Y'),
        'Description' => $object->Description,
        'aClinics' => $object->aClinics,
        'vClincs' => $vClincs,
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
