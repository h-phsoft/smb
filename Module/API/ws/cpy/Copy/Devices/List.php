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
    'vGuid' => array(
      'Name' => '`guid`',
      'Cond' => '`guid` LIKE "%COND_VALUE%"'
    ),
    'nStatusId' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id`="COND_VALUE"'
    ),
    'nShour' => array(
      'Name' => '`shour`',
      'Cond' => '`shour`="COND_VALUE"'
    ),
    'nSminute' => array(
      'Name' => '`sminute`',
      'Cond' => '`sminute`="COND_VALUE"'
    ),
    'nEhour' => array(
      'Name' => '`ehour`',
      'Cond' => '`ehour`="COND_VALUE"'
    ),
    'nEminute' => array(
      'Name' => '`eminute`',
      'Cond' => '`eminute`="COND_VALUE"'
    ),
    'nDay1' => array(
      'Name' => '`day1`',
      'Cond' => '`day1`="COND_VALUE"'
    ),
    'nDay2' => array(
      'Name' => '`day2`',
      'Cond' => '`day2`="COND_VALUE"'
    ),
    'nDay3' => array(
      'Name' => '`day3`',
      'Cond' => '`day3`="COND_VALUE"'
    ),
    'nDay4' => array(
      'Name' => '`day4`',
      'Cond' => '`day4`="COND_VALUE"'
    ),
    'nDay5' => array(
      'Name' => '`day5`',
      'Cond' => '`day5`="COND_VALUE"'
    ),
    'nDay6' => array(
      'Name' => '`day6`',
      'Cond' => '`day6`="COND_VALUE"'
    ),
    'nDay7' => array(
      'Name' => '`day7`',
      'Cond' => '`day7`="COND_VALUE"'
    ),
    'vPlatform' => array(
      'Name' => '`platform`',
      'Cond' => '`platform` LIKE "%COND_VALUE%"'
    ),
    'nLanguage' => array(
      'Name' => '`Language`',
      'Cond' => '`Language`="COND_VALUE"'
    ),
    'dAddedAt' => array(
      'Name' => '`added_at`',
      'Cond' => '`added_at`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'vStatusName' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id` IN (SELECT `id` FROM `phs_cod_status` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cCpyDevice::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cCpyDevice::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'vName' => $element->Name,
      'vGuid' => $element->Guid,
      'nStatusId' => $element->StatusId,
      'nShour' => $element->SHour,
      'nSminute' => $element->SMinute,
      'nEhour' => $element->EHour,
      'nEminute' => $element->EMinute,
      'nDay1' => $element->Day1,
      'nDay2' => $element->Day2,
      'nDay3' => $element->Day3,
      'nDay4' => $element->Day4,
      'nDay5' => $element->Day5,
      'nDay6' => $element->Day6,
      'nDay7' => $element->Day7,
      'dAddedAt' => ph_DateFormat($element->AddedAt, 'Y-m-d h:s'),
      'vStatusName' => $element->oStatus->Name,
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
