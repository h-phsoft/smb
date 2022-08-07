<?php

if (isset($oRest)) {

  $nIId = ph_Get_Post('nIId');
  $vWhere = '`item_id`="' . $nIId . '"';
  $aList = cStrItemFormula::getArray($vWhere);
  $nCost = 0;
  $nPercent = floatval(cCpyPref::getPref('Profit_Percentage'));
  foreach ($aList as $oRowItem) {
    $oItem = cStrItem::getInstance($oRowItem->RowId);
    $nTCost = 0;
    if ($oItem->TypeId === 1) {
      $nTCost = $oItem->CCost;
    } else {
      $aTList = cStrItemFormula::getArray('item_id=' . $oItem->Id);
      foreach ($aTList as $tObject) {
        $oTItem = cStrItem::getInstance($tObject->RowId);
        $nTCost += ($tObject->Qnt * $oTItem->CCost);
      }
    }
    $nCost += $oRowItem->Qnt * $nTCost;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'nCost' => $nCost,
    'nSPrice' => round($nCost + ($nPercent * $nCost / 100))
  ));
}