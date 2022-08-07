<?php

class cCpyPGrp {

  var $Id = -999;
  var $Name = '';
  var $WPStatusId = 2;
  var $aPerms = array();

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `name`, `wpstatus_id`'
            . ' FROM `cpy_perm_grp`';
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
    $vWhere0 = '(`id`>0)';
    if ($vWhere != '') {
      $vWhere0 .= ' AND (' . $vWhere . ')';
    }
    $res = ph_Execute(self::getSelectStatement($vWhere0, '`Name`'));
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
    $cClass = new cCpyPGrp();
    $res = ph_Execute(self::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyPGrp();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Name = $res->fields("name");
    $cClass->WPStatusId = $res->fields("wpstatus_id");
    $cClass->aPerms = cCpyPerm::getGroupPermissions('p.`grp_id`="' . $cClass->Id . '"');
    return $cClass;
  }

  public function getPermission($progId) {
    $cClass = new cCpyPerm();
    if ($this->Id > 0) {
      foreach ($this->aPerms as $perm) {
        if ($perm->ProgId === intval($progId)) {
          $cClass = $perm;
          break;
        }
      }
    } else {
      $cClass->OK = 1;
      $cClass->Ins = 1;
      $cClass->Upd = 1;
      $cClass->Del = 1;
      $cClass->Qry = 1;
      $cClass->Prt = 1;
      $cClass->Exp = 1;
      $cClass->Imp = 1;
      $cClass->Cmt = 1;
      $cClass->Rvk = 1;
      $cClass->Spc = 1;
      $cClass->isOK = true;
      $cClass->Insert = true;
      $cClass->Update = true;
      $cClass->Delete = true;
      $cClass->Query = true;
      $cClass->Print = true;
      $cClass->Import = true;
      $cClass->Export = true;
      $cClass->Commit = true;
      $cClass->Revoke = true;
      $cClass->Special = true;
    }
    return $cClass;
  }

  public function save($nUId) {
    $nId = $this->Id;
    $vSQL = '';
    if ($this->Id == 0 || $this->Id == -999) {
      $this->Id = ph_GetDBValue('(max(`id`)+1)', 'cpy_perm_grp');
      $vSQL = 'INSERT INTO `cpy_perm_grp`'
              . ' (`id`, `name`, `ins_user`'
              . ') VALUES ("' . $this->Id . '"'
              . ', "' . $this->Name . '"'
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
      $vSQL = 'UPDATE `cpy_perm_grp` SET'
              . '  `name`="' . $this->Name . '"'
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
    $vSQL = 'DELETE FROM `cpy_perm` WHERE `grp_id`="' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
    $vSQL = 'DELETE FROM `cpy_perm_grp` WHERE `id`="' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
