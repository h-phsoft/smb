<?php

if (isset($oRest)) {

  $nFId = ph_Get_Post('nFId');
  $aData = array();
  $nIdx = 0;
  /*
    $vWhere = '`item_id`="' . $nIId . '"';
    $aList = cItemFormula::getArray($vWhere);
    foreach ($aList as $object) {
    $aData[$nIdx] = array(
    'Id' => $object->Id,
    'ItemId' => $object->ItemId,
    'ItemName' => $object->ItemName,
    'Qnt' => $object->Qnt
    );
    $nIdx++;
    }
   *
   */
  for ($index = 1; $index < 11; $index++) {
    $aData[$nIdx] = array(
      'Id' => $index,
      'ItemId' => $index,
      'ItemName' => 'Item ' . $index,
      'Qnt' => $index
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}