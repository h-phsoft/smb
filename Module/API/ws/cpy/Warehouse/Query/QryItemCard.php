<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $aFilters = ph_Get_Post('Filters');
  $aOptions = ph_Get_Post('Options');

  $nItemId = $aFilters["ItemId"];
  $nOptn = 0;
  if (is_array($aOptions) && isset($aOptions["Open"])) {
    $nOptn = $aOptions["Open"];
  }

  $aConditionFields = array(
      'AccName' => array(
          'Name' => '`acc_num`',
          'Values' => 1,
          'Cond' => '(`acc_num` LIKE "%COND_VALUE%" OR `acc_name` LIKE "%COND_VALUE%")'
      ),
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
  );

  $vWhere = '`item_id`="' . $nItemId . '"';
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

  $vOrder = '`item_num`,`mst_date`,`mst_num`,`trn_id`';
  $nPages = 0;
  $nCount = cStrVdocs::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }

  $aList = cStrVdocs::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  $nBlnc = 0;

  $nOBlnc = 0;
  if ($nOptn == 1) {
    //$nOBlnc = ph_GetDBValue('sum(trn_deb)-sum(trn_crd)', 'acc_vtrn', 'acc_id ="' . $nAccId . '" AND `mst_date`< STR_TO_DATE("' . $aFilters["MstDate"]['Value1'] . '", "%Y-%m-%d")');
  }
  $nTDeb = 0;
  $nTCrd = 0;
  $nTDebc = 0;
  $nTCrdc = 0;
  if ($nOptn == 1) {
    $aData[$nIdx] = array(
        'Id' => 0,
        'MstDate' => '',
        'MstNum' => '',
        'nInQnt' => '',
        'nOuQnt' => '',
        'nQBlnc' => number_format($nOBlnc, 2, ',', '.'),
        'vCurnCode' => '',
        'nCurnRate' => '',
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
        'Id' => $element->Id,
        'MstDate' => $element->MstDate,
        'MstNum' => $element->MstNum,
        'nInQnt' => number_format($element->TrnQnt, 2, ',', '.'),
        'nOuQnt' => number_format($element->TrnQnt, 2, ',', '.'),
        'nQBlnc' => number_format($nBlnc, 2, ',', '.'),
        'vCurnCode' => $element->CurnCode,
        'nCurnRate' => number_format($element->CurnRate, 3, ',', '.'),
        'CostName' => $element->CostName,
        'MstRem' => $element->MstRem,
        'TrnRem' => $element->TrnRem,
    );
    $nIdx++;
  }
  if ($nIdx > 0) {
    $aData[$nIdx] = array(
        'Id' => 0,
        'MstDate' => '',
        'MstNum' => '',
        'nInQnt' => '',
        'nOuQnt' => '',
        'nQBlnc' => '',
        'vCurnCode' => '',
        'nCurnRate' => '',
        'CostName' => '',
        'MstRem' => '',
        'TrnRem' => '',
    );
    $nIdx++;

    $aData[$nIdx] = array(
        'Id' => 0,
        'MstDate' => '',
        'MstNum' => '',
        'nInQnt' => number_format($nTDeb, 2, ',', '.'),
        'nOuQnt' => number_format($nTCrd, 2, ',', '.'),
        'nQBlnc' => number_format($nOBlnc + $nTDeb - $nTCrd, 2, ',', '.'),
        'vCurnCode' => '',
        'nCurnRate' => '',
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
