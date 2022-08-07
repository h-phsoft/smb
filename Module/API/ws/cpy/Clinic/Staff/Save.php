<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)
  ) {
    $vPassWord = ph_Get_Post('vVPassword');
    $oInstance = cClncStaff::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->TypeId = ph_Get_Post('nTypeId');
    // $oInstance->GrpId = ph_Get_Post('nGrpId');
    $oInstance->GrpId = 0;
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->GenderId = ph_Get_Post('nGenderId');
    $oInstance->SpecialId = ph_Get_Post('nSpecialId');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Username = ph_Get_Post('vUsername');
    $oInstance->Password = ph_Get_Post('vPassword');
    $oInstance->Rem = ph_Get_Post('vRem');
    // $oInstance->Image = ph_Get_Post('vImage');
    if (ph_Get_Post('vPassword') == $vPassWord) {
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
}
