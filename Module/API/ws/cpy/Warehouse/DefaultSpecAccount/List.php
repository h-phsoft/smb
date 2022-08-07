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
    'vSpc1Name' => array(
      'Name' => '`spc1_id`',
      'Cond' => '`spc1_id` IN (SELECT `id` FROM `str_cod_spc1` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSpc2Name' => array(
      'Name' => '`spc2_id`',
      'Cond' => '`spc2_id` IN (SELECT `id` FROM `str_cod_spc2` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSpc3Name' => array(
      'Name' => '`spc3_id`',
      'Cond' => '`spc3_id` IN (SELECT `id` FROM `str_cod_spc3` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSpc4Name' => array(
      'Name' => '`spc4_id`',
      'Cond' => '`spc4_id` IN (SELECT `id` FROM `str_cod_spc4` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vSpc5Name' => array(
      'Name' => '`spc5_id`',
      'Cond' => '`spc5_id` IN (SELECT `id` FROM `str_cod_spc5` WHERE `name` LIKE "%COND_VALUE%")'
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
  $nCount = cStrClassacc::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrClassacc::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nTrntypeId' => $element->TrntypeId,
      'nSpc1Id' => $element->Spc1Id,
      'nSpc2Id' => $element->Spc2Id,
      'nSpc3Id' => $element->Spc3Id,
      'nSpc4Id' => $element->Spc4Id,
      'nSpc5Id' => $element->Spc5Id,
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
      'vSpc1Name' => $element->oSpc1->Name,
      'vSpc2Name' => $element->oSpc2->Name,
      'vSpc3Name' => $element->oSpc3->Name,
      'vSpc4Name' => $element->oSpc4->Name,
      'vSpc5Name' => $element->oSpc5->Name,
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
