<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.1.211108.0840
 * 
 * @author Haytham
 * @version 2.0.1.211108.0840
 * @update ????/??/?? ??:??
 *
 */

class cStrVstritem {

  var $ItemId;
  var $ItemNum;
  var $ItemName;
  var $ItemPartnum;
  var $CatId;
  var $CatName;
  var $UnitId;
  var $UnitName;
  var $Spc1Id;
  var $Spc1Name;
  var $Spc2Id;
  var $Spc2Name;
  var $Spc3Id;
  var $Spc3Name;
  var $Spc4Id;
  var $Spc4Name;
  var $Spc5Id;
  var $Spc5Name;
  var $TypeId;
  var $StatusId;
  var $CosttypeId;
  var $MethodId;
  var $InsaleId;
  var $SeasonId;
  var $ItemWarntyDays;
  var $ItemNofp;
  var $ItemMinUnit;
  var $ItemBox;
  var $ItemCcost;
  var $ItemNprice;
  var $ItemDprice;
  var $ItemSprice;
  var $ItemWprice;
  var $ItemRprice;
  var $ItemHprice;
  var $ItemMprice;
  var $ItemImage;
  var $ItemDesc;
  var $ItemRem;
  var $StorId;
  var $StorNum;
  var $StorName;
  var $StorTypeId;
  var $StorStatusId;
  var $StorSalesId;
  var $StorIsowned;
  var $StorSdate;
  var $StorEdate;
  var $StorAddress;
  var $StorRem;
  var $StorCostId;
  var $StorCostName;
  var $StorAccSid;
  var $StorAccSname;
  var $StorAccCid;
  var $StorAccCname;
  var $StorAccRid;
  var $StorAccRname;
  var $StorAccMid;
  var $StorAccMname;
  var $StorAccDid;
  var $StorAccDname;
  var $Id;
  var $CostId;
  var $AccSid;
  var $AccCid;
  var $AccRid;
  var $AccMid;
  var $AccDid;
  var $Loc1Id;
  var $Loc1Name;
  var $Loc2Id;
  var $Loc2Name;
  var $Loc3Id;
  var $Loc3Name;
  var $Cqnt;
  var $Cwqnt;
  var $Cost;
  var $Bcost;
  var $Bqnt;
  var $Bwqnt;
  var $Qmin;
  var $Qreq;
  var $Qmax;
  var $Qmin1;
  var $Qreq1;
  var $Qmax1;
  var $Qmin2;
  var $Qreq2;
  var $Qmax2;
  var $Qmin3;
  var $Qreq3;
  var $Qmax3;
  var $Qmin4;
  var $Qreq4;
  var $Qmax4;
  var $Qmin5;
  var $Qreq5;
  var $Qmax5;
  var $Qmin6;
  var $Qreq6;
  var $Qmax6;
  var $Qmin7;
  var $Qreq7;
  var $Qmax7;
  var $Qmin8;
  var $Qreq8;
  var $Qmax8;
  var $Qmin9;
  var $Qreq9;
  var $Qmax9;
  var $Qmin10;
  var $Qreq10;
  var $Qmax10;
  var $Qmin11;
  var $Qreq11;
  var $Qmax11;
  var $Qmin12;
  var $Qreq12;
  var $Qmax12;
  var $Rem;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `item_id`, `item_num`, `item_name`, `item_partnum`, `cat_id`, `cat_name`, `unit_id`'
      . ', `unit_name`, `spc1_id`, `spc1_name`, `spc2_id`, `spc2_name`, `spc3_id`, `spc3_name`'
      . ', `spc4_id`, `spc4_name`, `spc5_id`, `spc5_name`, `type_id`, `status_id`, `costtype_id`'
      . ', `method_id`, `insale_id`, `season_id`, `item_warnty_days`, `item_nofp`, `item_min_unit`, `item_box`'
      . ', `item_ccost`, `item_nprice`, `item_dprice`, `item_sprice`, `item_wprice`, `item_rprice`, `item_hprice`'
      . ', `item_mprice`, `item_image`, `item_desc`, `item_rem`, `stor_id`, `stor_num`, `stor_name`'
      . ', `stor_type_id`, `stor_status_id`, `stor_sales_id`, `stor_isowned`, `stor_sdate`, `stor_edate`, `stor_address`'
      . ', `stor_rem`, `stor_cost_id`, `stor_cost_name`, `stor_acc_sid`, `stor_acc_sname`, `stor_acc_cid`, `stor_acc_cname`'
      . ', `stor_acc_rid`, `stor_acc_rname`, `stor_acc_mid`, `stor_acc_mname`, `stor_acc_did`, `stor_acc_dname`, `id`'
      . ', `cost_id`, `acc_sid`, `acc_cid`, `acc_rid`, `acc_mid`, `acc_did`, `loc1_id`'
      . ', `loc1_name`, `loc2_id`, `loc2_name`, `loc3_id`, `loc3_name`, `cqnt`, `cwqnt`'
      . ', `cost`, `bcost`, `bqnt`, `bwqnt`, `qmin`, `qreq`, `qmax`'
      . ', `qmin1`, `qreq1`, `qmax1`, `qmin2`, `qreq2`, `qmax2`, `qmin3`'
      . ', `qreq3`, `qmax3`, `qmin4`, `qreq4`, `qmax4`, `qmin5`, `qreq5`'
      . ', `qmax5`, `qmin6`, `qreq6`, `qmax6`, `qmin7`, `qreq7`, `qmax7`'
      . ', `qmin8`, `qreq8`, `qmax8`, `qmin9`, `qreq9`, `qmax9`, `qmin10`'
      . ', `qreq10`, `qmax10`, `qmin11`, `qreq11`, `qmax11`, `qmin12`, `qreq12`'
      . ', `qmax12`, `rem`'
      . ' FROM `str_vstritem`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $sSQL .= ' ORDER BY ' . $vOrder;
    }
    if ($vLimit != '') {
      $sSQL .= ' LIMIT ' . $vLimit;
    }
    return $sSQL;
  }

  public static function getCount($vWhere = '') {
    $nCount = 0;
    $sSQL = 'SELECT count(*) nCnt FROM `str_vstritem`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    $res = ph_Execute($sSQL);
    if ($res != '' && !$res->EOF) {
      $nCount = intval($res->fields('nCnt'));
      $res->Close();
    }
    return $nCount;
  }

  public static function getArray($vWhere = '', $vOrder = '', $nPage = 0, $nPageSize = 0) {
    $aArray = array();
    $nIdx = 0;
    $vLimit = '';
    if ($nPage != 0 && $nPageSize != 0) {
      $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
    }
    if ($vOrder == '') {
      $vOrder = '`id`';
    }
    $res = ph_Execute(cStrVstritem::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVstritem::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVstritem();
    $res = ph_Execute(cStrVstritem::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVstritem::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVstritem();
    $cClass->ItemId = intval($res->fields('item_id'));
    $cClass->ItemNum = $res->fields('item_num');
    $cClass->ItemName = $res->fields('item_name');
    $cClass->ItemPartnum = $res->fields('item_partnum');
    $cClass->CatId = intval($res->fields('cat_id'));
    $cClass->CatName = $res->fields('cat_name');
    $cClass->UnitId = intval($res->fields('unit_id'));
    $cClass->UnitName = $res->fields('unit_name');
    $cClass->Spc1Id = intval($res->fields('spc1_id'));
    $cClass->Spc1Name = $res->fields('spc1_name');
    $cClass->Spc2Id = intval($res->fields('spc2_id'));
    $cClass->Spc2Name = $res->fields('spc2_name');
    $cClass->Spc3Id = intval($res->fields('spc3_id'));
    $cClass->Spc3Name = $res->fields('spc3_name');
    $cClass->Spc4Id = intval($res->fields('spc4_id'));
    $cClass->Spc4Name = $res->fields('spc4_name');
    $cClass->Spc5Id = intval($res->fields('spc5_id'));
    $cClass->Spc5Name = $res->fields('spc5_name');
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->CosttypeId = intval($res->fields('costtype_id'));
    $cClass->MethodId = intval($res->fields('method_id'));
    $cClass->InsaleId = intval($res->fields('insale_id'));
    $cClass->SeasonId = intval($res->fields('season_id'));
    $cClass->ItemWarntyDays = intval($res->fields('item_warnty_days'));
    $cClass->ItemNofp = intval($res->fields('item_nofp'));
    $cClass->ItemMinUnit = floatval($res->fields('item_min_unit'));
    $cClass->ItemBox = floatval($res->fields('item_box'));
    $cClass->ItemCcost = floatval($res->fields('item_ccost'));
    $cClass->ItemNprice = floatval($res->fields('item_nprice'));
    $cClass->ItemDprice = floatval($res->fields('item_dprice'));
    $cClass->ItemSprice = floatval($res->fields('item_sprice'));
    $cClass->ItemWprice = floatval($res->fields('item_wprice'));
    $cClass->ItemRprice = floatval($res->fields('item_rprice'));
    $cClass->ItemHprice = floatval($res->fields('item_hprice'));
    $cClass->ItemMprice = floatval($res->fields('item_mprice'));
    $cClass->ItemImage = $res->fields('item_image');
    $cClass->ItemDesc = $res->fields('item_desc');
    $cClass->ItemRem = $res->fields('item_rem');
    $cClass->StorId = intval($res->fields('stor_id'));
    $cClass->StorNum = intval($res->fields('stor_num'));
    $cClass->StorName = $res->fields('stor_name');
    $cClass->StorTypeId = intval($res->fields('stor_type_id'));
    $cClass->StorStatusId = intval($res->fields('stor_status_id'));
    $cClass->StorSalesId = intval($res->fields('stor_sales_id'));
    $cClass->StorIsowned = intval($res->fields('stor_isowned'));
    $cClass->StorSdate = $res->fields('stor_sdate');
    $cClass->StorEdate = $res->fields('stor_edate');
    $cClass->StorAddress = $res->fields('stor_address');
    $cClass->StorRem = $res->fields('stor_rem');
    $cClass->StorCostId = intval($res->fields('stor_cost_id'));
    $cClass->StorCostName = $res->fields('stor_cost_name');
    $cClass->StorAccSid = intval($res->fields('stor_acc_sid'));
    $cClass->StorAccSname = $res->fields('stor_acc_sname');
    $cClass->StorAccCid = intval($res->fields('stor_acc_cid'));
    $cClass->StorAccCname = $res->fields('stor_acc_cname');
    $cClass->StorAccRid = intval($res->fields('stor_acc_rid'));
    $cClass->StorAccRname = $res->fields('stor_acc_rname');
    $cClass->StorAccMid = intval($res->fields('stor_acc_mid'));
    $cClass->StorAccMname = $res->fields('stor_acc_mname');
    $cClass->StorAccDid = intval($res->fields('stor_acc_did'));
    $cClass->StorAccDname = $res->fields('stor_acc_dname');
    $cClass->Id = intval($res->fields('id'));
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->AccSid = intval($res->fields('acc_sid'));
    $cClass->AccCid = intval($res->fields('acc_cid'));
    $cClass->AccRid = intval($res->fields('acc_rid'));
    $cClass->AccMid = intval($res->fields('acc_mid'));
    $cClass->AccDid = intval($res->fields('acc_did'));
    $cClass->Loc1Id = intval($res->fields('loc1_id'));
    $cClass->Loc1Name = $res->fields('loc1_name');
    $cClass->Loc2Id = intval($res->fields('loc2_id'));
    $cClass->Loc2Name = $res->fields('loc2_name');
    $cClass->Loc3Id = intval($res->fields('loc3_id'));
    $cClass->Loc3Name = $res->fields('loc3_name');
    $cClass->Cqnt = floatval($res->fields('cqnt'));
    $cClass->Cwqnt = floatval($res->fields('cwqnt'));
    $cClass->Cost = floatval($res->fields('cost'));
    $cClass->Bcost = floatval($res->fields('bcost'));
    $cClass->Bqnt = floatval($res->fields('bqnt'));
    $cClass->Bwqnt = floatval($res->fields('bwqnt'));
    $cClass->Qmin = floatval($res->fields('qmin'));
    $cClass->Qreq = floatval($res->fields('qreq'));
    $cClass->Qmax = floatval($res->fields('qmax'));
    $cClass->Qmin1 = floatval($res->fields('qmin1'));
    $cClass->Qreq1 = floatval($res->fields('qreq1'));
    $cClass->Qmax1 = floatval($res->fields('qmax1'));
    $cClass->Qmin2 = floatval($res->fields('qmin2'));
    $cClass->Qreq2 = floatval($res->fields('qreq2'));
    $cClass->Qmax2 = floatval($res->fields('qmax2'));
    $cClass->Qmin3 = floatval($res->fields('qmin3'));
    $cClass->Qreq3 = floatval($res->fields('qreq3'));
    $cClass->Qmax3 = floatval($res->fields('qmax3'));
    $cClass->Qmin4 = floatval($res->fields('qmin4'));
    $cClass->Qreq4 = floatval($res->fields('qreq4'));
    $cClass->Qmax4 = floatval($res->fields('qmax4'));
    $cClass->Qmin5 = floatval($res->fields('qmin5'));
    $cClass->Qreq5 = floatval($res->fields('qreq5'));
    $cClass->Qmax5 = floatval($res->fields('qmax5'));
    $cClass->Qmin6 = floatval($res->fields('qmin6'));
    $cClass->Qreq6 = floatval($res->fields('qreq6'));
    $cClass->Qmax6 = floatval($res->fields('qmax6'));
    $cClass->Qmin7 = floatval($res->fields('qmin7'));
    $cClass->Qreq7 = floatval($res->fields('qreq7'));
    $cClass->Qmax7 = floatval($res->fields('qmax7'));
    $cClass->Qmin8 = floatval($res->fields('qmin8'));
    $cClass->Qreq8 = floatval($res->fields('qreq8'));
    $cClass->Qmax8 = floatval($res->fields('qmax8'));
    $cClass->Qmin9 = floatval($res->fields('qmin9'));
    $cClass->Qreq9 = floatval($res->fields('qreq9'));
    $cClass->Qmax9 = floatval($res->fields('qmax9'));
    $cClass->Qmin10 = floatval($res->fields('qmin10'));
    $cClass->Qreq10 = floatval($res->fields('qreq10'));
    $cClass->Qmax10 = floatval($res->fields('qmax10'));
    $cClass->Qmin11 = floatval($res->fields('qmin11'));
    $cClass->Qreq11 = floatval($res->fields('qreq11'));
    $cClass->Qmax11 = floatval($res->fields('qmax11'));
    $cClass->Qmin12 = floatval($res->fields('qmin12'));
    $cClass->Qreq12 = floatval($res->fields('qreq12'));
    $cClass->Qmax12 = floatval($res->fields('qmax12'));
    $cClass->Rem = $res->fields('rem');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_vstritem` ('
        . '  `item_num`, `item_name`, `item_partnum`, `cat_id`, `cat_name`, `unit_id`, `unit_name`'
        . ', `spc1_id`, `spc1_name`, `spc2_id`, `spc2_name`, `spc3_id`, `spc3_name`, `spc4_id`'
        . ', `spc4_name`, `spc5_id`, `spc5_name`, `type_id`, `status_id`, `costtype_id`, `method_id`'
        . ', `insale_id`, `season_id`, `item_warnty_days`, `item_nofp`, `item_min_unit`, `item_box`, `item_ccost`'
        . ', `item_nprice`, `item_dprice`, `item_sprice`, `item_wprice`, `item_rprice`, `item_hprice`, `item_mprice`'
        . ', `item_image`, `item_desc`, `item_rem`, `stor_id`, `stor_num`, `stor_name`, `stor_type_id`'
        . ', `stor_status_id`, `stor_sales_id`, `stor_isowned`, `stor_sdate`, `stor_edate`, `stor_address`, `stor_rem`'
        . ', `stor_cost_id`, `stor_cost_name`, `stor_acc_sid`, `stor_acc_sname`, `stor_acc_cid`, `stor_acc_cname`, `stor_acc_rid`'
        . ', `stor_acc_rname`, `stor_acc_mid`, `stor_acc_mname`, `stor_acc_did`, `stor_acc_dname`, `id`, `cost_id`'
        . ', `acc_sid`, `acc_cid`, `acc_rid`, `acc_mid`, `acc_did`, `loc1_id`, `loc1_name`'
        . ', `loc2_id`, `loc2_name`, `loc3_id`, `loc3_name`, `cqnt`, `cwqnt`, `cost`'
        . ', `bcost`, `bqnt`, `bwqnt`, `qmin`, `qreq`, `qmax`, `qmin1`'
        . ', `qreq1`, `qmax1`, `qmin2`, `qreq2`, `qmax2`, `qmin3`, `qreq3`'
        . ', `qmax3`, `qmin4`, `qreq4`, `qmax4`, `qmin5`, `qreq5`, `qmax5`'
        . ', `qmin6`, `qreq6`, `qmax6`, `qmin7`, `qreq7`, `qmax7`, `qmin8`'
        . ', `qreq8`, `qmax8`, `qmin9`, `qreq9`, `qmax9`, `qmin10`, `qreq10`'
        . ', `qmax10`, `qmin11`, `qreq11`, `qmax11`, `qmin12`, `qreq12`, `qmax12`'
        . ', `rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->ItemNum . '"'
        . ', "' . $this->ItemName . '"'
        . ', "' . $this->ItemPartnum . '"'
        . ', "' . $this->CatId . '"'
        . ', "' . $this->CatName . '"'
        . ', "' . $this->UnitId . '"'
        . ', "' . $this->UnitName . '"'
        . ', "' . $this->Spc1Id . '"'
        . ', "' . $this->Spc1Name . '"'
        . ', "' . $this->Spc2Id . '"'
        . ', "' . $this->Spc2Name . '"'
        . ', "' . $this->Spc3Id . '"'
        . ', "' . $this->Spc3Name . '"'
        . ', "' . $this->Spc4Id . '"'
        . ', "' . $this->Spc4Name . '"'
        . ', "' . $this->Spc5Id . '"'
        . ', "' . $this->Spc5Name . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->StatusId . '"'
        . ', "' . $this->CosttypeId . '"'
        . ', "' . $this->MethodId . '"'
        . ', "' . $this->InsaleId . '"'
        . ', "' . $this->SeasonId . '"'
        . ', "' . $this->ItemWarntyDays . '"'
        . ', "' . $this->ItemNofp . '"'
        . ', "' . $this->ItemMinUnit . '"'
        . ', "' . $this->ItemBox . '"'
        . ', "' . $this->ItemCcost . '"'
        . ', "' . $this->ItemNprice . '"'
        . ', "' . $this->ItemDprice . '"'
        . ', "' . $this->ItemSprice . '"'
        . ', "' . $this->ItemWprice . '"'
        . ', "' . $this->ItemRprice . '"'
        . ', "' . $this->ItemHprice . '"'
        . ', "' . $this->ItemMprice . '"'
        . ', "' . $this->ItemImage . '"'
        . ', "' . $this->ItemDesc . '"'
        . ', "' . $this->ItemRem . '"'
        . ', "' . $this->StorId . '"'
        . ', "' . $this->StorNum . '"'
        . ', "' . $this->StorName . '"'
        . ', "' . $this->StorTypeId . '"'
        . ', "' . $this->StorStatusId . '"'
        . ', "' . $this->StorSalesId . '"'
        . ', "' . $this->StorIsowned . '"'
        . ', "' . $this->StorSdate . '"'
        . ', "' . $this->StorEdate . '"'
        . ', "' . $this->StorAddress . '"'
        . ', "' . $this->StorRem . '"'
        . ', "' . $this->StorCostId . '"'
        . ', "' . $this->StorCostName . '"'
        . ', "' . $this->StorAccSid . '"'
        . ', "' . $this->StorAccSname . '"'
        . ', "' . $this->StorAccCid . '"'
        . ', "' . $this->StorAccCname . '"'
        . ', "' . $this->StorAccRid . '"'
        . ', "' . $this->StorAccRname . '"'
        . ', "' . $this->StorAccMid . '"'
        . ', "' . $this->StorAccMname . '"'
        . ', "' . $this->StorAccDid . '"'
        . ', "' . $this->StorAccDname . '"'
        . ', "' . $this->Id . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->AccSid . '"'
        . ', "' . $this->AccCid . '"'
        . ', "' . $this->AccRid . '"'
        . ', "' . $this->AccMid . '"'
        . ', "' . $this->AccDid . '"'
        . ', "' . $this->Loc1Id . '"'
        . ', "' . $this->Loc1Name . '"'
        . ', "' . $this->Loc2Id . '"'
        . ', "' . $this->Loc2Name . '"'
        . ', "' . $this->Loc3Id . '"'
        . ', "' . $this->Loc3Name . '"'
        . ', "' . $this->Cqnt . '"'
        . ', "' . $this->Cwqnt . '"'
        . ', "' . $this->Cost . '"'
        . ', "' . $this->Bcost . '"'
        . ', "' . $this->Bqnt . '"'
        . ', "' . $this->Bwqnt . '"'
        . ', "' . $this->Qmin . '"'
        . ', "' . $this->Qreq . '"'
        . ', "' . $this->Qmax . '"'
        . ', "' . $this->Qmin1 . '"'
        . ', "' . $this->Qreq1 . '"'
        . ', "' . $this->Qmax1 . '"'
        . ', "' . $this->Qmin2 . '"'
        . ', "' . $this->Qreq2 . '"'
        . ', "' . $this->Qmax2 . '"'
        . ', "' . $this->Qmin3 . '"'
        . ', "' . $this->Qreq3 . '"'
        . ', "' . $this->Qmax3 . '"'
        . ', "' . $this->Qmin4 . '"'
        . ', "' . $this->Qreq4 . '"'
        . ', "' . $this->Qmax4 . '"'
        . ', "' . $this->Qmin5 . '"'
        . ', "' . $this->Qreq5 . '"'
        . ', "' . $this->Qmax5 . '"'
        . ', "' . $this->Qmin6 . '"'
        . ', "' . $this->Qreq6 . '"'
        . ', "' . $this->Qmax6 . '"'
        . ', "' . $this->Qmin7 . '"'
        . ', "' . $this->Qreq7 . '"'
        . ', "' . $this->Qmax7 . '"'
        . ', "' . $this->Qmin8 . '"'
        . ', "' . $this->Qreq8 . '"'
        . ', "' . $this->Qmax8 . '"'
        . ', "' . $this->Qmin9 . '"'
        . ', "' . $this->Qreq9 . '"'
        . ', "' . $this->Qmax9 . '"'
        . ', "' . $this->Qmin10 . '"'
        . ', "' . $this->Qreq10 . '"'
        . ', "' . $this->Qmax10 . '"'
        . ', "' . $this->Qmin11 . '"'
        . ', "' . $this->Qreq11 . '"'
        . ', "' . $this->Qmax11 . '"'
        . ', "' . $this->Qmin12 . '"'
        . ', "' . $this->Qreq12 . '"'
        . ', "' . $this->Qmax12 . '"'
        . ', "' . $this->Rem . '"'
        . ', "' . $nUId . '"'
        . ')';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $nId = $this->Id;
      $vSQL = 'UPDATE `str_vstritem` SET'
        . '  `item_num`="' . $this->ItemNum . '"'
        . ', `item_name`="' . $this->ItemName . '"'
        . ', `item_partnum`="' . $this->ItemPartnum . '"'
        . ', `cat_id`="' . $this->CatId . '"'
        . ', `cat_name`="' . $this->CatName . '"'
        . ', `unit_id`="' . $this->UnitId . '"'
        . ', `unit_name`="' . $this->UnitName . '"'
        . ', `spc1_id`="' . $this->Spc1Id . '"'
        . ', `spc1_name`="' . $this->Spc1Name . '"'
        . ', `spc2_id`="' . $this->Spc2Id . '"'
        . ', `spc2_name`="' . $this->Spc2Name . '"'
        . ', `spc3_id`="' . $this->Spc3Id . '"'
        . ', `spc3_name`="' . $this->Spc3Name . '"'
        . ', `spc4_id`="' . $this->Spc4Id . '"'
        . ', `spc4_name`="' . $this->Spc4Name . '"'
        . ', `spc5_id`="' . $this->Spc5Id . '"'
        . ', `spc5_name`="' . $this->Spc5Name . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `costtype_id`="' . $this->CosttypeId . '"'
        . ', `method_id`="' . $this->MethodId . '"'
        . ', `insale_id`="' . $this->InsaleId . '"'
        . ', `season_id`="' . $this->SeasonId . '"'
        . ', `item_warnty_days`="' . $this->ItemWarntyDays . '"'
        . ', `item_nofp`="' . $this->ItemNofp . '"'
        . ', `item_min_unit`="' . $this->ItemMinUnit . '"'
        . ', `item_box`="' . $this->ItemBox . '"'
        . ', `item_ccost`="' . $this->ItemCcost . '"'
        . ', `item_nprice`="' . $this->ItemNprice . '"'
        . ', `item_dprice`="' . $this->ItemDprice . '"'
        . ', `item_sprice`="' . $this->ItemSprice . '"'
        . ', `item_wprice`="' . $this->ItemWprice . '"'
        . ', `item_rprice`="' . $this->ItemRprice . '"'
        . ', `item_hprice`="' . $this->ItemHprice . '"'
        . ', `item_mprice`="' . $this->ItemMprice . '"'
        . ', `item_image`="' . $this->ItemImage . '"'
        . ', `item_desc`="' . $this->ItemDesc . '"'
        . ', `item_rem`="' . $this->ItemRem . '"'
        . ', `stor_id`="' . $this->StorId . '"'
        . ', `stor_num`="' . $this->StorNum . '"'
        . ', `stor_name`="' . $this->StorName . '"'
        . ', `stor_type_id`="' . $this->StorTypeId . '"'
        . ', `stor_status_id`="' . $this->StorStatusId . '"'
        . ', `stor_sales_id`="' . $this->StorSalesId . '"'
        . ', `stor_isowned`="' . $this->StorIsowned . '"'
        . ', `stor_sdate`="' . $this->StorSdate . '"'
        . ', `stor_edate`="' . $this->StorEdate . '"'
        . ', `stor_address`="' . $this->StorAddress . '"'
        . ', `stor_rem`="' . $this->StorRem . '"'
        . ', `stor_cost_id`="' . $this->StorCostId . '"'
        . ', `stor_cost_name`="' . $this->StorCostName . '"'
        . ', `stor_acc_sid`="' . $this->StorAccSid . '"'
        . ', `stor_acc_sname`="' . $this->StorAccSname . '"'
        . ', `stor_acc_cid`="' . $this->StorAccCid . '"'
        . ', `stor_acc_cname`="' . $this->StorAccCname . '"'
        . ', `stor_acc_rid`="' . $this->StorAccRid . '"'
        . ', `stor_acc_rname`="' . $this->StorAccRname . '"'
        . ', `stor_acc_mid`="' . $this->StorAccMid . '"'
        . ', `stor_acc_mname`="' . $this->StorAccMname . '"'
        . ', `stor_acc_did`="' . $this->StorAccDid . '"'
        . ', `stor_acc_dname`="' . $this->StorAccDname . '"'
        . ', `id`="' . $this->Id . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `acc_sid`="' . $this->AccSid . '"'
        . ', `acc_cid`="' . $this->AccCid . '"'
        . ', `acc_rid`="' . $this->AccRid . '"'
        . ', `acc_mid`="' . $this->AccMid . '"'
        . ', `acc_did`="' . $this->AccDid . '"'
        . ', `loc1_id`="' . $this->Loc1Id . '"'
        . ', `loc1_name`="' . $this->Loc1Name . '"'
        . ', `loc2_id`="' . $this->Loc2Id . '"'
        . ', `loc2_name`="' . $this->Loc2Name . '"'
        . ', `loc3_id`="' . $this->Loc3Id . '"'
        . ', `loc3_name`="' . $this->Loc3Name . '"'
        . ', `cqnt`="' . $this->Cqnt . '"'
        . ', `cwqnt`="' . $this->Cwqnt . '"'
        . ', `cost`="' . $this->Cost . '"'
        . ', `bcost`="' . $this->Bcost . '"'
        . ', `bqnt`="' . $this->Bqnt . '"'
        . ', `bwqnt`="' . $this->Bwqnt . '"'
        . ', `qmin`="' . $this->Qmin . '"'
        . ', `qreq`="' . $this->Qreq . '"'
        . ', `qmax`="' . $this->Qmax . '"'
        . ', `qmin1`="' . $this->Qmin1 . '"'
        . ', `qreq1`="' . $this->Qreq1 . '"'
        . ', `qmax1`="' . $this->Qmax1 . '"'
        . ', `qmin2`="' . $this->Qmin2 . '"'
        . ', `qreq2`="' . $this->Qreq2 . '"'
        . ', `qmax2`="' . $this->Qmax2 . '"'
        . ', `qmin3`="' . $this->Qmin3 . '"'
        . ', `qreq3`="' . $this->Qreq3 . '"'
        . ', `qmax3`="' . $this->Qmax3 . '"'
        . ', `qmin4`="' . $this->Qmin4 . '"'
        . ', `qreq4`="' . $this->Qreq4 . '"'
        . ', `qmax4`="' . $this->Qmax4 . '"'
        . ', `qmin5`="' . $this->Qmin5 . '"'
        . ', `qreq5`="' . $this->Qreq5 . '"'
        . ', `qmax5`="' . $this->Qmax5 . '"'
        . ', `qmin6`="' . $this->Qmin6 . '"'
        . ', `qreq6`="' . $this->Qreq6 . '"'
        . ', `qmax6`="' . $this->Qmax6 . '"'
        . ', `qmin7`="' . $this->Qmin7 . '"'
        . ', `qreq7`="' . $this->Qreq7 . '"'
        . ', `qmax7`="' . $this->Qmax7 . '"'
        . ', `qmin8`="' . $this->Qmin8 . '"'
        . ', `qreq8`="' . $this->Qreq8 . '"'
        . ', `qmax8`="' . $this->Qmax8 . '"'
        . ', `qmin9`="' . $this->Qmin9 . '"'
        . ', `qreq9`="' . $this->Qreq9 . '"'
        . ', `qmax9`="' . $this->Qmax9 . '"'
        . ', `qmin10`="' . $this->Qmin10 . '"'
        . ', `qreq10`="' . $this->Qreq10 . '"'
        . ', `qmax10`="' . $this->Qmax10 . '"'
        . ', `qmin11`="' . $this->Qmin11 . '"'
        . ', `qreq11`="' . $this->Qreq11 . '"'
        . ', `qmax11`="' . $this->Qmax11 . '"'
        . ', `qmin12`="' . $this->Qmin12 . '"'
        . ', `qreq12`="' . $this->Qreq12 . '"'
        . ', `qmax12`="' . $this->Qmax12 . '"'
        . ', `rem`="' . $this->Rem . '"'
        . ', `upd_user`="' . $nUId . '"'
        . ' WHERE `id`="' . $this->Id . '"';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `str_vstritem` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

