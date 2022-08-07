<?php

if (isset($oRest)) {

  $vCode = ph_Get_Post('code');
  $nId = ph_Get_Post('nId');
  $vName = ph_Get_Post('vName');
  $vRem = ph_Get_Post('vRem');

  $oInstance = new cPhsCode();
  $oInstance->vTable = $vCode;
  $oInstance->Id = $nId;
  $oInstance->Name = $vName;
  $oInstance->Rem = $vRem;
  $oInstance->save();

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}