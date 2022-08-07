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
    'nStorId' => array(
      'Name' => '`stor_id`',
      'Cond' => '`stor_id`="COND_VALUE"'
    ),
    'nItemId' => array(
      'Name' => '`item_id`',
      'Cond' => '`item_id`="COND_VALUE"'
    ),
    'nTrntypeId' => array(
      'Name' => '`trntype_id`',
      'Cond' => '`trntype_id`="COND_VALUE"'
    ),
    'nCostId' => array(
      'Name' => '`cost_id`',
      'Cond' => '`cost_id`="COND_VALUE"'
    ),
    'nAccSid' => array(
      'Name' => '`acc_sid`',
      'Cond' => '`acc_sid`="COND_VALUE"'
    ),
    'nAccCid' => array(
      'Name' => '`acc_cid`',
      'Cond' => '`acc_cid`="COND_VALUE"'
    ),
    'nAccRid' => array(
      'Name' => '`acc_rid`',
      'Cond' => '`acc_rid`="COND_VALUE"'
    ),
    'nAccMid' => array(
      'Name' => '`acc_mid`',
      'Cond' => '`acc_mid`="COND_VALUE"'
    ),
    'nAccDid' => array(
      'Name' => '`acc_did`',
      'Cond' => '`acc_did`="COND_VALUE"'
    ),
    'vRem' => array(
      'Name' => '`rem`',
      'Cond' => '`rem` LIKE "%COND_VALUE%"'
    ),
    'vAccCName' => array(
      'Name' => '`acc_cid`',
      'Cond' => '`acc_cid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vAccDName' => array(
      'Name' => '`acc_did`',
      'Cond' => '`acc_did` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vAccMName' => array(
      'Name' => '`acc_mid`',
      'Cond' => '`acc_mid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vAccRName' => array(
      'Name' => '`acc_rid`',
      'Cond' => '`acc_rid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vAccSName' => array(
      'Name' => '`acc_sid`',
      'Cond' => '`acc_sid` IN (SELECT `id` FROM `acc_acc` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vCostName' => array(
      'Name' => '`cost_id`',
      'Cond' => '`cost_id` IN (SELECT `id` FROM `acc_cost` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vItemName' => array(
      'Name' => '`item_id`',
      'Cond' => '`item_id` IN (SELECT `id` FROM `str_item` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vStorName' => array(
      'Name' => '`stor_id`',
      'Cond' => '`stor_id` IN (SELECT `id` FROM `str_store` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTrntypeName' => array(
      'Name' => '`trntype_id`',
      'Cond' => '`trntype_id` IN (SELECT `id` FROM `str_cod_trn_type` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cStrSiacc::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrSiacc::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nStorId' => $element->StorId,
      'nItemId' => $element->ItemId,
      'nTrntypeId' => $element->TrntypeId,
      'nCostId' => $element->CostId,
      'nAccSid' => $element->AccSid,
      'nAccCid' => $element->AccCid,
      'nAccRid' => $element->AccRid,
      'nAccMid' => $element->AccMid,
      'nAccDid' => $element->AccDid,
      'vRem' => $element->Rem,
      'vAccCName' => $element->oAccC->Name,
      'vAccDName' => $element->oAccD->Name,
      'vAccMName' => $element->oAccM->Name,
      'vAccRName' => $element->oAccR->Name,
      'vAccSName' => $element->oAccS->Name,
      'vCostName' => $element->oCost->Name,
      'vItemName' => $element->oItem->Name,
      'vStorName' => $element->oStor->Name,
      'vTrntypeName' => $element->oTrntype->Name,
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
