<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');
  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $nStrId = intval(ph_Get_Post('nStrId'));

  if (!isset($page) || $page === null || $page === '') {
    $page = 1;
  }
  if (!isset($size) || $size === null || $size === '') {
    $size = 10;
  }

  $vWhere = '';
  $vAnd = '';
  if (isset($term)) {
    $vWhere .= '(name LIKE "%' . $term . '%" OR num LIKE "%' . $term . '%")';
    $vAnd = ' AND ';
  }
  if (isset($nStrId) && $nStrId > 0) {
    $vWhere .= $vAnd . 'id IN (SELECT item_id FROM str_sitem WHERE stor_id="' . $nStrId . '")';
  }
  $vOrder = '';

  $aList = cStrItem::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Num . ' ' . $element->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}