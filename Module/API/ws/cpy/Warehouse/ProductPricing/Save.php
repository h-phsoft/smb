<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $nNum = ph_Get_Post('nNum');
  $dDate = ph_Get_Post('dDate');
  $vRem = ph_Get_Post('vRem');
  $aRows = ph_Get_Post('aRows');

  $oInstance = new cWhsProductPriceMst();
  $oInstance->Id = $nId;
  $oInstance->Num = $nNum;
  $oInstance->Date = $dDate;
  $oInstance->Rem = $vRem;
  try {
    $nSavedId = $oInstance->save($oUser->Id);
    if ($nSavedId > 0) {
      for ($ii = 0; $ii < count($aRows); $ii++) {
        $row = $aRows[$ii];
        $oTInstance = new cWhsProductPriceTrn();
        $oTInstance->MstId = $nSavedId;
        $oTInstance->Id = $row['fields']['id']['value'];
        $oTInstance->ItemId = $row['fields']['itemId']['value'];
        $oTInstance->Cost = $row['fields']['Cost']['value'];
        $oTInstance->SPrice = $row['fields']['SPrice']['value'];
        $oTInstance->CPrice = $row['fields']['CPrice']['value'];
        $oTInstance->Price = $row['fields']['Price']['value'];
        $oTInstance->Rem = $row['fields']['Rem']['value'];
        if ($row['isDeleted'] === 'true') {
          $oTInstance->delete();
        } else {
          $oTInstance->save($oUser->Id);
        }
      }
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done',
        'Id' => $nSavedId
      ));
    }
  } catch (Exception $exc) {
    $oRest->setMessage($exc->getMessage());
  }
}