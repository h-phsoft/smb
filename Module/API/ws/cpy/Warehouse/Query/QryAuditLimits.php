<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');

  $filter = array(
    array('field' => 'Warehouse',
      'value' => ph_Get_Post("MstStore")
    ),
    array('field' => 'Item',
      'value' => ph_Get_Post("ItemName")
    ),
    array('field' => 'StatusName',
      'value' => ph_Get_Post("ItemStatus")
    ),
    array('field' => 'UnitName',
      'value' => ph_Get_Post("ItemUnit")
    ),
    array('field' => 'nItemSpc1',
      'value' => ph_Get_Post("ItemSpc1")
    ),
    array('field' => 'nItemSpc2',
      'value' => ph_Get_Post("ItemSpc2")
    ),
    array('field' => 'nItemSpc3',
      'value' => ph_Get_Post("ItemSpc3")
    ),
    array('field' => 'Loc1Name',
      'value' => ph_Get_Post("SItemLoc1")
    ),
    array('field' => 'Loc2Name',
      'value' => ph_Get_Post("SItemLoc2")
    ),
    array('field' => 'Loc3Name',
      'value' => ph_Get_Post("SItemLoc3")
    ),
  );
  $dDate = ph_Get_Post("MstDate");
  $nOptnLimit = ph_Get_Post("optnLimit");
  $nOptnMode = ph_Get_Post("optnMode");

  $aFields = array(
    'Warehouse' => array(
      'Name' => '`stor_id`',
      'Cond' => '`stor_id`="COND_VALUE"'
    ),
    'Item' => array(
      'Name' => '`item_num`',
      'Cond' => '(`item_num` LIKE "%COND_VALUE%" OR `item_name` LIKE "%COND_VALUE%")'
    ),
    'StatusName' => array(
      'Name' => '`item_status_id`',
      'Cond' => '`item_status_id` = "COND_VALUE"'
    ),
    'UnitName' => array(
      'Name' => '`item_unit_id`',
      'Cond' => '`item_unit_id` = "COND_VALUE"'
    ),
    'nItemSpc1' => array(
      'Name' => '`item_spc1_id`',
      'Cond' => '`item_spc1_id` = "COND_VALUE"'
    ),
    'nItemSpc2' => array(
      'Name' => '`item_spc2_id`',
      'Cond' => '`item_spc2_id` = "COND_VALUE"'
    ),
    'nItemSpc3' => array(
      'Name' => '`item_spc3_id`',
      'Cond' => '`item_spc3_id` = "COND_VALUE"'
    ),
    'Loc1Name' => array(
      'Name' => '`loc1_id`',
      'Cond' => '`loc1_id` = "COND_VALUE"'
    ),
    'Loc2Name' => array(
      'Name' => '`loc2_id`',
      'Cond' => '`loc2_id` = "COND_VALUE"'
    ),
    'Loc3Name' => array(
      'Name' => '`loc3_id`',
      'Cond' => '`loc3_id` = "COND_VALUE"'
    ),
    'Qnt1' => array(
      'Name' => '`cqnt1`',
      'Cond' => '`cqnt1`="COND_VALUE"'
    ),
    'Qnt2' => array(
      'Name' => '`cqnt2`',
      'Cond' => '`cqnt2`="COND_VALUE"'
    ),
    'Qnt3' => array(
      'Name' => '`cqnt3`',
      'Cond' => '`cqnt3`="COND_VALUE"'
    )
  );

  $vWhere = '';
  $vAnd = '';
  /*
    if ($dDate != '') {
    $vWhere = '`date`=STR_TO_DATE("' . $dDate . '", "%Y-%m-%d")';
    $vAnd = ' AND ';
    }
   */
  $vQnt = 'cqnt3';
  switch (intval($nOptnMode)) {
    case 1:
      $vQnt = 'cqnt1';
      break;
    case 2:
      $vQnt = 'cqnt2';
      break;
    case 3:
      $vQnt = 'cqnt3';
      break;
    default:
      $vQnt = 'cqnt3';
      break;
  }
  switch (intval($nOptnLimit)) {
    case 1:
      $vWhere .= $vAnd . $vQnt . '<minqnt';
      $vAnd = ' AND ';
      break;
    case 2:
      $vWhere .= $vAnd . $vQnt . '<reqqnt';
      $vAnd = ' AND ';
      break;
    case 3:
      $vWhere .= $vAnd . $vQnt . '>maxqnt';
      $vAnd = ' AND ';
      break;
    default:
      $vWhere .= $vAnd . $vQnt . '<reqqnt';
      $vAnd = ' AND ';
      break;
  }
  if (isset($filter) && is_array($filter)) {
    foreach ($filter as $field) {
      if ($field['value'] != -1 && $field['value'] != '') {
        if (isset($aFields[$field['field']])) {
          $vWhere .= $vAnd . str_replace('COND_VALUE', $field['value'], $aFields[$field['field']]['Cond']);
          $vAnd = ' AND ';
        }
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
  $nCount = cStrVStoreItem::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrVStoreItem::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $nQnt = $element->Qnt;
    switch (intval($nOptnLimit)) {
      case 1:
        $nLimit = $element->MinQnt;
        $nOverLimit = $element->MinQnt - $nQnt;
        break;
      case 2:
        $nLimit = $element->ReqQnt;
        $nOverLimit = $element->ReqQnt - $nQnt;
        break;
      case 3:
        $nLimit = $element->MaxQnt;
        $nOverLimit = $nQnt - $element->MaxQnt;
        break;
      default:
        $nLimit = $element->ReqQnt;
        $nOverLimit = $element->ReqQnt - $nQnt;
        break;
    }
    $aData[$nIdx] = array(
      'Id' => $element->Id,
      'Warehouse' => $element->StorNum . ' - ' . $element->StorName,
      'Item' => $element->ItemNum . ' - ' . $element->ItemName,
      'StatusName' => $element->ItemStatusName,
      'UnitName' => $element->ItemUnitName,
      'Loc1Name' => $element->Loc1Name,
      'Loc2Name' => $element->Loc2Name,
      'Loc3Name' => $element->Loc3Name,
      'Qnt1' => $element->Qnt1,
      'Qnt2' => $element->Qnt2,
      'Qnt3' => $element->Qnt3,
      'Qnt' => $nQnt,
      'Limit' => $nLimit,
      'OverLimit' => $nOverLimit
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
