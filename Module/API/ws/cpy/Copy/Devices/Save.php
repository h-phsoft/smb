<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cCpyDevice::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Guid = ph_Get_Post('vGuid');
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->Shour = ph_Get_Post('nShour');
    $oInstance->Sminute = ph_Get_Post('nSminute');
    $oInstance->Ehour = ph_Get_Post('nEhour');
    $oInstance->Eminute = ph_Get_Post('nEminute');
    $oInstance->Day1 = ph_Get_Post('nDay1');
    $oInstance->Day2 = ph_Get_Post('nDay2');
    $oInstance->Day3 = ph_Get_Post('nDay3');
    $oInstance->Day4 = ph_Get_Post('nDay4');
    $oInstance->Day5 = ph_Get_Post('nDay5');
    $oInstance->Day6 = ph_Get_Post('nDay6');
    $oInstance->Day7 = ph_Get_Post('nDay7');
    $oInstance->AddedAt = ph_Get_Post('dAddedAt');
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
