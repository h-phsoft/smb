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
    'StorNum' => array(
      'Name' => '`stor_num`',
      'Cond' => '`stor_num`="COND_VALUE"'
    ),
    'StorName' => array(
      'Name' => '`stor_name`',
      'Cond' => '`stor_name` LIKE "%COND_VALUE%"'
    ),
    'Num' => array(
      'Name' => '`item_num`',
      'Cond' => '`item_num` LIKE "%COND_VALUE%"'
    ),
    'Name' => array(
      'Name' => '`item_name`',
      'Cond' => '`item_name` LIKE "%COND_VALUE%"'
    ),
    'Unit' => array(
      'Name' => '`item_unit_id`',
      'Cond' => '`item_unit_id` = "COND_VALUE"'
    ),
    'UnitName' => array(
      'Name' => '`item_unit_name`',
      'Cond' => '`item_unit_name` LIKE "%COND_VALUE%"'
    ),
    'Qnt1' => array(
      'Name' => '`cqnt1`',
      'Cond' => '`cqnt1`="COND_VALUE"'
    ),
    'Qnt2' => array(
      'Name' => '`cqnt2`',
      'Cond' => '`cqnt2`="COND_VALUE"'
    ),
    'Qnt3' => array(
      'Name' => '`cqnt3`',
      'Cond' => '`cqnt3`="COND_VALUE"'
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
  $nCount = cStrStoreItem::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrStoreItem::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'StorNum' => $element->StorNum,
      'StorName' => $element->StorName,
      'Num' => $element->ItemNum,
      'Name' => $element->ItemName,
      'Unit' => $element->ItemUnitId,
      'UnitName' => $element->ItemUnitName,
      'Qnt1' => $element->Qnt1,
      'Qnt2' => $element->Qnt2,
      'Qnt3' => $element->Qnt3
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