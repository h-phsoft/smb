<?php

class cStrInTrn {

  var $Id = -999;
  var $MstId = -999;
  var $ItemId = 0;
  var $Qnt = 0;
  var $Price = 0;
  var $Amt = 0;
  var $Cst = 0;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT '
      . ' `mst_id`, `id`, `item_id`, `qnt`, `price`, `amt`, `cost`, `rem`'
      . 'FROM `str_intrn`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_intrn`';
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
      $vOrder = '`mst_id`, `id`';
    }
    $res = ph_Execute(cStrInTrn::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrInTrn::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrInTrn();
    $res = ph_Execute(cStrInTrn::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrInTrn::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrInTrn();
    $cClass->Id = intval($res->fields("trn_id"));
    $cClass->MstId = intval($res->fields("mst_id"));
    $cClass->ItemId = intval($res->fields("item_id"));
    $cClass->Qnt = $res->fields("qnt");
    $cClass->Price = $res->fields("price");
    $cClass->Amt = $res->fields("amt");
    $cClass->Cst = $res->fields("cst");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_intrn` ('
        . ' `mst_id`, `item_id`, `qnt`, `price`, `amt`, `cost`, `rem`, `ins_user`'
        . ') VALUES ('
        . ' "' . $this->MstId . '"'
        . ',"' . $this->ItemId . '"'
        . ',"' . $this->Qnt . '"'
        . ',"' . $this->Price . '"'
        . ',"' . $this->Amt . '"'
        . ',"' . $this->Amt . '"'
        . ',"' . $this->Rem . '"'
        . ',"' . $nUId . '"'
        . ')';
      $res = ph_ExecuteInsert($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $vSQL = 'UPDATE `str_intrn` SET'
        . ' `mst_id`="' . $this->MstId . '"'
        . ',`item_id`="' . $this->ItemId . '"'
        . ',`qnt`="' . $this->Qnt . '"'
        . ',`price`="' . $this->Price . '"'
        . ',`amt`="' . $this->Amt . '"'
        . ',`rem`="' . $this->Rem . '"'
        . ',`upd_user`="' . $nUId . '"'
        . ' WHERE `id`="' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
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
    $vSQL = 'DELETE FROM `str_intrn` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
