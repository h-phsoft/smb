<?php

if (isset($oRest)) {

  $nFId = ph_Get_Post('nFId');
  $nFor = ph_Get_Post('nFor');
  $vDesc = ph_Get_Post('vDesc');
  $aRows = ph_Get_Post('aRows');

  $bIsAllOk = false;
  if ($nFId > 0) {
    cStrItem::updateFormula($nFId, $nFor, $vDesc);
    if (count($aRows) > 0) {
      $nTrnCount = 0;
      for ($ii = 0; $ii < count($aRows); $ii++) {
        $row = $aRows[$ii];
        $oTInstance = new cStrItemFormula();
        $oTInstance->ItemId = $nFId;
        $oTInstance->Id = intval($row['fields']['Id']['value']);
        if ($oTInstance->Id > 0) {
          $oTInstance = cStrItemFormula::getInstance($oTInstance->Id);
        }
        $oTInstance->ItemRId = floatval($row['fields']['ItemId']['value']);
        $oTInstance->Qnt = floatval($row['fields']['Qnt']['value']);
        try {
          if ($row['isDeleted'] === true || $row['isDeleted'] === 'true') {
            $nTrnCount++;
            $oTInstance->delete();
            $oRest->setRowData(array(
              'Status' => true,
              'Message' => 'Done'
            ));
            $bIsAllOk = true;
          } else {
            if ($oTInstance->Qnt > 0) {
              $nTrnCount++;
              $oTInstance->save($oUser->Id);
              $oRest->setRowData(array(
                'Status' => true,
                'Message' => 'Done',
                'Id' => $nSavedId
              ));
              $bIsAllOk = true;
            }
          }
        } catch (Exception $exc) {
          $oRest->setMessage($exc->getMessage());
        }
      }
      if ($nTrnCount == 0) {
        $bIsAllOk = false;
      }
    }
    try {
      if ($bIsAllOk) {
        ph_CommitTransaction();
      } else {
        ph_RollbackTransaction();
      }
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}