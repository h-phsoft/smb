<?php

if (isset($oRest)) {

  $nId = intval(ph_Get_Post('nId'));
  if (($nId == 0 && $oUserPerms->Insert) ||
          ($nId > 0 && $oUserPerms->Update)) {
    $nNum = ph_Get_Post('nNum');
    $dDate = ph_Get_Post('dDate');
    $vRem = ph_Get_Post('vRem');
    $aRows = ph_Get_Post('aRows');

    $bIsAllOk = false;
    if (count($aRows) > 0) {
      $oInstance = cAccMst::getInstance($nId);
      $oInstance->Num = $nNum;
      $oInstance->Date = $dDate;
      $oInstance->Rem = $vRem;
      try {
        $nSavedId = $oInstance->save($oUser->Id);
        if ($nSavedId > 0) {
          $nTrnCount = 0;
          $oRest->setMessage(getLabel('No Details'));
          for ($ii = 0; $ii < count($aRows); $ii++) {
            $row = $aRows[$ii];
            $oTInstance = cAccTrn::getInstance(intval($row['fields']['Id']['value']));
            $oTInstance->Id = intval($row['fields']['Id']['value']);
            $oTInstance->MstId = $nSavedId;
            $oTInstance->DebC = floatval($row['fields']['DebC']['value']);
            $oTInstance->CrdC = floatval($row['fields']['CrdC']['value']);
            $oTInstance->AccId = intval($row['fields']['AccId']['value']);
            $oTInstance->CostId = intval($row['fields']['CostId']['value']);
            $oTInstance->CurnId = intval($row['fields']['CurnId']['value']);
            $oTInstance->Rate = floatval($row['fields']['Rate']['value']);
            $oTInstance->Deb = floatval($row['fields']['Deb']['value']);
            $oTInstance->Crd = floatval($row['fields']['Crd']['value']);
            $oTInstance->Rem = $row['fields']['Rem']['value'];
            try {
              if ($row['isDeleted'] === true || $row['isDeleted'] === 'true') {
                $nTrnCount++;
                $oTInstance->delete();
              } else {
                if ($oTInstance->DebC > 0 || $oTInstance->CrdC > 0 || $oTInstance->Deb > 0 || $oTInstance->Crd > 0) {
                  $nTrnCount++;
                  $oTInstance->save($oUser->Id);
                }
              }
              $bIsAllOk = true;
            } catch (Exception $exc) {
              $bIsAllOk = false;
              $oRest->setMessage($exc->getMessage());
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