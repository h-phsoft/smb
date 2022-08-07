<?php

if (isset($oRest)) {

  $vTable = ph_Get_Post('table');
  $term = ph_Get_Post('term');
  $vWhere = '';
  if (isset($term)) {
    $vWhere .= '`name` LIKE "%' . $term . '%"';
  }
  $aList = cPhsCode::getArray($vTable, $vWhere);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => getLabel($element->Name)
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}