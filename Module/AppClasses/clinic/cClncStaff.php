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
 * @update 2022/05/07 22:18
 *
 */

class cClncStaff {

  var $Id;
  var $TypeId = 2;
  var $GrpId = 2;
  var $StatusId = 1;
  var $GenderId = 1;
  var $SpecialId = 1;
  var $Name;
  var $Username;
  var $Password;
  var $Rem;
  var $Image;
  //
  var $oSpecial;
  var $oGender;
  var $oStatus;
  var $oType;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `type_id`, `grp_id`, `status_id`, `gender_id`, `special_id`, `name`'
      . ', `username`, `password`, `rem`, `image`'
      . ' FROM `clnc_staff`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_staff`';
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
    $cClass = new cClncStaff();
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
    $cClass = new cClncStaff();
    $cClass->Id = intval($res->fields('id'));
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->GrpId = intval($res->fields('grp_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->GenderId = intval($res->fields('gender_id'));
    $cClass->SpecialId = intval($res->fields('special_id'));
    $cClass->Name = $res->fields('name');
    $cClass->Username = $res->fields('username');
    $cClass->Password = $res->fields('password');
    $cClass->Rem = $res->fields('rem');
    $cClass->Image = $res->fields('image');
    //
    $cClass->oSpecial = cClncSpecial::getInstance($cClass->SpecialId);
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oGender = cPhsCode::getInstance(cPhsCode::GENDER, $cClass->GenderId);
    $cClass->oType = cCpyUserType::getInstance($cClass->TypeId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_staff` ('
        . '  `type_id`, `grp_id`, `status_id`, `gender_id`, `special_id`, `name`, `username`'
        . ', `password`, `rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->TypeId . '"'
        . ', "' . $this->GrpId . '"'
        . ', "' . $this->StatusId . '"'
        . ', "' . $this->GenderId . '"'
        . ', "' . $this->SpecialId . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Username . '"'
        . ', "' . ph_EncodePassword($this->Password) . '"'
        . ', "' . $this->Rem . '"'
        // . ', "' . $this->Image . '"'
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
      $vSQL = 'UPDATE `clnc_staff` SET'
        . '  `type_id`="' . $this->TypeId . '"'
        . ', `grp_id`="' . $this->GrpId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `gender_id`="' . $this->GenderId . '"'
        . ', `special_id`="' . $this->SpecialId . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `username`="' . $this->Username . '"'
        // . ', `password`="' .  ph_EncodePassword($this->Password)  . '"'
        . ', `rem`="' . $this->Rem . '"'
        // . ', `image`="' . $this->Image . '"'
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
    $vSQL = 'DELETE FROM `clnc_staff` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {
    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public function resetPassword($vNPassword, $vVPassword) {
    $bResult = false;
    if ($vNPassword === $vVPassword) {
      $sSQL = 'UPDATE `clnc_staff` SET `password`="' . ph_EncodePassword($vNPassword) . '"'
        . ' WHERE (`id`=' . $this->Id . ')';
      ph_Execute($sSQL);
      $bResult = true;
    }
    return $bResult;
  }
}
