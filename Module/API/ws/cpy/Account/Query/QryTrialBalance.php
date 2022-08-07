<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $aFilters = ph_Get_Post('Filters');
  $aOptions = ph_Get_Post('Options');
  $aDisplay = ph_Get_Post('Display');

  $aConditionFields = array(
    'AccName' => array(
      'Name' => '`acc_num`',
      'Values' => 1,
      'Cond' => 'CONCAT(`acc_num`, " - ", `acc_name`) LIKE "%COND_VALUE%"'
    ),
    'CostName' => array(
      'Name' => '`cost_num`',
      'Values' => 1,
      'Cond' => 'CONCAT(`cost_num`, " - ", `cost_name`) LIKE "%COND_VALUE%"'
    ),
    'MstNum' => array(
      'Name' => '`mst_num`',
      'Values' => 2,
      'Cond' => '`mst_num` BETWEEN "COND_VALUE1" AND "COND_VALUE2"'
    ),
  );

  $vWhere = '';
  $vAnd = '';
  if (isset($aFilters) && is_array($aFilters)) {
    foreach ($aFilters as $key => $value) {
      if (isset($aConditionFields[$key])) {
        if ($value != -1 && $value != '') {
          if (intval($aConditionFields[$key]['Values']) == 1) {
            $vWhere .= $vAnd . str_replace('COND_VALUE', $value, $aConditionFields[$key]['Cond']);
          } else {
            $vWhere .= $vAnd . str_replace('COND_VALUE2', $value['Value2'], str_replace('COND_VALUE1', $value['Value1'], $aConditionFields[$key]['Cond']));
          }
          $vAnd = ' AND ';
        }
      }
    }
  }
  $vOWhere = $vAnd . '`mst_date`<STR_TO_DATE("' . $aFilters["MstDate"]['Value1'] . '", "%Y-%m-%d")';
  $vTWhere = $vAnd . '`mst_date` BETWEEN STR_TO_DATE("' . $aFilters["MstDate"]['Value1'] . '", "%Y-%m-%d") AND STR_TO_DATE("' . $aFilters["MstDate"]['Value2'] . '", "%Y-%m-%d")';

  $vOrder = '`acc_num`';
  if (intval($aDisplay["Centers"]) == 1) {
    $vOrder .= ', `cost_num`';
  }

  $vSQL = 'SELECT `acc_id`, `acc_num`, `acc_name`';
  if (intval($aDisplay["Centers"]) == 1) {
    $vSQL .= ', `cost_num`, `cost_name`';
  }
  $vSQL .= ', SUM(odeb) AS ODeb, SUM(ocrd) AS OCrd, SUM(tdeb) AS TDeb, SUM(tcrd) AS TCrd';
  $vSQL .= ' FROM (';
  if (intval($aDisplay["Open"]) == 1) {
    $vSQL .= 'SELECT `acc_id`, `acc_num`, `acc_name`';
    if (intval($aDisplay["Centers"]) == 1) {
      $vSQL .= ', `cost_id`, `cost_num`, `cost_name`';
    }
    $vSQL .= ', SUM(trn_deb) AS odeb, SUM(trn_crd) AS ocrd, 0 AS tdeb, 0 AS tcrd';
    $vSQL .= ' FROM `acc_vtrn`';
    $vSQL .= ' WHERE ' . $vWhere . $vOWhere;
    $vSQL .= ' GROUP BY `acc_id`, `acc_num`, `acc_name`';
    if (intval($aDisplay["Centers"]) == 1) {
      $vSQL .= ', `cost_id`, `cost_num`, `cost_name`';
    }
    $vSQL .= ' UNION ALL ';
  }
  $vSQL .= 'SELECT `acc_id`, `acc_num`, `acc_name`';
  if (intval($aDisplay["Centers"]) == 1) {
    $vSQL .= ', `cost_id`, `cost_num`, `cost_name`';
  }
  $vSQL .= ', 0 AS odeb, 0 AS ocrd, SUM(trn_deb) AS tdeb, SUM(trn_crd) AS tcrd';
  $vSQL .= ' FROM `acc_vtrn`';
  $vSQL .= ' WHERE ' . $vWhere . $vTWhere;
  $vSQL .= ' GROUP BY `acc_id`, `acc_num`, `acc_name`';
  if (intval($aDisplay["Centers"]) == 1) {
    $vSQL .= ', `cost_id`, `cost_num`, `cost_name`';
  }
  $vSQL .= ') AS tt';
  $vSQL .= ' GROUP BY `acc_id`, `acc_num`, `acc_name`';
  if (intval($aDisplay["Centers"]) == 1) {
    $vSQL .= ', `cost_id`, `cost_num`, `cost_name`';
  }
  $vSQL .= ' ORDER BY ' . $vOrder;

  $aData = array();
  $nIdx = 0;
  $res = ph_Execute($vSQL);
  if ($res != '') {
    $nTotODeb = 0;
    $nTotOCrd = 0;
    $nTotTDeb = 0;
    $nTotTCrd = 0;
    $nTotBDeb = 0;
    $nTotBCrd = 0;
    while (!$res->EOF) {
      $aData[$nIdx] = array();
      $aData[$nIdx]['Id'] = $res->fields("acc_id");
      $nOBlnc = floatval($res->fields("ODeb")) - floatval($res->fields("OCrd"));
      $nODeb = 0;
      $nOCrd = 0;
      if ($nOBlnc >= 0) {
        $nODeb = $nOBlnc;
      } else {
        $nOCrd = abs($nOBlnc);
      }
      $nTDeb = floatval($res->fields("TDeb"));
      $nTCrd = floatval($res->fields("TCrd"));
      $nBlnc = $nODeb - $nOCrd + $nTDeb - $nTCrd;
      $nBDeb = 0;
      $nBCrd = 0;
      if ($nBlnc >= 0) {
        $nBDeb = $nBlnc;
      } else {
        $nBCrd = abs($nBlnc);
      }
      if (intval($aDisplay["Open"] == 1)) {
        $aData[$nIdx]['nODeb'] = number_format($nODeb, 2, '.', ',');
        $aData[$nIdx]['nOCrd'] = number_format($nOCrd, 2, '.', ',');
      }
      if (intval($aDisplay["Totals"] == 1)) {
        $aData[$nIdx]['nTDeb'] = number_format($nTDeb, 2, '.', ',');
        $aData[$nIdx]['nTCrd'] = number_format($nTCrd, 2, '.', ',');
      }
      if (intval($aDisplay["Balances"] == 1)) {
        $aData[$nIdx]['nBDeb'] = number_format($nBDeb, 2, '.', ',');
        $aData[$nIdx]['nBCrd'] = number_format($nBCrd, 2, '.', ',');
      }
      $aData[$nIdx]['vAccNum'] = $res->fields("acc_num");
      $aData[$nIdx]['vAccName'] = $res->fields("acc_name");
      if (intval($aDisplay["Centers"] == 1)) {
        $aData[$nIdx]['vCostNum'] = $res->fields("cost_num");
        $aData[$nIdx]['vCostName'] = $res->fields("cost_name");
      }
      //if (strlen($res->fields("acc_num")) == 1) {
      $nTotODeb += $nODeb;
      $nTotOCrd += $nOCrd;
      $nTotTDeb += $nTDeb;
      $nTotTCrd += $nTCrd;
      $nTotBDeb += $nBDeb;
      $nTotBCrd += $nBCrd;
      //}
      $nIdx++;
      $res->MoveNext();
    }
    $res->Close();
    //
    $aData[$nIdx] = array();
    $aData[$nIdx]['Id'] = '';
    if (intval($aDisplay["Open"] == 1)) {
      $aData[$nIdx]['nODeb'] = '';
      $aData[$nIdx]['nOCrd'] = '';
    }
    if (intval($aDisplay["Totals"] == 1)) {
      $aData[$nIdx]['nTDeb'] = '';
      $aData[$nIdx]['nTCrd'] = '';
    }
    if (intval($aDisplay["Balances"] == 1)) {
      $aData[$nIdx]['nBDeb'] = '';
      $aData[$nIdx]['nBCrd'] = '';
    }
    $aData[$nIdx]['vAccNum'] = '';
    $aData[$nIdx]['vAccName'] = '';
    if (intval($aDisplay["Centers"] == 1)) {
      $aData[$nIdx]['vCostNum'] = '';
      $aData[$nIdx]['vCostName'] = '';
    }
    $nIdx++;
    //
    $aData[$nIdx]['Id'] = '';
    if (intval($aDisplay["Open"] == 1)) {
      $aData[$nIdx]['nODeb'] = number_format($nTotODeb, 2, '.', ',');
      $aData[$nIdx]['nOCrd'] = number_format($nTotOCrd, 2, '.', ',');
    }
    if (intval($aDisplay["Totals"] == 1)) {
      $aData[$nIdx]['nTDeb'] = number_format($nTotTDeb, 2, '.', ',');
      $aData[$nIdx]['nTCrd'] = number_format($nTotTCrd, 2, '.', ',');
    }
    if (intval($aDisplay["Balances"] == 1)) {
      $aData[$nIdx]['nBDeb'] = number_format($nTotBDeb, 2, '.', ',');
      $aData[$nIdx]['nBCrd'] = number_format($nTotBCrd, 2, '.', ',');
    }
    $aData[$nIdx]['vAccNum'] = '';
    $aData[$nIdx]['vAccName'] = '';
    if (intval($aDisplay["Centers"] == 1)) {
      $aData[$nIdx]['vCostNum'] = '';
      $aData[$nIdx]['vCostName'] = '';
    }
    $nIdx++;
    //
    $aData[$nIdx]['Id'] = '';
    if (intval($aDisplay["Open"] == 1)) {
      $aData[$nIdx]['nODeb'] = number_format($nTotODeb - $nTotOCrd, 2, '.', ',');
      $aData[$nIdx]['nOCrd'] = '';
    }
    if (intval($aDisplay["Totals"] == 1)) {
      $aData[$nIdx]['nTDeb'] = number_format($nTotTDeb - $nTotTCrd, 2, '.', ',');
      $aData[$nIdx]['nTCrd'] = '';
    }
    if (intval($aDisplay["Balances"] == 1)) {
      $aData[$nIdx]['nBDeb'] = number_format($nTotBDeb - $nTotBCrd, 2, '.', ',');
      $aData[$nIdx]['nBCrd'] = '';
    }
    $aData[$nIdx]['vAccNum'] = '';
    $aData[$nIdx]['vAccName'] = '';
    if (intval($aDisplay["Centers"] == 1)) {
      $aData[$nIdx]['vCostNum'] = '';
      $aData[$nIdx]['vCostName'] = '';
    }
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}