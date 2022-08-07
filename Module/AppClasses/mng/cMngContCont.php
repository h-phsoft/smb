<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.2.220201.1111
 *
 * @author Haytham
 * @version 2.0.2.220201.1111
 * @update 2022/02/01 12:37
 *
 */

class cMngContCont {

  var $Id;
  var $ContId;
  var $Name;
  var $Position;
  var $Mobile;
  var $Phone;
  var $Email;
  //
  var $oCont;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `cont_id`, `name`, `position`, `mobile`, `phone`, `email`'
      . ' FROM `mng_cont_cont`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `mng_cont_cont`';
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
    $res = ph_Execute(cMngContCont::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMngContCont::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cMngContCont();
    $res = ph_Execute(cMngContCont::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMngContCont::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cMngContCont();
    $cClass->Id = intval($res->fields('id'));
    $cClass->ContId = intval($res->fields('cont_id'));
    $cClass->Name = $res->fields('name');
    $cClass->Position = $res->fields('position');
    $cClass->Mobile = $res->fields('mobile');
    $cClass->Phone = $res->fields('phone');
    $cClass->Email = $res->fields('email');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `mng_cont_cont` ('
        . '  `cont_id`, `name`, `position`, `mobile`, `phone`, `email`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->ContId . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Position . '"'
        . ', "' . $this->Mobile . '"'
        . ', "' . $this->Phone . '"'
        . ', "' . $this->Email . '"'
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
      $vSQL = 'UPDATE `mng_cont_cont` SET'
        . '  `cont_id`="' . $this->ContId . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `position`="' . $this->Position . '"'
        . ', `mobile`="' . $this->Mobile . '"'
        . ', `phone`="' . $this->Phone . '"'
        . ', `email`="' . $this->Email . '"'
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
    $vSQL = 'DELETE FROM `mng_cont_cont` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
