<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();
  $aList = cStrStracc::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nStorId' => $element->StorId,
      'nTrntypeId' => $element->TrntypeId,
      'nCostId' => $element->CostId,
      'nAccSid' => $element->AccSid,
      'nAccCid' => $element->AccCid,
      'nAccRid' => $element->AccRid,
      'nAccMid' => $element->AccMid,
      'nAccDid' => $element->AccDid,
      'vRem' => $element->Rem,
      'vAccCName' => $element->oAccC->Name,
      'vAccDName' => $element->oAccD->Name,
      'vAccMName' => $element->oAccM->Name,
      'vAccRName' => $element->oAccR->Name,
      'vAccSName' => $element->oAccS->Name,
      'vCostName' => $element->oCost->Name,
      'vStorName' => $element->oStor->Name,
      'vTrntypeName' => $element->oTrntype->Name,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => $aData
  ));
}
