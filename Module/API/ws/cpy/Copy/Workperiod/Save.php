<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {

    $nOrder = ph_Get_Post('order');
    $vName = ph_Get_Post('name');
    $dSDate = ph_Get_Post('sdate');
    $dEDate = ph_Get_Post('edate');
    $vRem = ph_Get_Post('rem');

    $oInstance = cCpyWPeriod::getInstance($nId);
    $oInstance->Id = $nId;
    $oInstance->Order = $nOrder;
    $oInstance->Name = $vName;
    $oInstance->SDate = $dSDate;
    $oInstance->EDate = $dEDate;
    $oInstance->Rem = $vRem;
    $oInstance->save($oUser->Id);
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
