<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');

  $vWhere = '(`id`>0)';
  if (isset($term)) {
    $vWhere .= ' AND (`num` LIKE "%' . $term . '%" OR `name` LIKE "%' . $term . '%" OR `code` LIKE "%' . $term . '%")';
  }

  $aList = cMngCurrency::getArray($vWhere);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Code
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}