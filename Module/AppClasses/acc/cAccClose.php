<?php

class cAccClose {

  var $Id = -999;
  var $Ord;
  var $Name;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id` , `ord`, `name`, `rem`'
      . ' FROM `acc_close`';
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
    $res = ph_Execute(cAccClose::getSelectStatement($vWhere, '`ord`, `Id`'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccClose::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccClose();
    $res = ph_Execute(cAccClose::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccClose::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccClose();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Ord = $res->fields("ord");
    $cClass->Name = $res->fields("name");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = $this->Id;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `acc_close` (`ord`, `name`, `rem`, `ins_user`)'
        . ' VALUES ("' . $this->Ord . '"'
        . ', "' . $this->Name . '"'
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
      $vSQL = 'UPDATE `acc_close` SET'
        . ' `ord`="' . $this->Ord . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `rem`="' . $this->Rem . '"'
        . ', `upd_user`="' . $nUId . '"'
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
    if ($this->Id > 0) {
      $vSQL = 'DELETE FROM `acc_close` WHERE `id` = "' . $this->Id . '"';
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
