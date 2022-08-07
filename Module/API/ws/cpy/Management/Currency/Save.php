<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $nNum = ph_Get_Post('num');
    $vCode = ph_Get_Post('code');
    $vName = ph_Get_Post('name');
    $nRate = ph_Get_Post('rate');
    $vRem = ph_Get_Post('rem');
    $oInstance = new cMngCurrency();
    $oInstance->Id = $nId;
    $oInstance->Num = $nNum;
    $oInstance->Code = $vCode;
    $oInstance->Name = $vName;
    $oInstance->Rate = $nRate;
    $oInstance->Rem = $vRem;
    $nSavedId = $oInstance->save($oUser->Id);
    $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Id' => $nSavedId
    ));
  }
}