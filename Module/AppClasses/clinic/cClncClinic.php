<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.22.220220.2202
 * 
 * @author Haytham
 * @version 2.0.22.220220.2202
 * @update 2022/04/25 22:08
 *
 */

class cClncClinic {

  var $Id;
  var $StatusId = 1;
  var $Name;
  var $Prefix;
  var $Email = 'NULL';
  var $Phone1 = 'NULL';
  var $Phone2 = 'NULL';
  var $Phone3 = 'NULL';
  var $Address = 'NULL';
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  // 
  var $oStatus; 

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `status_id`, `name`, `prefix`, `email`, `phone1`, `phone2`'
      . ', `phone3`, `address`, `ins_user`, `ins_date`, `upd_user`, `upd_date`'
      . ' FROM `clnc_clinic`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_clinic`';
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

  public static function getInstance($nId) {
    $cClass = new cClncClinic();
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
    $cClass = new cClncClinic();
    $cClass->Id = intval($res->fields('id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->Name = $res->fields('name');
    $cClass->Prefix = $res->fields('prefix');
    $cClass->Email = $res->fields('email');
    $cClass->Phone1 = $res->fields('phone1');
    $cClass->Phone2 = $res->fields('phone2');
    $cClass->Phone3 = $res->fields('phone3');
    $cClass->Address = $res->fields('address');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    // 
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId); 
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_clinic` ('
        . '  `status_id`, `name`, `prefix`, `email`, `phone1`, `phone2`, `phone3`'
        . ', `address`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->StatusId . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Prefix . '"'
        . ', "' . $this->Email . '"'
        . ', "' . $this->Phone1 . '"'
        . ', "' . $this->Phone2 . '"'
        . ', "' . $this->Phone3 . '"'
        . ', "' . $this->Address . '"' 
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
      $vSQL = 'UPDATE `clnc_clinic` SET'
        . '  `status_id`="' . $this->StatusId . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `prefix`="' . $this->Prefix . '"'
        . ', `email`="' . $this->Email . '"'
        . ', `phone1`="' . $this->Phone1 . '"'
        . ', `phone2`="' . $this->Phone2 . '"'
        . ', `phone3`="' . $this->Phone3 . '"'
        . ', `address`="' . $this->Address . '"' 
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
    $vSQL = 'DELETE FROM `clnc_clinic` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

