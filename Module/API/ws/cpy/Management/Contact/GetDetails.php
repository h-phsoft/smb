<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();
  $aList = cMngContCont::getArray('`cont_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nContId' => $element->ContId,
      'vName' => $element->Name,
      'vPosition' => $element->Position,
      'vMobile' => $element->Mobile,
      'vPhone' => $element->Phone,
      'vEmail' => $element->Email,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => $aData
  ));
}
