<?php

if (isset($oRest)) {

  $dDate = ph_Get_Post('dDate');
  $aRates = ph_Get_Post('aRates');
  for ($ii = 0; $ii < count($aRates); $ii++) {
    $currency = $aRates[$ii];
    $oCurrency = cMngCurrency::getInstance($currency['nId']);
    if (floatval($oCurrency->Rate) != floatval($currency['nRate'])) {
      $oCurrency->Rate = $currency['nRate'];
      $oCurrency->updateRate($oUser->Id, $dDate);
    }
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}