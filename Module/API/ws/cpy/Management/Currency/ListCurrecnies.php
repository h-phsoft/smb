<?php

if (isset($oRest)) {

  $aList = cMngCurrency::getArray('id>0');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Num' => $element->Num,
      'Code' => $element->Code,
      'Name' => $element->Name,
      'Rate' => $element->Rate,
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