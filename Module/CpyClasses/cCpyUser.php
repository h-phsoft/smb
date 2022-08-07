<?php

class cCpyUser {

  var $Id = -999;
  var $rId = -999;
  var $TypeId = 1;
  var $TypeName = '';
  var $GrpId = 1;
  var $GrpName = '';
  var $StatusId = 1;
  var $StatusName = '';
  var $GenderId = 1;
  var $GenderName = '';
  var $SpecialId = 1;
  var $SpecialName = '';
  var $Name;
  var $Logon;
  var $Password;
  var $Image = 'avatar1_256.png';
  var $FullImage = 'avatars/avatar1_256.png';
  var $oGrp = null;
  var $oStatus = null;
  var $oGender = null;
  var $oSpecial = null;
  var $aClinicIds = array();
  var $aClinics = array();

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `rid`,'
            . ' `type_id`, `type_name`,'
            . ' `grp_id`, `grp_name`,'
            . ' `status_id`, `status_name`,'
            . ' `gender_id`, `gender_name`,'
            . ' `special_id`, `special_name`,'
            . ' `name`, `logon`, `password`, `rem`, `image`'
            . ' FROM `cpy_vuser`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `cpy_vuser`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    $res = ph_Execute($sSQL);
    if ($res != '' && !$res->EOF) {
      $nCount = intval($res->fields("nCnt"));
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
      $vOrder = '`grp_id`, `Id`';
    }
    $vWhere0 = '(`grp_id`>0)';
    if ($vWhere != '') {
      $vWhere0 .= ' AND (' . $vWhere . ')';
    }
    $res = ph_Execute(self::getSelectStatement($vWhere0, $vOrder, $vLimit));
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
    $cClass = new cCpyUser();
    $res = ph_Execute(self::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByLogon($vLogon) {
    $cClass = new cCpyUser();
    $res = ph_Execute(self::getSelectStatement('(`logon`="' . $vLogon . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function checkUserLogin($vLogon, $vPassword) {
    $cClass = new cCpyUser();
    $res = ph_Execute(self::getSelectStatement('(`status_id`=1) AND (`logon`="' . $vLogon . '") AND (`password`="' . $vPassword . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyUser();
    $cClass->Id = intval($res->fields("id"));
    $cClass->rId = intval($res->fields("rid"));
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->TypeName = $res->fields("type_name");
    $cClass->GrpId = intval($res->fields("grp_id"));
    $cClass->GrpName = $res->fields("grp_name");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->StatusName = $res->fields("status_name");
    $cClass->GenderId = intval($res->fields("gender_id"));
    $cClass->GenderName = $res->fields("gender_name");
    $cClass->SpecialId = intval($res->fields("special_id"));
    $cClass->SpecialName = $res->fields("special_name");
    $cClass->Image = $res->fields("image");
    $cClass->FullImage = $cClass->Image;
    if ($cClass->Image == null || $cClass->Image == '') {
      $cClass->Image = 'avatar' . $cClass->GenderId . '_256.png';
      $cClass->FullImage = 'avatars/' . $cClass->Image;
    }
    $cClass->Name = $res->fields("name");
    $cClass->Logon = $res->fields("logon");
    $cClass->Password = $res->fields("password");
    $cClass->oGrp = cCpyPGrp::getInstance($cClass->GrpId);
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oGender = cPhsCode::getInstance(cPhsCode::GENDER, $cClass->GenderId);
    $cClass->oSpecial = cClncSpecial::getInstance($cClass->SpecialId);
    $vWhere = '(`status_id`=1)';
    if ($cClass->GrpId > 0) {
      $vWhere .= ' AND (`id` IN (SELECT `clinic_id` FROM `cpy_user_clinic` WHERE `user_id`="' . $cClass->Id . '"))';
    }
    $cClass->aClinics = cClncClinic::getArray($vWhere);
    $cClass->aClinicIds = array();
    $nIdx = 0;
    foreach ($cClass->aClinics as $clinic) {
      $cClass->aClinicIds[$nIdx] = $clinic->Id;
      $nIdx++;
    }
    return $cClass;
  }

  public function changePassword($vOPassword, $vNPassword, $vVPassword) {
    $bResult = false;
    if ($this->Password === ph_EncodePassword($vOPassword) && $vNPassword === $vVPassword) {
      $sSQL = 'UPDATE `cpy_user` SET `password`="' . ph_EncodePassword($vNPassword) . '"'
              . ' WHERE (`id`=' . $this->Id . ')';
      ph_Execute($sSQL);
      $bResult = true;
    }
    return $bResult;
  }

  public function resetPassword($vNPassword, $vVPassword) {
    $bResult = false;
    if ($vNPassword === $vVPassword) {
      $sSQL = 'UPDATE `cpy_user` SET `password`="' . ph_EncodePassword($vNPassword) . '"'
              . ' WHERE (`id`=' . $this->Id . ')';
      ph_Execute($sSQL);
      $bResult = true;
    }
    return $bResult;
  }

  public function save($nUId) {
    $nId = $this->Id;
    $vSQL = '';
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `cpy_user` (`grp_id`, `status_id`, `gender_id`,'
              . ' `logon`, `password`, `name`, `ins_user`'
              . ') VALUES ("' . $this->GrpId . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->GenderId . '"'
              . ', "' . $this->Logon . '"'
              . ', "' . ph_EncodePassword($this->Password) . '"'
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
      $vSQL = 'UPDATE `cpy_user` SET'
              . '  `grp_id`="' . $this->GrpId . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `gender_id`="' . $this->GenderId . '"'
              . ', `logon`="' . $this->Logon . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `upd_user`="' . $nUId . '"'
              . ' WHERE `id`="' . $this->Id . '"';
      ph_Execute($vSQL);
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `cpy_user` WHERE `id`="' . $this->Id . '"';
    ph_Execute($vSQL);
  }

}
