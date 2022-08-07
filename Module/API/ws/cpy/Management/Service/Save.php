<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cMngService::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->Code = ph_Get_Post('vCode');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Cst = ph_Get_Post('nCst');
    $oInstance->CostId = ph_Get_Post('nCostId');
    $oInstance->AccCid = ph_Get_Post('nAccCid');
    $oInstance->AccRid = ph_Get_Post('nAccRid');
    $oInstance->UnitId = ph_Get_Post('nUnitId');
    $oInstance->Grp = ph_Get_Post('vGrp');
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
