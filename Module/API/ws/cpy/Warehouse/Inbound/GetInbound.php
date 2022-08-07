<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();

  $aList = cStrInTrn::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $vItemName = ph_GetDBValue('concat(num," ",name)', 'str_item', 'id="' . $element->ItemId . '"');
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'MstId' => $element->MstId,
      'ItemId' => $element->ItemId,
      'Item' => $vItemName,
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