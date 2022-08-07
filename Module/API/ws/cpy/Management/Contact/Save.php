<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if (($nId == 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Insert) ||
    ($nId > 0 && $oUser->oGrp->getPermission(ph_Get_Post('progId'))->Update)) {
    $oInstance = cMngCont::getInstance($nId);
    $oInstance->Num = ph_Get_Post('nNum');
    $oInstance->Name = ph_Get_Post('vName');
    $oInstance->Title = ph_Get_Post('vTitle');
    $oInstance->Legal = ph_Get_Post('vLegal');
    $oInstance->Owner = ph_Get_Post('vOwner');
    $oInstance->Person = ph_Get_Post('vPerson');
    $oInstance->Nlmt = ph_Get_Post('nNlmt');
    $oInstance->Dlmt = ph_Get_Post('nDlmt');
    $oInstance->StatusId = ph_Get_Post('nStatusId');
    $oInstance->TypeId = ph_Get_Post('nTypeId');
    $oInstance->NatId = ph_Get_Post('nNatId');
    $oInstance->Class1Id = ph_Get_Post('nClass1Id');
    $oInstance->Class2Id = ph_Get_Post('nClass2Id');
    $oInstance->Class3Id = ph_Get_Post('nClass3Id');
    $oInstance->Class4Id = ph_Get_Post('nClass4Id');
    $oInstance->Class5Id = ph_Get_Post('nClass5Id');
    $oInstance->Phone = ph_Get_Post('vPhone');
    $oInstance->Mobile = ph_Get_Post('vMobile');
    $oInstance->Email = ph_Get_Post('vEmail');
    $oInstance->Address = ph_Get_Post('vAddress');
    $bIsAllOk = true;
    try {
      $oRest->setMessage(getLabel('Master Not Saved'));
      $nSavedId = $oInstance->save($oUser->Id);
      if ($nSavedId > 0) {
        $aRows = ph_Get_Post('aRows');
        $oRest->setMessage(getLabel('No Details'));
        if (is_array($aRows) && count($aRows) > 0) {
          $nTrnCount = 0;
          for ($ii = 0; $ii < count($aRows); $ii++) {
            $row = $aRows[$ii];
            $oTInstance = cMngContCont::getInstance(intval($row['fields']['nId']['value']));
            try {
              if ($row['isDeleted'] === true || $row['isDeleted'] === 'true') {
                $nTrnCount++;
                $oTInstance->delete();
              } else {
                $nTrnCount++;
                $oTInstance->ContId = $nSavedId;
                $oTInstance->Name = $row['fields']['vName']['value'];
                $oTInstance->Position = $row['fields']['vPosition']['value'];
                $oTInstance->Mobile = $row['fields']['vMobile']['value'];
                $oTInstance->Phone = $row['fields']['vPhone']['value'];
                $oTInstance->Email = $row['fields']['vEmail']['value'];
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
