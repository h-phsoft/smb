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
    'nStorId' => array(
      'Name' => '`stor_id`',
      'Cond' => '`stor_id`="COND_VALUE"'
    ),
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'vRem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
    ),
    'nInsUser' => array(
      'Name' => '`ins_user`',
      'Cond' => '`ins_user`="COND_VALUE"'
    ),
    'dInsDate' => array(
      'Name' => '`ins_date`',
      'Cond' => '`ins_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'nUpdUser' => array(
      'Name' => '`upd_user`',
      'Cond' => '`upd_user`="COND_VALUE"'
    ),
    'dUpdDate' => array(
      'Name' => '`upd_date`',
      'Cond' => '`upd_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'vStorName' => array(
      'Name' => '`stor_id`',
      'Cond' => '`stor_id` IN (SELECT `id` FROM `str_store` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cClncSpecialtie::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncSpecialtie::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nStorId' => $element->StorId,
      'vName' => $element->Name,
      'vRem' => $element->Rem, 
      'vStorName' => $element->oStor->Name,
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
