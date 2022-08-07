<?php

class cCpyWPeriod {

  var $Id = -999;
  var $StatusId = 1;
  var $Order = 0;
  var $Name = 'Open Period';
  var $SDate = '01-01-1900';
  var $Edate = '31-12-2099';
  var $Rem = 'Default Period';

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT id, status_id, name, ord, sdate, edate, rem'
            . ' FROM cpy_wperiod';
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
    $res = ph_Execute(self::getSelectStatement($vWhere, 'ord, Id'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = self::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cCpyWPeriod();
    $res = ph_Execute(self::getSelectStatement('(id="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByLogon($vLogon) {
    $cClass = new cCpyWPeriod();
    $res = ph_Execute(self::getSelectStatement('(logon="' . $vLogon . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function checkUserLogin($vLogon, $vPassword) {
    $cClass = new cCpyWPeriod();
    $res = ph_Execute(self::getSelectStatement('(status_id=1) AND (logon="' . $vLogon . '") AND (password="' . $vPassword . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyWPeriod();
    $cClass->Id = intval($res->fields("id"));
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->Name = $res->fields("name");
    $cClass->Order = $res->fields("ord");
    $cClass->SDate = $res->fields("sdate");
    $cClass->EDate = $res->fields("edate");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = $this->Id;
    $vSQL = '';
    if ($this->Id == 0 || $this->Id == -999) {
      $this->Id = ph_GetDBValue('(max(`id`)+1)', 'cpy_perm_grp');
      $vSQL = 'INSERT INTO cpy_wperiod (id, status_id, name, ord, sdate, edate, rem, `ins_user`'
              . ') VALUES ("' . $this->Id . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Order . '"'
              . ', STR_TO_DATE("' . $this->SDate . '","%Y-%m-%d")'
              . ', STR_TO_DATE("' . $this->EDate . '","%Y-%m-%d")'
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
      $vSQL = 'UPDATE cpy_wperiod SET'
              . '  status_id="' . $this->StatusId . '"'
              . ', name="' . $this->Name . '"'
              . ', ord="' . $this->Order . '"'
              . ', sdate=STR_TO_DATE("' . $this->SDate . '","%Y-%m-%d")'
              . ', edate=STR_TO_DATE("' . $this->EDate . '","%Y-%m-%d")'
              . ', rem="' . $this->Rem . '"'
              . ', `upd_user`="' . $nUId . '"'
              . ' WHERE id="' . $this->Id . '"';
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
    $vSQL = 'DELETE FROM cpy_wperiod WHERE id="' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
