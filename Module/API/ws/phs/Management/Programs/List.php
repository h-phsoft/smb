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
    'nProgId' => array(
      'Name' => '`prog_id`',
      'Cond' => '`prog_id`="COND_VALUE"'
    ),
    'nSysId' => array(
      'Name' => '`sys_id`',
      'Cond' => '`sys_id`="COND_VALUE"'
    ),
    'nGrpId' => array(
      'Name' => '`grp_id`',
      'Cond' => '`grp_id`="COND_VALUE"'
    ),
    'nStatusId' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id`="COND_VALUE"'
    ),
    'nTypeId' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id`="COND_VALUE"'
    ),
    'nOpen' => array(
      'Name' => '`open`',
      'Cond' => '`open`="COND_VALUE"'
    ),
    'nOrd' => array(
      'Name' => '`ord`',
      'Cond' => '`ord`="COND_VALUE"'
    ),
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'vIcon' => array(
      'Name' => '`icon`',
      'Cond' => '`icon` LIKE "%COND_VALUE%"'
    ),
    'vFile' => array(
      'Name' => '`file`',
      'Cond' => '`file` LIKE "%COND_VALUE%"'
    ),
    'vCss' => array(
      'Name' => '`css`',
      'Cond' => '`css` LIKE "%COND_VALUE%"'
    ),
    'vJs' => array(
      'Name' => '`js`',
      'Cond' => '`js` LIKE "%COND_VALUE%"'
    ),
    'vAttributes' => array(
      'Name' => '`attributes`',
      'Cond' => '`attributes` LIKE "%COND_VALUE%"'
    ),
    'vProgName' => array(
      'Name' => '`prog_id`',
      'Cond' => '`prog_id` IN (SELECT `id` FROM `phs_program` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vStatusName' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id` IN (SELECT `id` FROM `phs_cod_status` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSysName' => array(
      'Name' => '`sys_id`',
      'Cond' => '`sys_id` IN (SELECT `id` FROM `phs_system` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTypeName' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id` IN (SELECT `id` FROM `phs_program_type` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cPhsProgram::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cPhsProgram::getQArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nProgId' => $element->PId,
      'vProgName' => $element->PId . '-' . $element->vSystem . '-' . $element->PName,
      'nSysId' => $element->nSystem,
      'nGrp' => $element->GrpId,
      'nStatusId' => $element->nStatus,
      'nTypeId' => $element->nType,
      'nGrp' => $element->nGrp,
      'nOpen' => $element->Open,
      'nOrd' => $element->Order,
      'vName' => $element->Name,
      'vIcon' => $element->Icon,
      'vFile' => $element->File,
      'vCss' => $element->CSS,
      'vJs' => $element->JS,
      'vAttributes' => $element->Attributes,
      'vStatusName' => $element->vStatus,
      'vSysName' => $element->vSystem,
      'vTypeName' => $element->vType,
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
