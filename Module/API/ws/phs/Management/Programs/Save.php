<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cPhsProgram::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->ProgId = ph_Get_Post('nProgId');
    $oInstance->SysId = ph_Get_Post('nSysId');
    $oInstance->GrpId = ph_Get_Post('nGrp');
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->TypeId = ph_Get_Post('nTypeId');
    $oInstance->Open = ph_Get_Post('nOpen');
    $oInstance->Ord = ph_Get_Post('nOrd');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Icon = ph_Get_Post('vIcon');
    $oInstance->File = ph_Get_Post('vFile');
    $oInstance->Css = ph_Get_Post('vCss');
    $oInstance->Js = ph_Get_Post('vJs');
    $oInstance->Attributes = ph_Get_Post('vAttributes');
    $bIsAllOk = true;
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save();
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
