<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $aRows = ph_Get_Post('aRows');
    $bIsAllOk = false;
    if (count($aRows) > 0) {
      ph_BeginTransaction();
      $oInstance = cStrInMst::getInstance($nId);
      $oInstance->MstId = $nId;
      $oInstance->WPerId = $oWPeriod->Id;
      $oInstance->StorId = intval(ph_Get_Post('nStore'));
      $oInstance->AccId = intval(ph_Get_Post('nAcc'));
      $oInstance->CosId = intval(ph_Get_Post('nCost'));
      $oInstance->MstNum = intval(ph_Get_Post('nNum'));
      $oInstance->MstDate = ph_Get_Post('dDate');
      $oInstance->DocId = intval(ph_Get_Post('nDoc'));
      $oInstance->DocNum = ph_Get_Post('vDocN');
      $oInstance->DocDate = ph_Get_Post('dDocD');
      $oInstance->MstRem = ph_Get_Post('vRem');
      try {
        $oRest->setMessage(getLabel('Master Not Inserted'));
        $nSavedId = $oInstance->save($oUser->Id);
        if ($nSavedId > 0) {
          $nTrnCount = 0;
          $oRest->setMessage(getLabel('No Transaction Records'));
          for ($ii = 0; $ii < count($aRows); $ii++) {
            $row = $aRows[$ii];
            $oTInstance = new cStrInTrn();
            $oTInstance->MstId = $nSavedId;
            $oTInstance->Id = intval($row['fields']['Id']['value']);
            if ($oTInstance->Id > 0) {
              $oTInstance = cStrInTrn::getInstance($oTInstance->Id);
            }
            if ($row['isDeleted'] === true || $row['isDeleted'] === 'true') {
              $nTrnCount++;
              $oTInstance->delete();
              $oStrItem = cStrStoreItem::getMaterial('`stor_id`="' . $oInstance->StorId . '" AND `item_id`="' . $oTInstance->ItemId . '"');
              $oStrItem->subtractQnt($oTInstance->Qnt, $oTInstance->Amt);
            } else {
              if ($oTInstance->Id > 0) {
                $oStrItem = cStrStoreItem::getMaterial('`stor_id`="' . $oInstance->StorId . '" AND `item_id`="' . $oTInstance->ItemId . '"');
                $oStrItem->subtractQnt($oTInstance->Qnt, $oTInstance->Amt);
              }
              $oTInstance->ItemId = intval($row['fields']['ItemId']['value']);
              $oTInstance->Qnt = floatval($row['fields']['Qnt']['value']);
              $oTInstance->Price = floatval($row['fields']['Price']['value']);
              $oTInstance->Amt = floatval($row['fields']['Amt']['value']);
              $oTInstance->Rem = $row['fields']['Rem']['value'];
              if ($oTInstance->Qnt > 0) {
                try {
                  $nTrnCount++;
                  $oTInstance->save($oUser->Id);
                  $oStrItem = cStrStoreItem::getMaterial('`stor_id`="' . $oInstance->StorId . '" AND `item_id`="' . $oTInstance->ItemId . '"');
                  $oStrItem->addQnt($oTInstance->Qnt, $oTInstance->Amt);
                  $bIsAllOk = true;
                } catch (Exception $exc) {
                  $bIsAllOk = false;
                  $oRest->setMessage($exc->getMessage());
                }
              }
            }
          }
        }
      } catch (Exception $exc) {
        $oRest->setMessage($exc->getMessage());
      }
      try {
        if ($bIsAllOk) {
          ph_CommitTransaction();
          $oRest->setRowData(array(
            'Status' => true,
            'Message' => 'Done',
            'Id' => $nSavedId
          ));
        } else {
          ph_RollbackTransaction();
        }
      } catch (Exception $exc) {
        $oRest->setMessage($exc->getMessage());
      }
    }
  }
}