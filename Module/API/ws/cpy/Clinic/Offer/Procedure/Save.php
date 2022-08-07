<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nOId = ph_Get_Post('nOId');
  $nProcId = ph_Get_Post('nProcId');
  $nPrice = ph_Get_Post('nPrice');

  $oInstance = new cClncOfferProcedure();
  $oInstance->OfferId = $nOId;
  $oInstance->ProcedureId = $nProcId;
  $oInstance->Price = $nPrice;
  $oInstance->save($oUser->Id);

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}