<?php

class cStrStore {

  var $Id = -999;
  var $TypeId = 2;
  var $StatusId = 1;
  var $AccId = null;
  var $UserId = 1;
  var $SalesId = 1;
  var $IsOwned = 1;
  var $Num;
  var $Name;
  var $SDate;
  var $EDate;
  var $Address;
  var $Rem;
  var $oStatus;
  var $oType;
  var $oSales;
  var $oIsOnwed;
  var $oAcc;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT id, num, name, rem, address, isowned, type_id, sales_id, status_id, sdate, edate'
            . ' FROM str_store';
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

  public static function getArray($vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(cStrStore::getSelectStatement($vWhere, 'num, Id'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrStore::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrStore();
    $res = ph_Execute(cStrStore::getSelectStatement('(id = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrStore::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrStore();
    $cClass->Id = intval($res->fields("id"));
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->SalesId = intval($res->fields("sales_id"));
    $cClass->IsOwned = intval($res->fields("isowned"));
    $cClass->Num = $res->fields("num");
    $cClass->Name = $res->fields("name");
    $cClass->SDate = $res->fields("sdate");
    $cClass->EDate = $res->fields("edate");
    $cClass->Address = $res->fields("address");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $vSQL = '';
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO str_store (num, name, isowned, type_id'
              . ', status_id, sdate, edate, address, rem, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Num . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->IsOwned . '"'
              . ', "' . $this->TypeId . '"'
              . ', "' . $this->StatusId . '"'
              . ', STR_TO_DATE("' . $this->SDate . '","%Y-%m-%d")'
              . ', STR_TO_DATE("' . $this->EDate . '","%Y-%m-%d")'
              . ', "' . $this->Address . '"'
              . ', "' . $this->Rem . '"'
              . ', "' . $nUId . '"'
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
      $vSQL = 'UPDATE str_store SET'
              . '  num="' . $this->Num . '"'
              . ', name="' . $this->Name . '"'
              . ', type_id="' . $this->TypeId . '"'
              . ', status_id="' . $this->StatusId . '"'
              . ', isowned="' . $this->IsOwned . '"'
              . ', sdate=STR_TO_DATE("' . $this->SDate . '","%Y-%m-%d")'
              . ', edate=STR_TO_DATE("' . $this->EDate . '","%Y-%m-%d")'
              . ', address="' . $this->Address . '"'
              . ', rem="' . $this->Rem . '"'
              . ', `upd_user`="' . $nUId . '"'
              . ' WHERE id="' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
      if ($res || $res === 0) {
        $nId = $this->Id;
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM str_store WHERE id="' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public function updateQnt($nQnt = 0, $nAmt = 0) {
    if ($this->Id > 0 && $nQnt >= 0 && $nAmt >= 0) {
      $vSQL = 'UPDATE `str_sitem` SET'
              . ' `cqnt`="' . $nQnt . '"'
              . ',`camt`="' . $nAmt . '"'
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

  public function addQnt($nQnt = 0, $nAmt = 0) {
    if ($this->Id > 0 && $nQnt != 0) {
      $this->Qnt = $this->Qnt + $nQnt;
      $this->Amt = $this->Amt + $nAmt;
      // updateQnt($this->Qnt, $this->Amt);
    }
  }

  public function subtractQnt($nQnt = 0, $nAmt = 0) {
    if ($this->Id > 0 && $nQnt != 0) {
      $this->Qnt = $this->Qnt - $nQnt;
      $this->Amt = $this->Amt - $nAmt;
      // updateQnt($this->Qnt, $this->Amt);
    }
  }

}
