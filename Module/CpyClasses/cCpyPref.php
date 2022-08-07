<?php

class cCpyPref {

  var $Id = -999;
  var $Key = '';
  var $Name = '';
  var $Value = '';
  var $Rem = '';
  public static $Prefs = array();

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `key`, `name`, `value`, `rem`'
            . ' FROM `cpy_pref`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `cpy_pref`';
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
    $res = ph_Execute(self::getSelectStatement($vWhere, $vOrder, $vLimit));
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
    $cClass = new cCpyPref();
    $sSQL = 'SELECT `id`, `key`, `name`, `value`, `rem`'
            . ' FROM `cpy_pref`'
            . ' WHERE (`id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByKey($sKey) {
    $cClass = new cCpyPref();
    $sSQL = 'SELECT `id`, `key`, `name`, `value`, `rem`'
            . ' FROM `cpy_pref`'
            . ' WHERE (UPPER(`key`)=UPPER("' . $sKey . '"))';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyPref();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Key = $res->fields("key");
    $cClass->Name = $res->fields("name");
    $cClass->Value = $res->fields("value");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `cpy_pref`('
              . '  `key`, `name`, `value`, `rem`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Key . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Value . '"'
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
      $vSQL = 'UPDATE `cpy_pref` SET'
              . '  `key`="' . $this->Key . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `value`="' . $this->Value . '"'
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
    $vSQL = 'DELETE FROM `cpy_pref` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public static function getDBKeys() {
    self::$Prefs = self::loadDBKeys();
  }

  public static function loadDBKeys() {
    $keys = array();
    $sSQL = 'SELECT `id`, `key`, `name`, `value`, `rem`'
            . ' FROM `cpy_pref`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $keys[strtoupper($res->fields("key"))] = $res->fields("value");
        $res->MoveNext();
      }
      $res->Close();
    }
    return $keys;
  }

  // Get DB Keys Value from Array
  public static function getPref($sKey) {
    $sUKey = strtoupper($sKey);
    $sRetVar = $sKey;
    if (!isset(self::$Prefs)) {
      self::$Prefs = self::loadDBKeys();
    }
    if (array_key_exists($sUKey, self::$Prefs)) {
      $sRetVar = self::$Prefs[$sUKey];
    } else {
      $sRetVar = self::getPrefValue($sKey);
      if ($sRetVar == "") {
        $sRetVar = $sKey;
      }
    }
    return $sRetVar;
  }

  public static function isPref($sKey) {
    $vRetVar = strtolower(trim(self::getPref($sKey)));
    return (($vRetVar === 'true') || ($vRetVar === true) || ($vRetVar === 1) || ($vRetVar === '1'));
  }

  public static function getPrefValue($sKey) {
    $sRetVar = ph_GetDBValue('value', 'cpy_pref', '(UPPER(`key`)=UPPER("' . $sKey . '"))');
    if ($sRetVar == '') {
      $sRetVar = $sKey;
    }
    return $sRetVar;
  }

  public static function setPrefValue($sKey, $vValue) {
    $sSQL = 'UPDATE `cpy_pref` SET `value`="' . $vValue . '" WHERE (UPPER(`key`)=UPPER("' . $sKey . '"))';
    $res = ph_Execute($sSQL);
    return $res;
  }

}
