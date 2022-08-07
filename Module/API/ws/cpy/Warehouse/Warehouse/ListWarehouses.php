<?php

if (isset($oRest)) {

  $aList = cStrStore::getArray('id>0');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
        'Id' => $element->Id,
        'Num' => $element->Num,
        'Name' => $element->Name,
        'Rem' => $element->Rem,
        'Type' => $element->TypeId,
        'Owned' => $element->IsOwned,
        'Status' => $element->StatusId,
        'SDate' => date_format(date_create($element->SDate), 'Y-m-d'),
        'EDate' => date_format(date_create($element->EDate), 'Y-m-d'),
        'Address' => $element->Address,
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