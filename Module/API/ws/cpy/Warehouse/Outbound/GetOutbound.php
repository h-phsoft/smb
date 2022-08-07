<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();

  $aList = cStrOuTrn::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'MstId' => $element->MstId,
      'ItemId' => $element->ItemId,
      'Item' => $element->ItemNum . ' ' . $element->ItemName,
      'Qnt' => $element->Qnt,
      'Blnc' => 0,
      'Rem' => $element->Rem
    );
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}