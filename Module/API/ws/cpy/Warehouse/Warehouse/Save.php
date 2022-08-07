<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if ((($nId == 0) && ($oUserPerms->Insert)) ||
          (($nId > 0) && ($oUserPerms->Update))) {
    $nNum = ph_Get_Post('nNum');
    $vName = ph_Get_Post('vName');
    $vAddress = ph_Get_Post('vAddress');
    $vRem = ph_Get_Post('vRem');
    $nType = ph_Get_Post('nType');
    $nStatus = ph_Get_Post('nStatus');
    $nOwned = ph_Get_Post('nOwned');
    $dSDate = ph_Get_Post('dSDate');
    $dEDate = ph_Get_Post('dEDate');

    $oInstance = cStrStore::getInstance($nId);
    $oInstance->Num = $nNum;
    $oInstance->Name = $vName;
    $oInstance->Rem = $vRem;
    $oInstance->Address = $vAddress;
    $oInstance->TypeId = $nType;
    $oInstance->StatusId = $nStatus;
    $oInstance->IsOwned = $nOwned;
    $oInstance->SDate = $dSDate;
    $oInstance->EDate = $dEDate;
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