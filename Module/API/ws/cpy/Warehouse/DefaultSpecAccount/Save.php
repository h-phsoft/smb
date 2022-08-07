<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cStrClassacc::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->TrntypeId = ph_Get_Post('nTrntypeId');
    $oInstance->Spc1Id = ph_Get_Post('nSpc1Id');
    $oInstance->Spc2Id = ph_Get_Post('nSpc2Id');
    $oInstance->Spc3Id = ph_Get_Post('nSpc3Id');
    $oInstance->Spc4Id = ph_Get_Post('nSpc4Id');
    $oInstance->Spc5Id = ph_Get_Post('nSpc5Id');
    $oInstance->CostId = ph_Get_Post('nCostId');
    $oInstance->AccSid = ph_Get_Post('nAccSid');
    $oInstance->AccCid = ph_Get_Post('nAccCid');
    $oInstance->AccRid = ph_Get_Post('nAccRid');
    $oInstance->AccMid = ph_Get_Post('nAccMid');
    $oInstance->AccDid = ph_Get_Post('nAccDid');
    $oInstance->Rem = ph_Get_Post('vRem');
    $bIsAllOk = true;
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save($oUser->Id);
      if ($nSavedId > 0) {
      } else {
        $bIsAllOk = false;
      }
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
    try {
      if ($bIsAllOk) {
        ph_CommitTransaction();
        $oRest->setRowData(array(
          'Status' => true,
          'Message' => getLabel('Done'),
          'Id' => $nSavedId
        ));
      } else {
        ph_RollbackTransaction();
      }
    } catch (Exception $exc) {
      $vMessage = $exc->getMessage();
    }
  }
}
