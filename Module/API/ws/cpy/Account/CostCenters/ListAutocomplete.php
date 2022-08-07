<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');

  $vWhere = '';
  if (isset($term)) {
    $vWhere .= '(`num` LIKE "%' . $term . '%" OR `name` LIKE "%' . $term . '%")';
  }

  $aList = cAccCost::getArray($vWhere, '', 1, 10);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Num . ' - ' . $element->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}