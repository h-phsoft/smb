<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $vCode = ph_Get_Post('code');
  $vName = ph_Get_Post('vName');
  $vDir = ph_Get_Post('vDir');
  $vRem = ph_Get_Post('vRem');

  $oInstance = cPhsLang::getInstanceById($nId);
  $oInstance->Code = $vCode;
  $oInstance->Name = $vName;
  $oInstance->Direction = $vDir;
  $oInstance->Rem = $vRem;
  $oInstance->save();
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}