<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Somthing Wrong!!!'));
  $oToken = cCpyToken::getNewInstance(ph_ServerVar('REMOTE_ADDR'));
  if ($oToken->Id > 0) {
    $aGUId['GId'] = $oToken->Gid;
    $aGUId['SDate'] = $oToken->Sdate;
    $aGUId['EDate'] = $oToken->Edate;
    $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aGUId
    ));
  }
}
