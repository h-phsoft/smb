<?php

if (isset($oRest)) {

  if ($aGUId['GId'] != '') {
    $oToken = cCpyToken::getInstanceByGUID($aGUId['GId']);
    $oToken->delete();
  }
  ph_SetSession('User');
  ph_SetSession('GUId');
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}

