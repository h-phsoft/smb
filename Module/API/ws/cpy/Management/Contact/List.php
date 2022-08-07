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
    'nNum' => array(
      'Name' => '`num`',
      'Cond' => '`num`="COND_VALUE"'
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
    'vTitle' => array(
      'Name' => '`title`',
      'Cond' => '`title` LIKE "%COND_VALUE%"'
    ),
    'vLegal' => array(
      'Name' => '`legal`',
      'Cond' => '`legal` LIKE "%COND_VALUE%"'
    ),
    'vOwner' => array(
      'Name' => '`owner`',
      'Cond' => '`owner` LIKE "%COND_VALUE%"'
    ),
    'vPerson' => array(
      'Name' => '`person`',
      'Cond' => '`person` LIKE "%COND_VALUE%"'
    ),
    'nNlmt' => array(
      'Name' => '`nlmt`',
      'Cond' => '`nlmt`="COND_VALUE"'
    ),
    'nDlmt' => array(
      'Name' => '`dlmt`',
      'Cond' => '`dlmt`="COND_VALUE"'
    ),
    'nPriceId' => array(
      'Name' => '`price_id`',
      'Cond' => '`price_id`="COND_VALUE"'
    ),
    'nReprId' => array(
      'Name' => '`repr_id`',
      'Cond' => '`repr_id`="COND_VALUE"'
    ),
    'nStatusId' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id`="COND_VALUE"'
    ),
    'nTypeId' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id`="COND_VALUE"'
    ),
    'nBlmId' => array(
      'Name' => '`blm_id`',
      'Cond' => '`blm_id`="COND_VALUE"'
    ),
    'nNatId' => array(
      'Name' => '`nat_id`',
      'Cond' => '`nat_id`="COND_VALUE"'
    ),
    'nClass1Id' => array(
      'Name' => '`class1_id`',
      'Cond' => '`class1_id`="COND_VALUE"'
    ),
    'nClass2Id' => array(
      'Name' => '`class2_id`',
      'Cond' => '`class2_id`="COND_VALUE"'
    ),
    'nClass3Id' => array(
      'Name' => '`class3_id`',
      'Cond' => '`class3_id`="COND_VALUE"'
    ),
    'nClass4Id' => array(
      'Name' => '`class4_id`',
      'Cond' => '`class4_id`="COND_VALUE"'
    ),
    'nClass5Id' => array(
      'Name' => '`class5_id`',
      'Cond' => '`class5_id`="COND_VALUE"'
    ),
    'vPhone' => array(
      'Name' => '`phone`',
      'Cond' => '`phone` LIKE "%COND_VALUE%"'
    ),
    'vMobile' => array(
      'Name' => '`mobile`',
      'Cond' => '`mobile` LIKE "%COND_VALUE%"'
    ),
    'vEmail' => array(
      'Name' => '`email`',
      'Cond' => '`email` LIKE "%COND_VALUE%"'
    ),
    'vAddress' => array(
      'Name' => '`address`',
      'Cond' => '`address` LIKE "%COND_VALUE%"'
    ),
    'dOdate' => array(
      'Name' => '`odate`',
      'Cond' => '`odate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'dSdate' => array(
      'Name' => '`sdate`',
      'Cond' => '`sdate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'dEdate' => array(
      'Name' => '`edate`',
      'Cond' => '`edate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'dGdate' => array(
      'Name' => '`gdate`',
      'Cond' => '`gdate`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'nInsUser' => array(
      'Name' => '`ins_user`',
      'Cond' => '`ins_user`="COND_VALUE"'
    ),
    'dInsDate' => array(
      'Name' => '`ins_date`',
      'Cond' => '`ins_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'nUpdUser' => array(
      'Name' => '`upd_user`',
      'Cond' => '`upd_user`="COND_VALUE"'
    ),
    'dUpdDate' => array(
      'Name' => '`upd_date`',
      'Cond' => '`upd_date`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
    ),
    'vBlmName' => array(
      'Name' => '`blm_id`',
      'Cond' => '`blm_id` IN (SELECT `id` FROM `phs_cod_cont_blm` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vClass1Name' => array(
      'Name' => '`class1_id`',
      'Cond' => '`class1_id` IN (SELECT `id` FROM `mng_cod_cont_class` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vClass2Name' => array(
      'Name' => '`class2_id`',
      'Cond' => '`class2_id` IN (SELECT `id` FROM `mng_cod_cont_class` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vClass3Name' => array(
      'Name' => '`class3_id`',
      'Cond' => '`class3_id` IN (SELECT `id` FROM `mng_cod_cont_class` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vClass4Name' => array(
      'Name' => '`class4_id`',
      'Cond' => '`class4_id` IN (SELECT `id` FROM `mng_cod_cont_class` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vClass5Name' => array(
      'Name' => '`class5_id`',
      'Cond' => '`class5_id` IN (SELECT `id` FROM `mng_cod_cont_class` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vInsUserName' => array(
      'Name' => '`ins_user`',
      'Cond' => '`ins_user` IN (SELECT `id` FROM `cpy_user` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vNatName' => array(
      'Name' => '`nat_id`',
      'Cond' => '`nat_id` IN (SELECT `id` FROM `cpy_cod_nat` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vPriceName' => array(
      'Name' => '`price_id`',
      'Cond' => '`price_id` IN (SELECT `id` FROM `sal_mprice` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vReprName' => array(
      'Name' => '`repr_id`',
      'Cond' => '`repr_id` IN (SELECT `id` FROM `crm_repr` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vStatusName' => array(
      'Name' => '`status_id`',
      'Cond' => '`status_id` IN (SELECT `id` FROM `phs_cod_status` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vTypeName' => array(
      'Name' => '`type_id`',
      'Cond' => '`type_id` IN (SELECT `id` FROM `phs_cod_cont_type` WHERE `name` LIKE "%COND_VALUE%")'
    ),
    'vUpdUserName' => array(
      'Name' => '`upd_user`',
      'Cond' => '`upd_user` IN (SELECT `id` FROM `cpy_user` WHERE `name` LIKE "%COND_VALUE%")'
    ),
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
  $vOrder = 'id>0';
  $vComma = ' AND ';
  if (isset($sorters) && is_array($sorters)) {
    foreach ($sorters as $field) {
      if (isset($aFields[$field['field']])) {
        $vOrder .= $vComma . $aFields[$field['field']]['Name'] . ' ' . strtoupper($field['dir']);
        $vComma = ', ';
      }
    }
  }
  $nPages = 0;
  $nCount = cMngCont::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cMngCont::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nNum' => $element->Num,
      'vName' => $element->Name,
      'vUsername' => $element->Username,
      'vPassword' => $element->Password,
      'vTitle' => $element->Title,
      'vLegal' => $element->Legal,
      'vOwner' => $element->Owner,
      'vPerson' => $element->Person,
      'nNlmt' => $element->Nlmt,
      'nDlmt' => $element->Dlmt,
      'nPriceId' => $element->PriceId,
      'nReprId' => $element->ReprId,
      'nStatusId' => $element->StatusId,
      'nTypeId' => $element->TypeId,
      'nBlmId' => $element->BlmId,
      'nNatId' => $element->NatId,
      'nClass1Id' => $element->Class1Id,
      'nClass2Id' => $element->Class2Id,
      'nClass3Id' => $element->Class3Id,
      'nClass4Id' => $element->Class4Id,
      'nClass5Id' => $element->Class5Id,
      'vPhone' => $element->Phone,
      'vMobile' => $element->Mobile,
      'vEmail' => $element->Email,
      'vAddress' => $element->Address,
      'dOdate' => date_format(date_create($element->Odate), 'Y-m-d'),
      'dSdate' => date_format(date_create($element->Sdate), 'Y-m-d'),
      'dEdate' => date_format(date_create($element->Edate), 'Y-m-d'),
      'dGdate' => date_format(date_create($element->Gdate), 'Y-m-d'),
      'nInsUser' => $element->InsUser,
      'dInsDate' => date_format(date_create($element->InsDate), 'Y-m-d h:s'),
      'nUpdUser' => $element->UpdUser,
      'dUpdDate' => date_format(date_create($element->UpdDate), 'Y-m-d h:s'),
      'vBlmName' => $element->oBlm->Name,
      'vClass1Name' => $element->oClass1->Name,
      'vClass2Name' => $element->oClass2->Name,
      'vClass3Name' => $element->oClass3->Name,
      'vClass4Name' => $element->oClass4->Name,
      'vClass5Name' => $element->oClass5->Name,
      'vInsUserName' => $element->oInsUser->Name,
      'vNatName' => $element->oNat->Name,
      'vPriceName' => $element->oPrice->Name,
      'vReprName' => $element->oRepr->Name,
      'vStatusName' => $element->oStatus->Name,
      'vTypeName' => $element->oType->Name,
      'vUpdUserName' => $element->oUpdUser->Name,
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
