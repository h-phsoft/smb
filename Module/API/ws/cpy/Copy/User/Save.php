<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $nGrpId = ph_Get_Post('nGrp');
    $nStatusId = ph_Get_Post('nStatus');
    $nGenderId = ph_Get_Post('nGender');
    $vLogon = ph_Get_Post('vLogon');
    $vNPassword = ph_Get_Post('vNPassword');
    $vVPassword = ph_Get_Post('vVPassword');
    $vName = ph_Get_Post('vName');
    if ($nId > 0 || ($nId == 0 && $vNPassword === $vVPassword)) {
      $oInstance = cCpyUser::getInstance($nId);
      $oInstance->Id = $nId;
      $oInstance->GrpId = $nGrpId;
      $oInstance->StatusId = $nStatusId;
      $oInstance->GenderId = $nGenderId;
      $oInstance->Logon = $vLogon;
      $oInstance->Password = $vNPassword;
      $oInstance->Name = $vName;
      try {
        $nSavedId = $oInstance->save($oUser->Id);
        $oRest->setRowData(array(
          'Status' => true,
          'Message' => 'Done',
          'Id' => $nSavedId
        ));
      } catch (Exception $exc) {
        $oRest->setMessage($exc->getMessage());
      }
    }
  }
}