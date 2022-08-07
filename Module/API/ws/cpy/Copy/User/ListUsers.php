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
      'Cond' => '`num` LIKE "%COND_VALUE%"'
    ),
    'vLogon' => array(
      'Name' => '`logon`',
      'Cond' => '`logon` LIKE "%COND_VALUE%"'
    ),
    'vTypeName' => array(
      'Name' => '`grp_id`',
      'Cond' => '`grp_id` LIKE "%COND_VALUE%"'
    ),
    'vGenderName' => array(
      'Name' => '`gender_id`',
      'Cond' => '`gender_id`="COND_VALUE"'
    ),
    'vStatusName' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id`="COND_VALUE"'
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
  $nCount = cCpyUser::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cCpyUser::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'vName' => $element->Name,
      'vLogon' => $element->Logon,
      'nType' => $element->oGrp->Id,
      'vTypeName' => $element->oGrp->Name,
      'vImage' => $element->Image,
      'nGender' => $element->oGender->Id,
      'vGenderName' => $element->oGender->Name,
      'nStatus' => $element->oStatus->Id,
      'vStatusName' => $element->oStatus->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => array(
      'last_page' => $nPages,
      'data' => $aData
    )
  ));
}
