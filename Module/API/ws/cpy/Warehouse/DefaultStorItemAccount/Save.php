<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cStrSiacc::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->StorId = ph_Get_Post('nStorId');
    $oInstance->ItemId = ph_Get_Post('nItemId');
    $oInstance->TrntypeId = ph_Get_Post('nTrntypeId');
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
