<?php

class cStrStoreItem {

  var $Id = -999;
  var $StatusId = 1;
  var $Loc1Id = 0;
  var $Loc1Name = 'None';
  var $Loc2Id = 0;
  var $Loc2Name = 'None';
  var $Loc3Id = 0;
  var $Loc3Name = 'None';
  var $MaxQnt = 0;
  var $ReqQnt = 0;
  var $MinQnt = 0;
  var $Qnt = 0;
  var $Amt = 0;
  var $Rem = '';
  var $ItemId = -999;
  var $ItemStatusId = 1;
  var $ItemStatusName = '';
  var $ItemUnitId = 1;
  var $ItemUnitName = '';
  var $ItemSpec1Id = 0;
  var $ItemSpec1Name = 'None';
  var $ItemSpec2Id = 0;
  var $ItemSpec2Name = 'None';
  var $ItemSpec3Id = 0;
  var $ItemSpec3Name = 'None';
  var $ItemNum;
  var $ItemName;
  var $ItemMNum;
  var $ItemRem;
  var $StorStatusId = 1;
  var $StorStatusName = '';
  var $StorAccId = null;
  var $StorAccName = '';
  var $StorUserId = 0;
  var $StorUserName = 'None';
  var $StorNum;
  var $StorName;
  var $StorRem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `item_id` , `item_num`, `item_name`, `item_status_id`, `item_status_name`,'
            . ' `item_spc1_id`, `item_spc1_name`, `item_spc2_id`, `item_spc2_name`,'
            . ' `item_spc3_id`, `item_spc3_name`, `item_mnum`   , `item_unit_id`  ,'
            . ' `item_unit_name`, `item_rem`,'
            . ' `stor_id`, `stor_num`, `stor_name`, `stor_rem`,'
            . ' `stor_status_id`, `stor_status_name`,'
            . ' `stor_acc_id`, `stor_acc_name`,'
            . ' `stor_user_id`, `stor_user_name`,'
            . ' `id`, `status_id`,'
            . ' `loc1_id`, `loc1_name`, `loc2_id`, `loc2_name`, `loc3_id`, `loc3_name`,'
            . ' `reqqnt`, `maxqnt`, `minqnt`,'
            . ' `cqnt`, `camt`,'
            . ' `rem`'
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
      $nCount = intval($res->fields("nCnt"));
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
      $vOrder = '`stor_num`, `item_num`, `Id`';
    }
    $res = ph_Execute(cStrStoreItem::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrStoreItem::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrStoreItem();
    $res = ph_Execute(cStrStoreItem::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrStoreItem::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getMaterial($vWhere) {
    $cClass = new cStrStoreItem();
    $res = ph_Execute(cStrStoreItem::getSelectStatement($vWhere));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrStoreItem::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrStoreItem();
    $cClass->ItemId = intval($res->fields("item_id"));
    $cClass->ItemStatusId = intval($res->fields("item_status_id"));
    $cClass->ItemStatusName = $res->fields("item_status_name");
    $cClass->ItemUnitId = intval($res->fields("item_unit_id"));
    $cClass->ItemUnitName = $res->fields("item_unit_name");
    $cClass->ItemSpec1Id = intval($res->fields("item_spc1_id"));
    $cClass->ItemSpec1Name = $res->fields("item_spc1_name");
    $cClass->ItemSpec2Id = intval($res->fields("item_spc2_id"));
    $cClass->ItemSpec2Name = $res->fields("item_spc2_name");
    $cClass->ItemSpec3Id = intval($res->fields("item_spc3_id"));
    $cClass->ItemSpec3Name = $res->fields("item_spc3_name");
    $cClass->ItemNum = $res->fields("item_num");
    $cClass->ItemName = $res->fields("item_name");
    $cClass->ItemMNum = $res->fields("item_mnum");
    $cClass->ItemRem = $res->fields("item_rem");

    $cClass->StorId = intval($res->fields("stor_id"));
    $cClass->StorStatusId = intval($res->fields("stor_status_id"));
    $cClass->StorStatusName = $res->fields("stor_status_name");
    $cClass->StorAccId = intval($res->fields("stor_acc_id"));
    $cClass->StorAccName = $res->fields("stor_acc_name");
    $cClass->StorUserId = intval($res->fields("stor_user_id"));
    $cClass->StorUserName = $res->fields("stor_user_name");
    $cClass->StorNum = $res->fields("stor_num");
    $cClass->StorName = $res->fields("stor_name");
    $cClass->StorRem = $res->fields("stor_rem");

    $cClass->Id = intval($res->fields("id"));
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->Loc1Id = intval($res->fields("loc1_id"));
    $cClass->Loc1Name = $res->fields("loc1_name");
    $cClass->Loc2Id = intval($res->fields("loc2_id"));
    $cClass->Loc2Name = $res->fields("loc2_name");
    $cClass->Loc3Id = intval($res->fields("loc3_id"));
    $cClass->Loc3Name = $res->fields("loc3_name");
    $cClass->ReqQnt = floatval($res->fields("reqqnt"));
    $cClass->MinQnt = floatval($res->fields("minqnt"));
    $cClass->MaxQnt = floatval($res->fields("maxqnt"));
    $cClass->Qnt1 = floatval($res->fields("cqnt1"));
    $cClass->Qnt2 = floatval($res->fields("cqnt2"));
    $cClass->Qnt3 = floatval($res->fields("cqnt3"));
    $cClass->Amt3 = floatval($res->fields("camt3"));
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function addQnt($nQnt = 0, $nAmt = 0) {
    if ($this->Id > 0 && $nQnt != 0) {
      $this->Qnt = $this->Qnt + $nQnt;
      $this->Amt = $this->Amt + $nAmt;
      if ($this->Qnt >= 0 && $this->Amt >= 0) {
        $vSQL = 'UPDATE `str_sitem` SET'
                . ' `cqnt`="' . $this->Qnt . '"'
                . ',`camt`="' . $this->Amt . '"'
                . ' WHERE `id`="' . $this->Id . '"';
        $res = ph_ExecuteUpdate($vSQL);
        if ($res || $res === 0) {

        } else {
          $aMsg = ph_GetMySQLMessageAsArray();
          $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
          throw new Exception($vMsgs);
        }
      }
    }
  }

  public function subtractQnt($nQnt = 0, $nAmt = 0) {
    if ($this->Id > 0 && $nQnt != 0) {
      $this->Qnt = $this->Qnt - $nQnt;
      $this->Amt = $this->Amt - $nAmt;
      if ($this->Qnt >= 0 && $this->Amt >= 0) {
        $vSQL = 'UPDATE `str_sitem` SET'
                . ' `cqnt`="' . $this->Qnt . '"'
                . ',`camt`="' . $this->Amt . '"'
                . ' WHERE `id`="' . $this->Id . '"';
        $res = ph_ExecuteUpdate($vSQL);
        if ($res || $res === 0) {

        } else {
          $aMsg = ph_GetMySQLMessageAsArray();
          $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
          throw new Exception($vMsgs);
        }
      }
    }
  }

}
