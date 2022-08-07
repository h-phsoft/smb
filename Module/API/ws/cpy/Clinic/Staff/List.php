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
    'nTypeId' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id`="COND_VALUE"'
    ),
    'nGrpId' => array(
      'Name' => '`grp_id`',
      'Cond' => '`grp_id`="COND_VALUE"'
    ),
    'nStatusId' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id`="COND_VALUE"'
    ),
    'nGenderId' => array(
      'Name' => '`gender_id`',
      'Cond' => '`gender_id`="COND_VALUE"'
    ),
    'nSpecialId' => array(
      'Name' => '`special_id`',
      'Cond' => '`special_id`="COND_VALUE"'
    ),
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'vUsername' => array(
      'Name' => '`username`',
      'Cond' => '`username` LIKE "%COND_VALUE%"'
    ),
    'vPassword' => array(
      'Name' => '`password`',
      'Cond' => '`password` LIKE "%COND_VALUE%"'
    ),
    'vRem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
    ),
    'vImage' => array(
      'Name' => '`image`',
      'Cond' => '`image` LIKE "%COND_VALUE%"'
    ),
    'vGenderName' => array(
      'Name' => '`gender_id`',
      'Cond' => '`gender_id` IN (SELECT `id` FROM `phs_cod_gender` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSpecialName' => array(
      'Name' => '`special_id`',
      'Cond' => '`special_id` IN (SELECT `id` FROM `clnc_special` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vStatusName' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id` IN (SELECT `id` FROM `phs_cod_status` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTypeName' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id` IN (SELECT `id` FROM `cpy_user_type` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cClncStaff::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncStaff::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nTypeId' => $element->TypeId,
      'nGrpId' => $element->GrpId,
      'nStatusId' => $element->StatusId,
      'nGenderId' => $element->GenderId,
      'nSpecialId' => $element->SpecialId,
      'vName' => $element->Name,
      'vUsername' => $element->Username,
      'vPassword' => $element->Password,
      'vRem' => $element->Rem,
      // 'vImage' => $element->Image,
      'vGenderName' => $element->oGender->Name,
      'vSpecialName' => $element->oSpecial->Name,
      'vStatusName' => $element->oStatus->Name,
      'vTypeName' => $element->oType->Name,
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
