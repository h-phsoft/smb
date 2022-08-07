<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $oObject = cPhsLang::getInstance($nId);
  $oObject->delete();
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}