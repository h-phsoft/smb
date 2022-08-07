<?php

if (isset($oRest)) {

  $nNewNum = '';
  $nAccId = ph_Get_Post("nId");
  $vAccNum = ph_Get_Post("vNum");
  $nAccType = ph_Get_Post("nType");
  if ($nAccId !== '') {
    if ($nAccType == 1) {
      $nPId = $nAccId;
    } else {
      $nPId = intval(ph_GetDBValue('pid', 'acc_cost', 'id="' . $nAccId . '"'));
    }
    $nNewMax = intval(ph_GetDBValue('max(num)', 'acc_cost', 'pid="' . $nPId . '"'));
    if ($nNewMax == 0) {
      $nNewNum = intval($vAccNum . '0001');
    } else {
      $nNewNum = $nNewMax + 1;
    }
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'NewNum' => $nNewNum
  ));
}