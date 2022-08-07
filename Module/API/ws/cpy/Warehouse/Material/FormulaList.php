<?php

if (isset($oRest)) {

  $nFId = ph_Get_Post('nFId');

  $oFItem = cStrItem::getInstance($nFId);
  $aList = cStrItemFormula::getArray('item_id="' . $nFId . '"');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $oItem = cStrItem::getInstance($element->ItemRId);
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'ItemFId' => $element->ItemId,
      'ItemId' => $element->ItemRId,
      'Item' => $oItem->Name,
      'Unit' => $oItem->oUnit->Name,
      'Box' => $oItem->Box,
      'Qnt' => $element->Qnt,
      'Image' => $vMediaCopyRootPath . 'item/' . $element->Image
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData,
    'FQnt' => $oFItem->FQnt
  ));
}