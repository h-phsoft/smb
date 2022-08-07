<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $oCurrency = cMngCurrency::getInstance($nId);
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'nRate' => $oCurrency->Rate
  ));
}