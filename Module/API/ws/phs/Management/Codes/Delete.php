<?php

if (isset($oRest)) {

  $vCode = ph_Get_Post('code');
  $nId = ph_Get_Post('nId');
  $oObject = cPhsCode::getInstance($vCode, $nId);
  $oObject->delete();
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}