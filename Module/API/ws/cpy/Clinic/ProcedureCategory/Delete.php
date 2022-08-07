<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');

  $oInstance = cClncProcedureCategory::getInstance($nId);
  $oInstance->delete();

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}