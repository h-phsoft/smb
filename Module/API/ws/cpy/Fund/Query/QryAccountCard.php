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
      'BoxId' => array(
          'Name' => '`box_id`',
          'Values' => 1,
          'Cond' => '`box_id`= "COND_VALUE" '
      ),
      'CostName' => array(
          'Name' => '`cost_num`',
          'Values' => 1,
          'Cond' => '(`cost_num` LIKE "%COND_VALUE%" OR `cost_name` LIKE "%COND_VALUE%")'
      ),
      'Rem' => array(
          'Name' => '`rem`',
          'Values' => 1,
          'Cond' => '`rem` LIKE "%COND_VALUE%" '
      ),
      'CurnId' => array(
          'Name' => '`curn_id`',
          'Values' => 1,
          'Cond' => '`curn_id`="COND_VALUE" '
      ),
  );

  $vWhere = '`acc_id`="' . $aFilters["AccId"] . '"';
  $vWhere .= ' AND `date` BETWEEN STR_TO_DATE("' . $aFilters["Date"]['Value1'] . '", "%Y-%m-%d") AND STR_TO_DATE("' . $aFilters["Date"]['Value2'] . '", "%Y-%m-%d")';
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

  $vOrder = '`acc_num`,`date`,`id`';
  $nPages = 0;
  $nCount = cFundVdiary::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }

  $aList = cFundVdiary::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  $nBlnc = 0;

  $nOBlnc = 0;
  if ($nOptn == 1) {
    $nOBlnc = floatval(ph_GetDBValue('sum(cdeb)-sum(ccrd)', 'fund_vdiary', 'acc_id ="' . $nAccId . '" AND `date`< STR_TO_DATE("' . $aFilters["Date"]['Value1'] . '", "%Y-%m-%d")'));
  }
  $nTDeb = 0;
  $nTCrd = 0;
  if ($nOptn == 1) {
    $aData[$nIdx] = array(
        'Id' => 0,
        'nDeb' => '',
        'nCrd' => '',
        'nBlnc' => number_format($nOBlnc, 2, ',', '.'),
        'Date' => '',
        'CurnCode' => '',
        'BoxName' => '',
        'CostName' => '',
        'Rem' => ''
    );
    $nIdx++;
    $nBlnc += $nOBlnc;
  }

  foreach ($aList as $element) {
    $nBlnc += floatval($element->Cdeb) - floatval($element->Ccrd);
    $nTDeb += $element->Cdeb;
    $nTCrd += $element->Ccrd;
    $aData[$nIdx] = array(
        'Id' => $element->Id,
        'nDeb' => $element->Cdeb,
        'nCrd' => $element->Ccrd,
        'nBlnc' => $nBlnc,
        'Date' => $element->Date,
        'CurnCode' => $element->CurnCode,
        'BoxName' => $element->BoxName,
        'CostName' => $element->CostName,
        'Rem' => $element->Rem
    );
    $nIdx++;
  }
  /*
    if ($nIdx > 0) {
    $aData[$nIdx] = array(
    'Id' => 0,
    'nDeb' => '',
    'nCrd' => '',
    'nBlnc' => '',
    'Date' => '',
    'CurnCode' => '',
    'BoxName' => '',
    'CostName' => '',
    'Rem' => ''
    );
    $nIdx++;

    $aData[$nIdx] = array(
    'Id' => 0,
    'nDeb' => number_format($nTDeb, 2, ',', '.'),
    'nCrd' => number_format($nTCrd, 2, ',', '.'),
    'nBlnc' => number_format($nOBlnc + $nTDeb - $nTCrd, 2, ',', '.'),
    'Date' => '',
    'CurnCode' => '',
    'BoxName' => '',
    'CostName' => '',
    'Rem' => ''
    );
    }
   */
  $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aData,
      'Where' => $vWhere
  ));
}
