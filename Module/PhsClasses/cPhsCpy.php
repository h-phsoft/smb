<?php

class cPhsCpy {

  var $Id = -999;
  var $CustId = 0;
  var $StatusId = 2;
  var $Order = 0;
  var $Users = 0;
  var $Devices = 0;
  var $Restriction = 0;
  var $GId = '';
  var $Name = '';
  var $URL = '';
  var $dbName = '';
  var $SDate = '';
  var $EDate = '';
  var $Rem = '';

  public static function getSelectStatement($vWhere = '', $vOrder = '') {
    $sSQL = 'SELECT `id`, `gid`, `cust_id`, `status_id`,'
            . ' `ord`, `name`, `url`, `dbname`, `sdate`, `edate`,'
            . ' `users`, `devices`, `restriction`, `rem`'
            . ' FROM ' . PHS_SMB_ADMIN_FULL . '`phs_cpy`'
            . ' WHERE (`status_id`=1)';
    if ($vWhere != '') {
      $sSQL .= ' AND (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $vOrder = ' ORDER BY ' . $vOrder;
    }
    $sSQL .= $vOrder;
    return $sSQL;
  }

  public static function getArray($vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(self::getSelectStatement($vWhere, 'ord'));
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

  public static function getInstanceById($nId) {
    $cClass = new cPhsCpy();
    $cClass->SDate = new Date();
    $cClass->EDate = ((new Date('Y')) + 1) . '01-01';
    $res = ph_Execute(self::getSelectStatement('(id="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByURL($vURL) {
    $cClass = new cPhsCpy();
    $res = ph_Execute(self::getSelectStatement('(UPPER(url)=UPPER("' . $vURL . '"))'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByGId($vGId) {
    $cClass = new cPhsCpy();
    $res = ph_Execute(self::getSelectStatement('(gid="' . $vGId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cPhsCpy();
    $cClass->Id = intval($res->fields("id"));
    $cClass->CustId = $res->fields("cust_id");
    $cClass->StatusId = $res->fields("status_id");
    $cClass->Users = $res->fields("users");
    $cClass->Devices = $res->fields("devices");
    $cClass->Restriction = $res->fields("restriction");
    $cClass->Order = $res->fields("ord");
    $cClass->GId = $res->fields("gid");
    $cClass->Name = $res->fields("name");
    $cClass->URL = $res->fields("url");
    $cClass->dbName = $res->fields("dbname");
    $cClass->SDate = $res->fields("sdate");
    $cClass->EDate = $res->fields("edate");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save() {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO ' . PHS_SMB_ADMIN_FULL . '`phs_cpy`'
              . ' (`cust_id`, `status_id`, `users`, `devices`, `restriction`, `ord`, `gid`,'
              . ' `name`, `url`, `dbname`, `sdate`, `edate`, `rem`)'
              . ' VALUES ("' . $this->CustId . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->Users . '"'
              . ', "' . $this->Devices . '"'
              . ', "' . $this->Restriction . '"'
              . ', "' . $this->Order . '"'
              . ', "' . $this->GId . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->URL . '"'
              . ', "' . $this->dbName . '"'
              . ', "' . $this->SDate . '"'
              . ', "' . $this->EDate . '"'
              . ', "' . $this->Rem . '"'
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
      $vSQL = 'UPDATE ' . PHS_SMB_ADMIN_FULL . '`phs_cpy` SET'
              . '  cust_id="' . $this->CustId . '"'
              . ', status_id"' . $this->StatusId . '"'
              . ', ord="' . $this->Order . '"'
              . ', users="' . $this->Users . '"'
              . ', devices="' . $this->Devices . '"'
              . ', restriction="' . $this->Restriction . '"'
              . ', gid="' . $this->GId . '"'
              . ', name="' . $this->Name . '"'
              . ', url="' . $this->URL . '"'
              . ', dbname="' . $this->dbName . '"'
              . ', sdate="' . $this->SDate . '"'
              . ', edate="' . $this->EDate . '"'
              . ', rem="' . $this->Rem . '"'
              . ' WHERE id = "' . $this->Id . '"';
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
    $vSQL = 'DELETE FROM ' . PHS_SMB_ADMIN_FULL . '`phs_cpy`'
            . ' WHERE id = "' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
