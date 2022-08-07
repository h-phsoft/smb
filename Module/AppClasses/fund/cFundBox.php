<?php

class cFundBox {

  var $Id = -999;
  var $UserId;
  var $UserName;
  var $UserLogon;
  var $StatusId;
  var $StatusName;
  var $AccId;
  var $AccNum;
  var $AccName;
  var $Name;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `box_id`, `box_name`, `box_rem`,'
      . '`user_id`, `user_logon`, `user_name`,'
      . '`acc_id`, `acc_num`, `acc_name`,'
      . '`status_id`, `status_name`'
      . ' FROM `fund_vbox`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `fund_vbox`';
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
      $vOrder = '`box_name`';
    }
    $res = ph_Execute(cFundBox::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cFundBox::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cFundBox();
    $res = ph_Execute(cFundBox::getSelectStatement('(`box_id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cFundBox::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cFundBox();
    $cClass->Id = intval($res->fields("box_id"));
    $cClass->UserId = intval($res->fields("user_id"));
    $cClass->UserLogon = $res->fields("user_logon");
    $cClass->UserName = $res->fields("user_name");
    $cClass->AccId = intval($res->fields("acc_id"));
    $cClass->AccNum = $res->fields("acc_num");
    $cClass->AccName = $res->fields("acc_name");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->StatusName = $res->fields("status_name");
    $cClass->Name = $res->fields("box_name");
    $cClass->Rem = $res->fields("box_rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `fund_box` (`name`, `user_id`, `acc_id`, `status_id`, `rem`, `ins_user`'
        . ') VALUES ('
        . ' "' . $this->Name . '"'
        . ',"' . $this->UserId . '"'
        . ',"' . $this->AccId . '"'
        . ',"' . $this->StatusId . '"'
        . ',"' . $this->Rem . '"'
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
      $nId = $this->Id;
      $vSQL = 'UPDATE `fund_box` SET'
        . ' `name`="' . $this->Name . '"'
        . ',`user_id`="' . $this->UserId . '"'
        . ',`acc_id`="' . $this->AccId . '"'
        . ',`status_id`="' . $this->StatusId . '"'
        . ',`rem`="' . $this->Rem . '"'
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
      $vSQL = 'DELETE FROM `fund_box` WHERE `id` = "' . $this->Id . '"';
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
