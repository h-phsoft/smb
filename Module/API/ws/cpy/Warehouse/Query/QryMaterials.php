<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $aFilters = ph_Get_Post('Filters');
  $aOptions = ph_Get_Post('Options');
  $aDisplay = ph_Get_Post('Display');

  $aConditionFields = array(
    'MstStore' => array(
      'Name' => '`stor_id`',
      'Values' => 1,
      'Cond' => 'stor_id="COND_VALUE"'
    ),
    'ItemName' => array(
      'Name' => '`item_num`',
      'Values' => 1,
      'Cond' => 'CONCAT(`item_num`, " - ", `item_name`) LIKE "%COND_VALUE%"'
    ),
    'MstDate' => array(
      'Name' => '`mst_date`',
      'Values' => 1,
      'Cond' => 'mst_date<="COND_VALUE"'
    ),
    'ItemStatus' => array(
      'Name' => '`stor_id`',
      'Values' => 1,
      'Cond' => 'stor_id="COND_VALUE"'
    ),
    'ItemUnit' => array(
      'Name' => '`unit_id`',
      'Values' => 1,
      'Cond' => 'unit_id="COND_VALUE"'
    ),
    'ItemSpc1' => array(
      'Name' => '`spc1_id`',
      'Values' => 1,
      'Cond' => 'spc1_id="COND_VALUE"'
    ),
    'ItemSpc2' => array(
      'Name' => '`spc2_id`',
      'Values' => 1,
      'Cond' => 'spc2_id="COND_VALUE"'
    ),
    'ItemSpc3' => array(
      'Name' => '`spc3_id`',
      'Values' => 1,
      'Cond' => 'spc3_id="COND_VALUE"'
    ),
    'ItemSpc4' => array(
      'Name' => '`spc4_id`',
      'Values' => 1,
      'Cond' => 'spc4_id="COND_VALUE"'
    ),
    'ItemSpc5' => array(
      'Name' => '`spc5_id`',
      'Values' => 1,
      'Cond' => 'spc5_id="COND_VALUE"'
    ),
    'SItemLoc1' => array(
      'Name' => '`loc1_id`',
      'Values' => 1,
      'Cond' => 'loc1_id="COND_VALUE"'
    ),
    'SItemLoc2' => array(
      'Name' => '`loc2_id`',
      'Values' => 1,
      'Cond' => 'loc2_id="COND_VALUE"'
    ),
    'SItemLoc3' => array(
      'Name' => '`loc3_id`',
      'Values' => 1,
      'Cond' => 'loc3_id="COND_VALUE"'
    ),
  );

  $vWhere = '';
  $vAnd = '';
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

  $vOrder = 'stor_num, item_num';

  $nPages = 0;
  $nCount = cStrVstritem::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrVstritem::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Warehouse' => $element->StorNum . ' - ' . $element->StorName,
      'Item' => $element->ItemNum . ' - ' . $element->ItemName,
      'StatusName' => $element->ItemStatusName,
      'UnitName' => $element->ItemUnitName,
      'CatName' => getLabel($element->CatName),
      'TypeName' => getLabel($element->TypeName),
      'UnitName' => $element->UnitName,
      'Spc1Name' => $element->Spec1Name,
      'Spc2Name' => $element->Spec2Name,
      'Spc3Name' => $element->Spec3Name,
      'Spc4Name' => $element->Spec4Name,
      'Spc5Name' => $element->Spec5Name,
      'Qnt' => $element->Qnt,
      'Amt' => $element->Amt
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