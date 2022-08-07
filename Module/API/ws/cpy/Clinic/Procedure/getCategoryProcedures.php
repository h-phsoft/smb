<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $nCount = 0;
  $nCurrentOffer = intval(cCpyPref::getPrefValue('Current-Offer'));
  if ($nCurrentOffer > 0) {
    $vSQL = 'SELECT count(*) AS nCnt'
            . ' FROM `clnc_offer`'
            . ' WHERE `id`="' . $nCurrentOffer . '"'
            . ' AND STR_TO_DATE("' . ph_GetCurrentDate() . '", "%d-%m-%Y") BETWEEN STR_TO_DATE(DATE_FORMAT(`sdate`, "%d-%m-%Y"), "%d-%m-%Y") AND STR_TO_DATE(DATE_FORMAT(`edate`, "%d-%m-%Y"), "%d-%m-%Y")';
    $res = ph_Execute($vSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $nCount = intval($res->fields("nCnt"));
      }
      $res->Close();
    }
  }
  if ($nCount > 0) {
    $aProcedure = cClncProcedure::getArrayWithOffer('`cat_id`="' . $nId . '"', $nCurrentOffer);
  } else {
    $aProcedure = cClncProcedure::getArray('`cat_id`="' . $nId . '"');
  }
  $aData = array();
  $nIdx = 0;
  foreach ($aProcedure as $procedure) {
    $aData[$nIdx] = array(
        'Id' => $procedure->Id,
        'Code' => $procedure->Code,
        'Name' => $procedure->Name,
        'Price' => $procedure->Price
    );
    $nIdx++;
  }
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aData
  );
  $oRest->setRowData($response);
}