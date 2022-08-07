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
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'vCurnName' => array(
      'Name' => '`curn_id`',
      'Cond' => '`curn_id` IN (SELECT id FROM mng_curn WHERE code LIKE "%COND_VALUE%")'
    ),
    'dSdate' => array(
      'Name' => '`sdate`',
      'Cond' => '`sdate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'dEdate' => array(
      'Name' => '`edate`',
      'Cond' => '`edate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'vRem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
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
  $nCount = cSalMprice::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cSalMprice::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'vName' => $element->Name,
      'nCurnId' => $element->CurnId,
      'dSdate' => date_format(date_create($element->Sdate), 'Y-m-d'),
      'dEdate' => date_format(date_create($element->Edate), 'Y-m-d'),
      'vRem' => $element->Rem,
      'vCurnName' => $element->oCurn->Code,
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
