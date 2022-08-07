<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');

  $aFields = array(
    'Id' => array(
      'Name' => '`id`',
      'Cond' => '`id`="COND_VALUE"'
    ),
    'Num' => array(
      'Name' => '`num`',
      'Cond' => '`num` LIKE "%COND_VALUE%"'
    ),
    'Name' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'TypeName' => array(
      'Name' => '`type_name`',
      'Cond' => '`type_id` IN (SELECT `id` FROM `phs_cod_str_item_type` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'UnitName' => array(
      'Name' => '`unit_name`',
      'Cond' => '`unit_id` IN (SELECT `id` FROM `cpy_cod_unit` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'StatusName' => array(
      'Name' => '`status_name`',
      'Cond' => '`status_id` IN (SELECT `id` FROM `phs_cod_status` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'Spc1Name' => array(
      'Name' => '`spc1_name`',
      'Cond' => '`spc1_id` IN (SELECT `id` FROM `str_cod_spc1` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'Spc2Name' => array(
      'Name' => '`spc2_name`',
      'Cond' => '`spc2_id` IN (SELECT `id` FROM `str_cod_spc2` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'Spc3Name' => array(
      'Name' => '`spc3_name`',
      'Cond' => '`spc3_id` IN (SELECT `id` FROM `str_cod_spc3` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'Spc4Name' => array(
      'Name' => '`spc4_name`',
      'Cond' => '`spc4_id` IN (SELECT `id` FROM `str_cod_spc4` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'Spc5Name' => array(
      'Name' => '`spc5_name`',
      'Cond' => '`spc5_id` IN (SELECT `id` FROM `str_cod_spc5` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'CCost' => array(
      'Name' => '`ccost`',
      'Cond' => '`ccost`="COND_VALUE"'
    ),
    'nNPrice' => array(
      'Name' => '`nprice`',
      'Cond' => '`nprice`="COND_VALUE"'
    )
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
  $nCount = cStrItem::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrItem::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Num' => $element->Num,
      'Name' => $element->Name,
      'PartNum' => $element->PartNum,
      'Box' => $element->Box,
      'CCost' => $element->CCost,
      'nNPrice' => $element->nPrice,
      'nDPrice' => $element->dPrice,
      'nMPrice' => $element->mPrice,
      'nWPrice' => $element->wPrice,
      'nHPrice' => $element->hPrice,
      'nRPrice' => $element->rPrice,
      'nSPrice' => $element->sPrice,
      'Desc' => $element->Desc,
      'Rem' => $element->Rem,
      'Status' => $element->StatusId,
      'StatusName' => getLabel($element->StatusName),
      'Cat' => $element->CatId,
      'CatName' => getLabel($element->CatName),
      'Type' => $element->TypeId,
      'TypeName' => getLabel($element->TypeName),
      'Unit' => $element->UnitId,
      'UnitName' => $element->UnitName,
      'Spc1' => $element->Spec1Id,
      'Spc1Name' => $element->Spec1Name,
      'Spc2' => $element->Spec2Id,
      'Spc2Name' => $element->Spec2Name,
      'Spc3' => $element->Spec3Id,
      'Spc3Name' => $element->Spec3Name,
      'Spc4' => $element->Spec4Id,
      'Spc4Name' => $element->Spec4Name,
      'Spc5' => $element->Spec5Id,
      'Spc5Name' => $element->Spec5Name,
      'Image' => $vMediaCopyRootPath . 'item/' . $element->Image
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