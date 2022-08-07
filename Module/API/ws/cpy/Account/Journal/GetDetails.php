<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();

  $aList = cAccTrn::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $vAccName = ph_GetDBValue('concat(num," - ",name)', 'acc_acc', 'id=' . $element->AccId);
    $vCostName = ph_GetDBValue('concat(num," - ",name)', 'acc_cost', 'id=' . $element->CostId);
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'MstId' => $element->MstId,
      'AccId' => $element->AccId,
      'AccName' => $vAccName,
      'CostId' => $element->CostId,
      'CostName' => $vCostName,
      'CurnId' => $element->CurnId,
      'Rate' => $element->Rate,
      'DebC' => $element->DebC,
      'CrdC' => $element->CrdC,
      'Deb' => $element->Deb,
      'Crd' => $element->Crd,
      'Rem' => $element->Rem
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}