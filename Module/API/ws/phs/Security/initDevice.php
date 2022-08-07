<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Error Declared Device'));
  $oRCopy = cPhsCpy::getInstanceByGId(ph_Get_Post('vCId'));
  if ($oRCopy->GId == $oCopy->GId) {
    $oDevice = cCpyDevice::getInstanceByGId(ph_Get_Post('vDId'));
    if ($oDevice->StatusId == 2) {
      $oDevice->enable();
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Welcome to ' . $oRCopy->Name,
        'Data' => array(
          'vCId' => $oRCopy->GId,
          'vDId' => $oDevice->Guid,
          'EDate' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +365 day'))
        )
      ));
    }
  }
}
