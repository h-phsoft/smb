<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  $aFields = array(
    'nId' => array(
      'Name' => '`id`',
      'Cond' => '`id`="COND_VALUE"'
    ),
    'vCode' => array(
      'Name' => '`code`',
      'Cond' => '`code` LIKE "%COND_VALUE%"'
    ),
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'nCst' => array(
      'Name' => '`cst`',
      'Cond' => '`cst`="COND_VALUE"'
    ),
    'nCostId' => array(
      'Name' => '`cost_id`',
      'Cond' => '`cost_id` IN (SELECT `id` FROM `acc_cost` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'nAccCid' => array(
      'Name' => '`acc_cid`',
      'Cond' => '`acc_cid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'nAccRid' => array(
      'Name' => '`acc_rid`',
      'Cond' => '`acc_rid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'UnitName' => array(
      'Name' => '`unit_name`',
      'Cond' => '`unit_id` IN (SELECT `id` FROM `cpy_cod_unit` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vGrp' => array(
      'Name' => '`grp`',
      'Cond' => '`grp` LIKE "%COND_VALUE%"'
    ),
    'vRem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
    ),
  );
  $vWhere = 'id>0';
  $vAnd = ' AND ';
  if (isset($filter) && is_array($filter)) {
    foreach ($filter as $field) {
      if (isset($aFields[$field['field']])) {
        $vWhere .= $vAnd . str_replace('COND_VALUE', $field['value'], $aFields[$field['field']]['Cond']);
        $vAnd = ' AND ';
      }
    }
  }
  $vOrder = '';
  $vComma = '';
  if (isset($sorters) && is_array($sorters)) {
    foreach ($sorters as $field) {
      if (isset($aFields[$field['field']])) {
        $vOrder .= $vComma . $aFields[$field['field']]['Name'] . ' ' . strtoupper($field['dir']);
        $vComma = ', ';
      }
    }
  }
  $nPages = 0;
  $nCount = cMngService::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cMngService::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $vCostName = ph_GetDBValue('name', 'acc_cost', 'id="' . $element->CostId . '"');
    $vAccCName = ph_GetDBValue('name', 'acc_acc', 'id="' . $element->AccCid . '"');
    $vAccRName = ph_GetDBValue('name', 'acc_acc', 'id="' . $element->AccRid . '"');
    $vUnitName = ph_GetDBValue('name', 'cpy_cod_unit', 'id="' . $element->UnitId . '"');
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'vCode' => $element->Code,
      'vName' => $element->Name,
      'nCst' => $element->Cst,
      'nCostId' => $element->CostId,
      'vCostName' => $vCostName,
      'nAccCid' => $element->AccCid,
      'vAccCName' => $vAccCName,
      'nAccRid' => $element->AccRid,
      'vAccRName' => $vAccRName,
      'nUnitId' => $element->UnitId,
      'vUnitName' => $vUnitName,
      'vGrp' => $element->Grp,
      'vRem' => $element->Rem,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => array(
      'last_page' => $nPages,
      'data' => $aData
    )
  ));
}
