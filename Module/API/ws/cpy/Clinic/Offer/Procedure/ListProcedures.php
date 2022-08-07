<?php

if (isset($oRest)) {
  $nClinicId = ph_Session('UClinicId');
  $oUser = unserialize(ph_Session('User'));
  $nOId = ph_Get_Post('nOId');

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

  $vWhere = '`offer_id`="' . $nOId . '"';
  $vAnd = ' AND ';
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
  $nCount = cClncOfferProcedure::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncOfferProcedure::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $IName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->IUserId . '"');
    $UName = ph_GetDBValue('`name`', '`phs_user`', '`id`="' . $object->UUserId . '"');
    $aData[$nIdx] = array(
        'Id' => $object->Id,
        'CatId' => $object->CatId,
        'CatName' => $object->CatName,
        'ProcedureId' => $object->ProcedureId,
        'ProcedureName' => $object->ProcedureName,
        'Price' => $object->Price,
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
