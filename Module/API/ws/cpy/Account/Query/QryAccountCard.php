<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $aFilters = ph_Get_Post('Filters');
  $aOptions = ph_Get_Post('Options');

  $nAccId = $aFilters["AccId"];
  $nOptn = 0;
  if (is_array($aOptions) && isset($aOptions["Open"])) {
    $nOptn = $aOptions["Open"];
  }

  $aConditionFields = array(
      'CostName' => array(
          'Name' => '`cost_num`',
          'Values' => 1,
          'Cond' => '(`cost_num` LIKE "%COND_VALUE%" OR `cost_name` LIKE "%COND_VALUE%")'
      ),
      'MstNum' => array(
          'Name' => '`mst_num`',
          'Values' => 2,
          'Cond' => '`mst_num` BETWEEN "COND_VALUE1" AND "COND_VALUE2"'
      ),
      'MstRem' => array(
          'Name' => '`mst_rem`',
          'Values' => 1,
          'Cond' => '`mst_rem` LIKE "%COND_VALUE%" '
      ),
      'TrnRem' => array(
          'Name' => '`trn_rem`',
          'Values' => 1,
          'Cond' => '`trn_rem` LIKE "%COND_VALUE%" '
      ),
      'CurnId' => array(
          'Name' => '`curn_id`',
          'Values' => 1,
          'Cond' => '`curn_id`= "COND_VALUE" '
      ),
  );

  $vWhere = '`acc_id`="' . $aFilters["AccId"] . '"';
  $vWhere .= ' AND `mst_date` BETWEEN STR_TO_DATE("' . $aFilters["MstDate"]['Value1'] . '", "%Y-%m-%d") AND STR_TO_DATE("' . $aFilters["MstDate"]['Value2'] . '", "%Y-%m-%d")';
  $vAnd = ' AND ';
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

  $vOrder = '`acc_num`,`mst_date`,`mst_num`,`trn_id`';
  $nPages = 0;
  $nCount = cAccVTrn::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }

  $aList = cAccVTrn::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  $nBlnc = 0;

  $nOBlnc = 0;
  if ($nOptn == 1) {
    $nOBlnc = floatval(ph_GetDBValue('sum(trn_deb)-sum(trn_crd)', 'acc_vtrn', 'acc_id ="' . $nAccId . '" AND `mst_date`< STR_TO_DATE("' . $aFilters["MstDate"]['Value1'] . '", "%Y-%m-%d")'));
  }
  $nTDeb = 0;
  $nTCrd = 0;
  $nTDebc = 0;
  $nTCrdc = 0;
  if ($nOptn == 1) {
    $aData[$nIdx] = array(
        'Id' => 0,
        'nDeb' => '',
        'nCrd' => '',
        'nBlnc' => number_format($nOBlnc, 2, ',', '.'),
        'MstDate' => '',
        'MstNum' => '',
        'vCurnCode' => '',
        'nCurnRate' => '',
        'nDebC' => '',
        'nCrdC' => '',
        'CostName' => '',
        'MstRem' => '',
        'TrnRem' => '',
    );
    $nIdx++;
    $nBlnc += $nOBlnc;
  }

  foreach ($aList as $element) {
    $nBlnc += floatval($element->TrnDeb) - floatval($element->TrnCrd);
    $nTDeb += $element->TrnDeb;
    $nTCrd += $element->TrnCrd;
    $nTDebc += $element->TrnDebc;
    $nTCrdc += $element->TrnCrdc;

    $aData[$nIdx] = array(
        'Id' => $element->TrnId,
        'nDeb' => number_format($element->TrnDeb, 2, ',', '.'),
        'nCrd' => number_format($element->TrnCrd, 2, ',', '.'),
        'nBlnc' => number_format($nBlnc, 2, ',', '.'),
        'MstDate' => $element->MstDate,
        'MstNum' => $element->MstNum,
        'vCurnCode' => $element->CurnCode,
        'nCurnRate' => number_format($element->CurnRate, 3, ',', '.'),
        'nDebC' => number_format($element->TrnDebc, 2, ',', '.'),
        'nCrdC' => number_format($element->TrnCrdc, 2, ',', '.'),
        'CostName' => $element->CostName,
        'MstRem' => $element->MstRem,
        'TrnRem' => $element->TrnRem,
    );
    $nIdx++;
  }
  if ($nIdx > 0) {
    $aData[$nIdx] = array(
        'Id' => 0,
        'nDeb' => '',
        'nCrd' => '',
        'nBlnc' => '',
        'MstDate' => '',
        'MstNum' => '',
        'vCurnCode' => '',
        'nCurnRate' => '',
        'nDebC' => '',
        'nCrdC' => '',
        'CostName' => '',
        'MstRem' => '',
        'TrnRem' => '',
    );
    $nIdx++;

    $aData[$nIdx] = array(
        'Id' => 0,
        'nDeb' => number_format($nTDeb, 2, ',', '.'),
        'nCrd' => number_format($nTCrd, 2, ',', '.'),
        'nBlnc' => number_format($nOBlnc + $nTDeb - $nTCrd, 2, ',', '.'),
        'MstDate' => '',
        'MstNum' => '',
        'vCurnCode' => '',
        'nCurnRate' => '',
        'nDebC' => number_format($nTDebc, 2, ',', '.'),
        'nCrdC' => number_format($nTCrdc, 2, ',', '.'),
        'CostName' => '',
        'MstRem' => '',
        'TrnRem' => '',
    );
  }
  $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aData
  ));
}
