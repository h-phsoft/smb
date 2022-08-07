<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('id');

  $oInstance = cClncOfferProcedure::getInstance($nId);
  $oInstance->delete();

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}