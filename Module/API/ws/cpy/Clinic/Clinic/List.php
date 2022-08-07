<?php

if (isset($oRest)) {
  $aList = cClncClinic::getArray();
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nStatusId' => $element->StatusId,
      'vName' => $element->Name,
      'vPrefix' => $element->Prefix,
      'vEmail' => $element->Email,
      'vPhone1' => $element->Phone1,
      'vPhone2' => $element->Phone2,
      'vPhone3' => $element->Phone3,
      'vAddress' => $element->Address,
      'vStatusName' => $element->oStatus->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => $aData
  ));
}

