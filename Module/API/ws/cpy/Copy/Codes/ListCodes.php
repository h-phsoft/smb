<?php

if (isset($oRest)) {

  $vCode = ph_Get_Post('code');
  $aList = cCpyCode::getArray($vCode, 'id>0');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Name' => $element->Name,
      'Rem' => $element->Rem
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}