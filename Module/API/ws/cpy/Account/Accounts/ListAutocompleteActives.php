<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');

  $vWhere = '`type_id`=2';
  if (isset($term)) {
    $vWhere .= ' AND (`num` LIKE "%' . $term . '%" OR `name` LIKE "%' . $term . '%")';
  }

  $aList = cAccAcc::getArray($vWhere, '', 1, 10);
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