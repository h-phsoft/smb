<?php

if (isset($oRest)) {

  $nStore = ph_Get_Post('store');
  $nItem = ph_Get_Post('item');

  $element = cStrStoreItem::getMaterial('`stor_id`="' . $nStore . '" AND `item_id`="' . $nItem . '"');
  $aData = array(
    'Id' => $element->Id,
    'StorNum' => $element->StorNum,
    'StorName' => $element->StorName,
    'Num' => $element->ItemNum,
    'Name' => $element->ItemName,
    'Unit' => $element->ItemUnitId,
    'UnitName' => $element->ItemUnitName,
    'Qnt1' => $element->Qnt1,
    'Qnt2' => $element->Qnt2,
    'Qnt3' => $element->Qnt3
  );
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}