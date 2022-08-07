<?php

if (isset($oRest)) {

  $aList = cCpyWPeriod::getArray('id>0');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Order' => $element->Order,
      'Name' => $element->Name,
      'SDate' => date_format(date_create($element->SDate), 'Y-m-d'),
      'EDate' => date_format(date_create($element->EDate), 'Y-m-d'),
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