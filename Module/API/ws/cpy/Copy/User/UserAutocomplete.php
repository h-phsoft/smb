<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');

  $vWhere = '';
  if (isset($term)) {
    $vWhere .= '(`name` LIKE "%' . $term . '%" OR `logon` LIKE "%' . $term . '%")';
  }

  $aList = cCpyUser::getArray($vWhere, '', 1, 10);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Logon . ' - ' . $element->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}