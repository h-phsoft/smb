<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Somthing Wrong!!!'));
  $oToken = cCpyToken::getNewInstance(ph_ServerVar('REMOTE_ADDR'));
  if ($oToken->Id > 0) {
    $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => array(
        'Id' => $oToken->Id,
        'GUID' => $oToken->Gid,
        'SDate' => $oToken->Sdate,
        'EDate' => $oToken->Edate
      )
    ));
  }
}
