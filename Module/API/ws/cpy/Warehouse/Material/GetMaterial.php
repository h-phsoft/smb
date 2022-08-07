<?php

if (isset($oRest)) {

  $nItem = ph_Get_Post('nItemId');

  $element = cStrItem::getInstance($nItem);
  $aData = array(
    'Id' => $element->Id,
    'Num' => $element->Num,
    'Name' => $element->Name,
    'Unit' => $element->UnitId,
    'UnitName' => $element->UnitName,
    'Box' => $element->Box,
    'Desc' => $element->Desc
  );
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}