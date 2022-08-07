<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if (($nId == 0 && $oUserPerms->Insert) ||
          ($nId > 0 && $oUserPerms->Update)) {
    $nTypeId = intval(ph_Get_Post('nType'));
    $nBoxId = intval(ph_Get_Post('nBox'));
    $nCurnId = intval(ph_Get_Post('nCurn'));
    $nAccId = intval(ph_Get_Post('nAccId'));
    $nCostId = intval(ph_Get_Post('nCntrId'));
    $dDate = date_format(date_create(ph_Get_Post('dDate')), 'Y-m-d');
    $nCAmt = floatval(ph_Get_Post('nAmt'));
    $vRem = ph_Get_Post('vRem');
    $nRate = 1;
    $nAmt = $nCAmt * $nRate;

    $vFile = ph_Get_Post('vFile');
    $vFileName = ph_Get_Post('vFileName');
    $vExtention = substr($vFileName, strpos($vFileName, '.') + 1);
    $vFolder = 'diary';

    $oInstance = cFundDiary::getInstance($nId);
    if (intval($nId) >= 0) {
      if ($oInstance->Attach !== '') {
        if (!is_dir($vAttacheRootPath . 'diary/' . $oInstance->Attach)) {
          if (file_exists($vAttacheRootPath . 'diary/' . $oInstance->Attach)) {
            unlink($vAttacheRootPath . 'diary/' . $oInstance->Attach);
          }
        }
      }
    }
    $fileName = '';
    if ($vFile != null && $vFile != '') {
      $fileName = base64_to_file($vFile, 'fund_Attache', $vExtention, $vAttacheRootPath . 'diary');
    }
    $oInstance->BoxId = $nBoxId;
    $oInstance->CurnId = $nCurnId;
    $oInstance->TypeId = $nTypeId;
    $oInstance->AccId = $nAccId;
    $oInstance->CostId = $nCostId;
    $oInstance->Date = $dDate;
    $oInstance->CAmt = $nCAmt;
    $oInstance->Rate = $nRate;
    $oInstance->Amt = $nAmt;
    $oInstance->Rem = $vRem;
    $oInstance->Attach = $fileName;
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
