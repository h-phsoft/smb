<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');

  $vWhere = 'id>0';
  if (isset($term)) {
    $vWhere .= ' AND (`code` LIKE "%' . $term . '%" OR `name` LIKE "%' . $term . '%")';
  }

  $aList = cMngService::getArray($vWhere, '', 1, 10);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Code . ' - ' . $element->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}