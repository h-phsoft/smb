<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {

    $oInstance = cClncProcedure::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->CatId = ph_Get_Post('nCatId');
    $oInstance->Code = ph_Get_Post('vCode');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Price = ph_Get_Post('nPrice');
    $oInstance->VatId = ph_Get_Post('nVatId');
    $oInstance->Vat = ph_Get_Post('nVat');
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save($oUser->Id);
      $oRest->addRowDataValue('Id', $nSavedId);
      if ($nSavedId > 0) {
        ph_CommitTransaction();
        $oRest->setStatus(true);
        $oRest->setMessage(getLabel('Done'));
      }
    } catch (Exception $exc) {
      ph_RollbackTransaction();
      $oRest->setStatus(false);
      $oRest->setMessage($exc->getMessage());
    }
  }
}
