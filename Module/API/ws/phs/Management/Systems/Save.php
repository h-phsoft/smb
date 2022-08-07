<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cPhsSystem::getInstance($nId);
    $oInstance->Id = ph_Get_Post('nId');
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->Name = ph_Get_Post('vName');
    $bIsAllOk = true;
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save($oUser->Id);
      if ($nSavedId > 0) {
        $aRows = ph_Get_Post('aRows');
        $oRest->setMessage(getLabel('No Details'));
        if (count($aRows) > 0) {
          $nTrnCount = 0;
          for ($ii = 0; $ii < count($aRows); $ii++) {
            $row = $aRows[$ii];
            $oTInstance = new cPhsSystem();
            $oTInstance->MstId = $nSavedId;
            $oTInstance->Id = intval($row['fields']['Id']['value']);
            if ($oTInstance->Id > 0) {
              $oTInstance = cPhsSystem::getInstance($oTInstance->Id);
            }
            $oTInstance->Id = intval($row['fields']['nId']['value']);
            $oTInstance->StatusId = intval($row['fields']['nStatusId']['value']);
            $oTInstance->Name = $row['fields']['vName']['value'];
            try {
              if ($row['isDeleted'] === true || $row['isDeleted'] === 'true') {
                $nTrnCount++;
                $oTInstance->delete();
              } else {
                $nTrnCount++;
                $oTInstance->save($oUser->Id);
              }
            } catch (Exception $exc) {
              $bIsAllOk = false;
              $oRest->setMessage($exc->getMessage());
            }
          }
          if ($nTrnCount == 0) {
            $bIsAllOk = false;
          }
        }
      } else {
        $bIsAllOk = false;
      }
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
    try {
      if ($bIsAllOk) {
        ph_CommitTransaction();
        $oRest->setRowData(array(
          'Status' => true,
          'Message' => getLabel('Done'),
          'Id' => $nSavedId
        ));
      } else {
        ph_RollbackTransaction();
      }
    } catch (Exception $exc) {
      $vMessage = $exc->getMessage();
    }
  }
}
