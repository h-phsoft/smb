<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aData = array();
  $aList = cStrClassacc::getArray('`mst_id`="' . $nId . '"');
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nTrntypeId' => $element->TrntypeId,
      'nSpc1Id' => $element->Spc1Id,
      'nSpc2Id' => $element->Spc2Id,
      'nSpc3Id' => $element->Spc3Id,
      'nSpc4Id' => $element->Spc4Id,
      'nSpc5Id' => $element->Spc5Id,
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
      'vSpc1Name' => $element->oSpc1->Name,
      'vSpc2Name' => $element->oSpc2->Name,
      'vSpc3Name' => $element->oSpc3->Name,
      'vSpc4Name' => $element->oSpc4->Name,
      'vSpc5Name' => $element->oSpc5->Name,
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
