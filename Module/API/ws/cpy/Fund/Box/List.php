<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');

  $aFields = array(
    'Id' => array(
      'Name' => '`id`',
      'Cond' => '`id`="COND_VALUE"'
    ),
    'Name' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'UserName' => array(
      'Name' => '`user_name`',
      'Cond' => '`user_name` LIKE "%COND_VALUE%"'
    ),
    'AccName' => array(
      'Name' => '`acc_name`',
      'Cond' => '`acc_name` LIKE "%COND_VALUE%"'
    ),
    'Rem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
    ),
  );

  $vWhere = 'box_id>0';
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
  $nCount = cFundBox::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cFundBox::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Name' => $element->Name,
      'Rem' => $element->Rem,
      'Status' => $element->StatusId,
      'StatusName' => $element->StatusName,
      'User' => $element->UserId,
      'UserName' => $element->UserName,
      'Acc' => $element->AccId,
      'AccName' => $element->AccNum . ' - ' . $element->AccName
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => array(
      'last_page' => $nPages,
      'data' => $aData
    )
  ));
}