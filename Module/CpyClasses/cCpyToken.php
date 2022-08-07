<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate MySQL Database tables Classes
 * PhGenDBClasses
 * 1.0.0.210930.1850
 *
 * at : ????/??/?? ??:??:??
 *
 * @author Haytham
 * @version 1.0.0.210930.1850
 * @update ????/??/?? ??:??
 *
 */

class cCpyToken {

  var $Id = -999;
  var $Gid;
  var $UserId = -9;
  var $StatusId = 2;
  var $DeviceId = -9;
  var $Sdate;
  var $Edate;
  var $Adate;
  var $Pvkey;
  var $Pbkey;
  var $Ip;
  var $Port;
  var $Host;
  //
  var $oStatus;
  var $oDevice;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `gid`, `user_id`, `status_id`, `device_id`, `sdate`'
            . ', `edate`, `adate`, `pvkey`, `pbkey`, `ip`, `port`, `host`'
            . ' FROM `cpy_token`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `cpy_token`';
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
    $cClass = new cCpyToken();
    $res = ph_Execute(self::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByGUID($vGId) {
    $cClass = new cCpyToken();
    $res = ph_Execute(self::getSelectStatement('(`gid`="' . $vGId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getNewInstance($remoteAddr, $vAge = ' +365 day', $nUserId = -9, $nDeviceId = -9) {
    $cClass = new cCpyToken();
    $cClass->Id = 0;
    $cClass->Gid = self::getPhGUID();
    $cClass->Sdate = date('Y-m-d H:i:s');
    $cClass->Edate = date('Y-m-d H:i:s', strtotime($cClass->Sdate . $vAge));
    $cClass->Adate = date('Y-m-d H:i:s');
    $cClass->StatusId = 1;
    $cClass->UserId = $nUserId;
    $cClass->DeviceId = $nDeviceId;
    $cClass->Pvkey = '';
    $cClass->Pbkey = '';
    $cClass->Ip = '';
    $cClass->Port = '';
    $cClass->Host = $remoteAddr;
    //
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oDevice = cCpyDevice::getInstance($cClass->DeviceId);
    $cClass->Id = $cClass->save($nUserId);
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyToken();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Gid = $res->fields('gid');
    $cClass->UserId = intval($res->fields('user_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->DeviceId = intval($res->fields('device_id'));
    $cClass->Sdate = $res->fields('sdate');
    $cClass->Edate = $res->fields('edate');
    $cClass->Adate = $res->fields('adate');
    $cClass->Pvkey = $res->fields('pvkey');
    $cClass->Pbkey = $res->fields('pbkey');
    $cClass->Ip = $res->fields('ip');
    $cClass->Port = $res->fields('port');
    $cClass->Host = $res->fields('host');
    //
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oDevice = cCpyDevice::getInstance($cClass->DeviceId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `cpy_token` ('
              . '  `gid`, `user_id`, `status_id`, `device_id`'
              . ', `sdate`, `edate`, `adate`, `pvkey`, `pbkey`, `ip`, `port`, `host`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Gid . '"'
              . ', "' . $this->UserId . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->DeviceId . '"'
              . ', "' . $this->Sdate . '"'
              . ', "' . $this->Edate . '"'
              . ', "' . $this->Adate . '"'
              . ', "' . $this->Pvkey . '"'
              . ', "' . $this->Pbkey . '"'
              . ', "' . $this->Ip . '"'
              . ', "' . $this->Port . '"'
              . ', "' . $this->Host . '"'
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
      $vSQL = 'UPDATE `cpy_token` SET'
              . '  `gid`="' . $this->Gid . '"'
              . ', `user_id`="' . $this->UserId . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `device_id`="' . $this->DeviceId . '"'
              . ', `sdate`="' . $this->Sdate . '"'
              . ', `edate`="' . $this->Edate . '"'
              . ', `adate`="' . $this->Adate . '"'
              . ', `pvkey`="' . $this->Pvkey . '"'
              . ', `pbkey`="' . $this->Pbkey . '"'
              . ', `ip`="' . $this->Ip . '"'
              . ', `port`="' . $this->Port . '"'
              . ', `host`="' . $this->Host . '"'
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
    $vSQL = 'DELETE FROM `cpy_token` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public static function deleteExpired() {
    $vSQL = 'DELETE FROM `cpy_token` WHERE `edate`<"' . date('Y-m-d H:i:s') . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public static function getPhGUID() {
    //mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
    $charid = strtolower(md5(uniqid(rand(), true)));
    $vGUID = substr($charid, 0, 8)
            . substr($charid, 8, 4)
            . substr($charid, 12, 4)
            . substr($charid, 16, 4)
            . substr($charid, 20, 12);
    return $vGUID;
  }

  public static function getGUID() {
    $vGUID = '';
    //mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45); // "-"
    $vGUID = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
    return $vGUID;
  }

}
