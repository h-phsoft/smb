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

class cClncAppType {

  var $Id;
  var $Name;
  var $Capacity = 0;
  var $Time = 15;
  var $TbgId = 0;
  var $TfgId = 0;
  var $NfgId = 0;
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  //
  var $oNfg;
  var $oTbg;
  var $oTfg;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `name`, `capacity`, `time`, `tbg_id`, `tfg_id`, `nfg_id`'
            . ', `ins_user`, `ins_date`, `upd_user`, `upd_date`'
            . ' FROM `clnc_app_type`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_app_type`';
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
    $cClass = new cClncAppType();
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
    $cClass = new cClncAppType();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Name = $res->fields('name');
    $cClass->Capacity = intval($res->fields('capacity'));
    $cClass->Time = intval($res->fields('time'));
    $cClass->TbgId = intval($res->fields('tbg_id'));
    $cClass->TfgId = intval($res->fields('tfg_id'));
    $cClass->NfgId = intval($res->fields('nfg_id'));
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oNfg = cPhsCodColor::getInstance($cClass->NfgId);
    $cClass->oTbg = cPhsCodColor::getInstance($cClass->TbgId);
    $cClass->oTfg = cPhsCodColor::getInstance($cClass->TfgId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_app_type` ('
              . '  `name`, `capacity`, `time`, `tbg_id`, `tfg_id`, `nfg_id`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Name . '"'
              . ', "' . $this->Capacity . '"'
              . ', "' . $this->Time . '"'
              . ', "' . $this->TbgId . '"'
              . ', "' . $this->TfgId . '"'
              . ', "' . $this->NfgId . '"'
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
      $vSQL = 'UPDATE `clnc_app_type` SET'
              . '  `name`="' . $this->Name . '"'
              . ', `capacity`="' . $this->Capacity . '"'
              . ', `time`="' . $this->Time . '"'
              . ', `tbg_id`="' . $this->TbgId . '"'
              . ', `tfg_id`="' . $this->TfgId . '"'
              . ', `nfg_id`="' . $this->NfgId . '"'
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
    $vSQL = 'DELETE FROM `clnc_app_type` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
