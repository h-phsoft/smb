<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('id');

  $oInstance = cClncAppType::getInstance($nId);
  $oInstance->delete();

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}