<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');

  $aFields = array(
    'Id' => array(
      'Name' => '`mst_id`',
      'Cond' => '`mst_id`="COND_VALUE"'
    ),
    'Stor' => array(
      'Name' => '`stor_num`',
      'Cond' => '(`stor_num`="COND_VALUE" OR `stor_name` LIKE "%COND_VALUE%")'
    ),
    'Num' => array(
      'Name' => '`mst_num`',
      'Cond' => '`mst_num`="COND_VALUE"'
    ),
    'Date' => array(
      'Name' => '`mst_date`',
      'Cond' => '`mst_date`="COND_VALUE"'
    ),
    'Acc' => array(
      'Name' => '`acc_num`',
      'Cond' => '(`acc_num` LIKE "%COND_VALUE%" OR `acc_name` LIKE "%COND_VALUE%")'
    ),
    'Cost' => array(
      'Name' => '`cost_name`',
      'Cond' => '(`cost_name` LIKE "%COND_VALUE%" OR `cost_name` LIKE "%COND_VALUE%")'
    ),
    'Doc' => array(
      'Name' => '`doc_name`',
      'Cond' => '`doc_name` LIKE "%COND_VALUE%"'
    ),
    'DocNum' => array(
      'Name' => '`mst_docn`',
      'Cond' => '`mst_docn`="COND_VALUE"'
    ),
    'DocDate' => array(
      'Name' => '`mst_docd`',
      'Cond' => '`mst_docd`="COND_VALUE"'
    ),
    'RNum' => array(
      'Name' => '`mst_rnum`',
      'Cond' => '`mst_rnum`="COND_VALUE"'
    ),
    'RDate' => array(
      'Name' => '`mst_rdate`',
      'Cond' => '`mst_rdate`="COND_VALUE"'
    ),
    'RDcoN' => array(
      'Name' => '`mst_rdocn`',
      'Cond' => '`mst_rdocn`="COND_VALUE"'
    ),
    'RDocD' => array(
      'Name' => '`mst_rdocd`',
      'Cond' => '`mst_rdocd`="COND_VALUE"'
    ),
    'Rem' => array(
      'Name' => '`mst_rem`',
      'Cond' => '`mst_rem` LIKE "%COND_VALUE%"'
    ),
  );

  $vWhere = '';
  $vAnd = '';
  //if ($oUser->oGrp->SStatusId == 2) {
  //  $vWhere = '(`stor_id` IN (SELECT `stor_id` FROM `cpy_type_store` WHERE `type_id`="' . $oUser->oGrp->Id . '"))';
  //  $vAnd = ' AND ';
  //}
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
  $nCount = cStrOuMst::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cStrOuMst::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'Id' => $element->MstId,
      'StorId' => $element->StorId,
      'Stor' => $element->StorNum . ' ' . $element->StorName,
      'DocId' => $element->DocId,
      'Doc' => $element->DocName,
      'AccId' => $element->AccId,
      'Acc' => $element->AccNum . ' ' . $element->AccName,
      'CostId' => $element->CostId,
      'Csot' => $element->CostNum . ' ' . $element->CostName,
      'Num' => $element->MstNum,
      'Date' => $element->MstDate,
      'DocNum' => $element->DocNum,
      'DocDate' => $element->DocDate,
      'RNum' => $element->MstRNum,
      'RDate' => $element->MstRDate,
      'RDocNum' => $element->MstRNum,
      'RDocDate' => $element->MstRDate,
      'Rem' => $element->MstRem
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