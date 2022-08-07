<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('id');
  $aData = array();
  $aList = cSalTprice::getArray('`price_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    if ($element->TypeId == 1) {
      $dNameId = $element->ItemId;
      $dName = $element->oItem->Name;
    } else if ($element->TypeId == 2) {
      $dNameId = $element->ServId;
      $dName = $element->oServ->Name;
    }
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nPriceId' => $element->PriceId,
      'nTypeId' => $element->TypeId,
      'vTypeName' => $element->oType->Name,
      'nDNameId' => $dNameId,
      'vDName' => $dName,
      'nPrice' => $element->Price,
      'vRem' => $element->Rem
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => $aData
  ));
}
