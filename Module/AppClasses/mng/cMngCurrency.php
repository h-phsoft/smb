<?php

class cMngCurrency {

  var $Id = -999;
  var $Num;
  var $Name;
  var $Code;
  var $Color;
  var $Rate;
  var $Date;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `num`, `name`, `code`, `rate`, `color`, `date`, `rem`'
      . ' FROM `mng_curn`';
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
    $res = ph_Execute(cMngCurrency::getSelectStatement($vWhere, '`num`, `Id`'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMngCurrency::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cMngCurrency();
    $res = ph_Execute(cMngCurrency::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMngCurrency::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cMngCurrency();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Num = $res->fields("num");
    $cClass->Name = $res->fields("name");
    $cClass->Code = $res->fields("code");
    $cClass->Color = $res->fields("color");
    $cClass->Rate = floatval($res->fields("rate"));
    $cClass->Date = $res->fields("date");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $vSQL = '';
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `mng_curn` (`num`, `name`, `code`, `color`, `rate`, `rem`, `ins_user`'
        . ') VALUES ("' . $this->Num . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Code . '"'
        . ', "' . $this->Color . '"'
        . ', "' . $this->Rate . '"'
        . ', "' . $this->Rem . '"'
        . ', "' . $nUId . '"'
        . ')';
      $res = ph_ExecuteInsert($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $vSQL = 'UPDATE `mng_curn` SET'
        . '  `num`="' . $this->Num . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `code`="' . $this->Code . '"'
        . ', `color`="' . $this->Color . '"'
        . ', `rate`="' . $this->Rate . '"'
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
  }

  public function delete() {
    $vSQL = 'DELETE FROM `mng_curn` WHERE `id`="' . $this->Id . '"';
    ph_Execute($vSQL);
  }

  public function updateRate($nUId, $dDate) {
    if ($dDate === '') {
      $dDate = date('Y-m-d');
    }
    $res = 0;
    if (ph_FormatDate($dDate, 'Y-m-d') >= ph_FormatDate($this->Date, 'Y-m-d')) {
      $this->Date = $dDate;
      $vSQL = 'UPDATE `mng_curn` SET'
        . ' `rate`="' . $this->Rate . '"'
        . ', `date`=STR_TO_DATE("' . $dDate . '","%Y-%m-%d")'
        . ', `upd_user`="' . $nUId . '"'
        . ' WHERE `id`="' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
      $vSQL = 'INSERT INTO `mng_curn_rate` (`curn_id`, `date`, `rate`, `min`, `max`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->Id . '"'
        . ', STR_TO_DATE("' . $dDate . '","%Y-%m-%d")'
        . ', "' . $this->Rate . '"'
        . ', "' . $this->Rate . '"'
        . ', "' . $this->Rate . '"'
        . ', "' . $nUId . '"'
        . ')';
      ph_ExecuteInsert($vSQL);
    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
