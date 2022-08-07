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
    'nCatId' => array(
      'Name' => '`cat_id`',
      'Cond' => '`cat_id`="COND_VALUE"'
    ),
    'vCode' => array(
      'Name' => '`code`',
      'Cond' => '`code` LIKE "%COND_VALUE%"'
    ),
    'vName' => array(
      'Name' => '`name`',
      'Cond' => '`name` LIKE "%COND_VALUE%"'
    ),
    'nPrice' => array(
      'Name' => '`price`',
      'Cond' => '`price`="COND_VALUE"'
    ),
    'nVatId' => array(
      'Name' => '`vat_id`',
      'Cond' => '`vat_id`="COND_VALUE"'
    ),
    'nVat' => array(
      'Name' => '`vat`',
      'Cond' => '`vat`="COND_VALUE"'
    ),
    'vCatName' => array(
      'Name' => '`cat_id`',
      'Cond' => '`cat_id` IN (SELECT `id` FROM `clnc_procedure_category` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vVatName' => array(
      'Name' => '`vat_id`',
      'Cond' => '`vat_id` IN (SELECT `id` FROM `phs_cod_vat` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cClncProcedure::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncProcedure::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nCatId' => $element->CatId,
      'vCode' => $element->Code,
      'vName' => $element->Name,
      'nPrice' => $element->Price,
      'nVatId' => $element->VatId,
      'nVat' => $element->Vat,
      'vCatName' => $element->oCat->Name,
      'vVatName' => $element->oVat->Name,
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
