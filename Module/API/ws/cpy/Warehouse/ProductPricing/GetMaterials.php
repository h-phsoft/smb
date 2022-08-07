<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();

  $aList = cWhsProductPriceTrn::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx++] = array(
      'id' => $element->Id,
      'mstId' => $element->MstId,
      'itemId' => $element->ItemId,
      'Cost' => $element->Cost,
      'SPrice' => $element->SPrice,
      'CPrice' => $element->CPrice,
      'Price' => $element->Price,
      'Rem' => $element->Rem
    );
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}