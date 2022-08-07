<?php

if (isset($oRest)) {
  $aList = cAccAcc::getArray('id>0');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Num' => $element->Num,
      'Name' => $element->Name,
      'Rem' => $element->Rem,
      'Status' => $element->StatusId,
      'StatusName' => $element->StatusName,
      'Type' => $element->TypeId,
      'TypeName' => $element->TypeName,
      'DbCr' => $element->DbCrId,
      'DbCrName' => $element->DbCrName,
      'Close' => $element->CloseId,
      'CloseName' => $element->CloseName
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}