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
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'nCapacity' => array(
      'Name' => '`capacity`',
      'Cond' => '`capacity`="COND_VALUE"'
    ),
    'nTime' => array(
      'Name' => '`time`',
      'Cond' => '`time`="COND_VALUE"'
    ),
    'nTbgId' => array(
      'Name' => '`tbg_id`',
      'Cond' => '`tbg_id`="COND_VALUE"'
    ),
    'nTfgId' => array(
      'Name' => '`tfg_id`',
      'Cond' => '`tfg_id`="COND_VALUE"'
    ),
    'nNfgId' => array(
      'Name' => '`nfg_id`',
      'Cond' => '`nfg_id`="COND_VALUE"'
    ),
    'nInsUser' => array(
      'Name' => '`ins_user`',
      'Cond' => '`ins_user`="COND_VALUE"'
    ),
    'dInsDate' => array(
      'Name' => '`ins_date`',
      'Cond' => '`ins_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'nUpdUser' => array(
      'Name' => '`upd_user`',
      'Cond' => '`upd_user`="COND_VALUE"'
    ),
    'dUpdDate' => array(
      'Name' => '`upd_date`',
      'Cond' => '`upd_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'vInsUserName' => array(
      'Name' => '`ins_user`',
      'Cond' => '`ins_user` IN (SELECT `id` FROM `cpy_user` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vNfgName' => array(
      'Name' => '`nfg_id`',
      'Cond' => '`nfg_id` IN (SELECT `id` FROM `phs_cod_color` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTbgName' => array(
      'Name' => '`tbg_id`',
      'Cond' => '`tbg_id` IN (SELECT `id` FROM `phs_cod_color` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTfgName' => array(
      'Name' => '`tfg_id`',
      'Cond' => '`tfg_id` IN (SELECT `id` FROM `phs_cod_color` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vUpdUserName' => array(
      'Name' => '`upd_user`',
      'Cond' => '`upd_user` IN (SELECT `id` FROM `cpy_user` WHERE `name` LIKE "%COND_VALUE%")'
    ),
  );
  $vWhere = '';
  $vAnd = '';
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
  $nCount = cClncAppType::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncAppType::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'vName' => $element->Name,
      'nCapacity' => $element->Capacity,
      'nTime' => $element->Time,
      'nTbgId' => $element->TbgId,
      'nTfgId' => $element->TfgId,
      'nNfgId' => $element->NfgId,
      'vNfgName' => $element->oNfg->Name,
      'vTbgName' => $element->oTbg->Name,
      'vTfgName' => $element->oTfg->Name,
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
