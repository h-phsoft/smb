<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if ($oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) {
    $nFBoxId = intval(ph_Get_Post('nFBox'));
    $nTBoxId = intval(ph_Get_Post('nTBox'));
    $nFCurnId = intval(ph_Get_Post('nFCurn'));
    $nTCurnId = intval(ph_Get_Post('nTCurn'));
    $nFCAmt = floatval(ph_Get_Post('nFAmt'));
    $nTCAmt = floatval(ph_Get_Post('nTAmt'));
    $nAccId = intval(ph_Get_Post('nAccId'));
    $nCostId = intval(ph_Get_Post('nCntrId'));
    $dDate = date_format(date_create(ph_Get_Post('dDate')), 'Y-m-d');
    $vRem = ph_Get_Post('vRem');
    $nFRate = 1;
    $nTRate = 1;
    $nFAmt = $nFCAmt * $nFRate;
    $nTAmt = $nTCAmt * $nTRate;

    $oFInstance = new cFundDiary();
    $oFInstance->Id = $nId;
    $oFInstance->BoxId = $nFBoxId;
    $oFInstance->CurnId = $nFCurnId;
    $oFInstance->TypeId = 2;
    $oFInstance->AccId = $nAccId;
    $oFInstance->CostId = $nCostId;
    $oFInstance->Date = $dDate;
    $oFInstance->CAmt = $nFCAmt;
    $oFInstance->Rate = $nFRate;
    $oFInstance->Amt = $nFAmt;
    $oFInstance->Rem = $vRem;
    try {
      $oFInstance->save($oUser->Id);
      $oTInstance = new cFundDiary();
      $oTInstance->Id = $nId;
      $oTInstance->BoxId = $nTBoxId;
      $oTInstance->CurnId = $nTCurnId;
      $oTInstance->TypeId = 1;
      $oTInstance->AccId = $nAccId;
      $oTInstance->CostId = $nCostId;
      $oTInstance->Date = $dDate;
      $oTInstance->CAmt = $nTCAmt;
      $oTInstance->Rate = $nTRate;
      $oTInstance->Amt = $nTAmt;
      $oTInstance->Rem = $vRem;
      $oTInstance->save($oUser->Id);
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done'
      ));
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}
