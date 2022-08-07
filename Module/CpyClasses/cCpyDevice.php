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

class cCpyDevice {

  var $Id = -999;
  var $Name;
  var $Guid;
  var $StatusId = 2;
  var $SHour;
  var $SMinute;
  var $SMinutes;
  var $EHour;
  var $EMinute;
  var $EMinutes;
  var $Day1;
  var $Day2;
  var $Day3;
  var $Day4;
  var $Day5;
  var $Day6;
  var $Day7;
  var $AddedAt;
  //
  var $oStatus;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `name`, `guid`, `status_id`, `shour`, `sminute`, `ehour`'
            . ', `eminute`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `added_at`'
            . ' FROM `cpy_device`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `cpy_device`';
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
    $cClass = new cCpyDevice();
    $res = ph_Execute(self::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByGId($vGId) {
    $cClass = new cCpyDevice();
    $res = ph_Execute(self::getSelectStatement('(`guid`="' . $vGId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyDevice();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Name = $res->fields('name');
    $cClass->Guid = $res->fields('guid');
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->SHour = intval($res->fields('shour'));
    $cClass->SMinute = intval($res->fields('sminute'));
    $cClass->EHour = intval($res->fields('ehour'));
    $cClass->EMinute = intval($res->fields('eminute'));
    $cClass->Day1 = intval($res->fields('day1'));
    $cClass->Day2 = intval($res->fields('day2'));
    $cClass->Day3 = intval($res->fields('day3'));
    $cClass->Day4 = intval($res->fields('day4'));
    $cClass->Day5 = intval($res->fields('day5'));
    $cClass->Day6 = intval($res->fields('day6'));
    $cClass->Day7 = intval($res->fields('day7'));
    $cClass->AddedAt = intval($res->fields('added_at'));
    $cClass->SMinutes = ($cClass->SHour * 60) + $cClass->SMinute;
    $cClass->EMinutes = ($cClass->EHour * 60) + $cClass->EMinute;
    //
    $cClass->oDay1 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day1);
    $cClass->oDay2 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day2);
    $cClass->oDay3 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day3);
    $cClass->oDay4 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day4);
    $cClass->oDay5 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day5);
    $cClass->oDay6 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day6);
    $cClass->oDay7 = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->Day7);
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `cpy_device` ('
              . '  `name`, `guid`, `status_id`, `shour`, `sminute`, `ehour`, `eminute`'
              . ', `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Name . '"'
              . ', "' . $this->Guid . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->SHour . '"'
              . ', "' . $this->SMinute . '"'
              . ', "' . $this->EHour . '"'
              . ', "' . $this->EMinute . '"'
              . ', "' . $this->Day1 . '"'
              . ', "' . $this->Day2 . '"'
              . ', "' . $this->Day3 . '"'
              . ', "' . $this->Day4 . '"'
              . ', "' . $this->Day5 . '"'
              . ', "' . $this->Day6 . '"'
              . ', "' . $this->Day7 . '"'
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
      $vSQL = 'UPDATE `cpy_device` SET'
              . '  `name`="' . $this->Name . '"'
              . ', `guid`="' . $this->Guid . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `shour`="' . $this->SHour . '"'
              . ', `sminute`="' . $this->SMinute . '"'
              . ', `ehour`="' . $this->EHour . '"'
              . ', `eminute`="' . $this->EMinute . '"'
              . ', `day1`="' . $this->Day1 . '"'
              . ', `day2`="' . $this->Day2 . '"'
              . ', `day3`="' . $this->Day3 . '"'
              . ', `day4`="' . $this->Day4 . '"'
              . ', `day5`="' . $this->Day5 . '"'
              . ', `day6`="' . $this->Day6 . '"'
              . ', `day7`="' . $this->Day7 . '"'
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
    $vSQL = 'DELETE FROM `cpy_device` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public function enable() {
    $vSQL = 'UPDATE `cpy_device` SET `status_id`=1 WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public function disable() {
    $vSQL = 'UPDATE `cpy_device` SET `status_id`=0 WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public function isAvailable($dDatetime = '') {
    $bStatus = false;
    if ($dDatetime == '' || $dDatetime == null) {
      $dDatetime = date('Y-m-d H:i:s');
    }
    $dayStatus = 2;
    switch (date('w', strtotime($dDatetime))) {
      case 0:
        $dayStatus = $this->Day1;
        break;
      case 1:
        $dayStatus = $this->Day2;
        break;
      case 2:
        $dayStatus = $this->Day3;
        break;
      case 3:
        $dayStatus = $this->Day4;
        break;
      case 4:
        $dayStatus = $this->Day5;
        break;
      case 5:
        $dayStatus = $this->Day6;
        break;
      case 6:
        $dayStatus = $this->Day7;
        break;
    }
    if ($dayStatus == 1) {
      $nCurrHM = (date('H', strtotime($dDatetime)) * 60) + date('i', strtotime($dDatetime));
      if ($nCurrHM >= ($this->SMinutes) && $nCurrHM <= ($this->EMinutes)) {
        $bStatus = true;
      }
    }
    return $bStatus;
  }

}
