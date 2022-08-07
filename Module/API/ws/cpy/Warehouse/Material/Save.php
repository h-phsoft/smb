<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $vNum = ph_Get_Post('vNum');
  $vName = ph_Get_Post('vName');
  $vRem = ph_Get_Post('vRem');
  $nCost = ph_Get_Post('nCost');
  $nNPrice = ph_Get_Post('nNPrice');
  $nStatus = ph_Get_Post('nStatus');
  $nUnit = ph_Get_Post('nUnit');
  $nSpc1 = ph_Get_Post('nSpc1');
  $nSpc2 = ph_Get_Post('nSpc2');
  $nSpc3 = ph_Get_Post('nSpc3');

  $vFile = ph_Get_Post('vFile');
  $vFileName = ph_Get_Post('vFileName');
  $vType = ph_Get_Post('vType');
  $vExtention = substr($vFileName, strpos($vFileName, '.') + 1);
  $vFolder = ph_Get_Post('vFolder');

  $oInstance = new cStrItem();
  if (intval($nId) > 0) {
    $oInstance = cStrItem::getInstance($nId);
    if ($oInstance->Image !== '') {
      if (file_exists($vAttacheRootPath . $vFolder . '/' . $oInstance->Image)) {
        unlink($vAttacheRootPath . $vFolder . '/' . $oInstance->Image);
      }
    }
  }
  $fileName = '';
  if ($vFile != null && $vFile != '') {
    $fileName = base64_to_file($vFile, 'cpy_Attache', $vExtention, $vAttacheRootPath . $vFolder);
  }

  $oInstance->Num = $vNum;
  $oInstance->PartNum = $vNum;
  $oInstance->Name = $vName;
  $oInstance->Rem = $vRem;
  $oInstance->CCost = $nCost;
  $oInstance->nPrice = $nNPrice;
  $oInstance->Status = $nStatus;
  $oInstance->UnitId = $nUnit;
  $oInstance->Spc1Id = $nSpc1;
  $oInstance->Spc2Id = $nSpc2;
  $oInstance->Spc3Id = $nSpc3;
  $oInstance->Image = $fileName;
  try {
    $nSavedId = $oInstance->save($oUser->Id);
    $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done',
        'Id' => $nSavedId,
        'fileName' => $fileName
    ));
  } catch (Exception $exc) {
    $oRest->setMessage($exc->getMessage());
  }
}