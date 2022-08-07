<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.2.220201.1330
 *
 * @author Haytham
 * @version 2.0.2.220201.1330
 * @update 2022/02/13 15:12
 *
 */

class cMngCont {

  public $Id;
  public $Num;
  public $Name;
  public $Username;
  public $Password;
  public $Title;
  public $Legal;
  public $Owner;
  public $Person;
  public $Nlmt;
  public $Dlmt;
  public $PriceId;
  public $ReprId;
  public $StatusId;
  public $TypeId;
  public $BlmId;
  public $NatId;
  public $Class1Id;
  public $Class2Id;
  public $Class3Id;
  public $Class4Id;
  public $Class5Id;
  public $Phone;
  public $Mobile;
  public $Email;
  public $Address;
  public $Odate;
  public $Sdate;
  public $Edate;
  public $Gdate;
  public $InsUser;
  public $InsDate;
  public $UpdUser;
  public $UpdDate;
  //
  public $oBlm;
  public $oRepr;
  public $oClass1;
  public $oClass2;
  public $oClass3;
  public $oClass4;
  public $oClass5;
  public $oNat;
  public $oPrice;
  public $oStatus;
  public $oType;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `num`, `name`, `username`, `password`, `title`, `legal`'
      . ', `owner`, `person`, `nlmt`, `dlmt`, `price_id`, `repr_id`, `status_id`'
      . ', `type_id`, `blm_id`, `nat_id`, `class1_id`, `class2_id`, `class3_id`, `class4_id`'
      . ', `class5_id`, `phone`, `mobile`, `email`, `address`, `odate`, `sdate`'
      . ', `edate`, `gdate`, `ins_user`, `ins_date`, `upd_user`, `upd_date`'
      . ' FROM `mng_cont`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `mng_cont`';
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
    $res = ph_Execute(cMngCont::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMngCont::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cMngCont();
    $res = ph_Execute(cMngCont::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMngCont::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cMngCont();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Num = intval($res->fields('num'));
    $cClass->Name = $res->fields('name');
    $cClass->Username = $res->fields('username');
    $cClass->Password = $res->fields('password');
    $cClass->Title = $res->fields('title');
    $cClass->Legal = $res->fields('legal');
    $cClass->Owner = $res->fields('owner');
    $cClass->Person = $res->fields('person');
    $cClass->Nlmt = floatval($res->fields('nlmt'));
    $cClass->Dlmt = intval($res->fields('dlmt'));
    $cClass->PriceId = intval($res->fields('price_id'));
    $cClass->ReprId = intval($res->fields('repr_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->BlmId = intval($res->fields('blm_id'));
    $cClass->NatId = intval($res->fields('nat_id'));
    $cClass->Class1Id = intval($res->fields('class1_id'));
    $cClass->Class2Id = intval($res->fields('class2_id'));
    $cClass->Class3Id = intval($res->fields('class3_id'));
    $cClass->Class4Id = intval($res->fields('class4_id'));
    $cClass->Class5Id = intval($res->fields('class5_id'));
    $cClass->Phone = $res->fields('phone');
    $cClass->Mobile = $res->fields('mobile');
    $cClass->Email = $res->fields('email');
    $cClass->Address = $res->fields('address');
    $cClass->Odate = $res->fields('odate');
    $cClass->Sdate = $res->fields('sdate');
    $cClass->Edate = $res->fields('edate');
    $cClass->Gdate = $res->fields('gdate');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oBlm = cPhsCode::getInstance(cPhsCode::BALANCE_MODE, $cClass->BlmId);
    $cClass->oClass1 = cCpyCode::getInstance(cCpyCode::CONTACT_CLASS, $cClass->Class1Id);
    $cClass->oClass2 = cCpyCode::getInstance(cCpyCode::CONTACT_CLASS, $cClass->Class2Id);
    $cClass->oClass3 = cCpyCode::getInstance(cCpyCode::CONTACT_CLASS, $cClass->Class3Id);
    $cClass->oClass4 = cCpyCode::getInstance(cCpyCode::CONTACT_CLASS, $cClass->Class4Id);
    $cClass->oClass5 = cCpyCode::getInstance(cCpyCode::CONTACT_CLASS, $cClass->Class5Id);
    $cClass->oNat = cCpyCode::getInstance(cCpyCode::NATIONALITY, $cClass->NatId);
    $cClass->oPrice = cSalMprice::getInstance($cClass->PriceId);
    $cClass->oRepr = cCrmRepr::getInstance($cClass->ReprId);
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oType = cPhsCode::getInstance(cPhsCode::CONTACT_TYPE, $cClass->TypeId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `mng_cont` ('
        . '  `num`, `name`, `username`, `password`, `title`, `legal`, `owner`'
        . ', `person`, `nlmt`, `dlmt`, `price_id`, `repr_id`, `status_id`, `type_id`'
        . ', `blm_id`, `nat_id`, `class1_id`, `class2_id`, `class3_id`, `class4_id`, `class5_id`'
        . ', `phone`, `mobile`, `email`, `address`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->Num . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Username . '"'
        . ', "' . $this->Password . '"'
        . ', "' . $this->Title . '"'
        . ', "' . $this->Legal . '"'
        . ', "' . $this->Owner . '"'
        . ', "' . $this->Person . '"'
        . ', "' . $this->Nlmt . '"'
        . ', "' . $this->Dlmt . '"'
        . ', "' . $this->PriceId . '"'
        . ', "' . $this->ReprId . '"'
        . ', "' . $this->StatusId . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->BlmId . '"'
        . ', "' . $this->NatId . '"'
        . ', "' . $this->Class1Id . '"'
        . ', "' . $this->Class2Id . '"'
        . ', "' . $this->Class3Id . '"'
        . ', "' . $this->Class4Id . '"'
        . ', "' . $this->Class5Id . '"'
        . ', "' . $this->Phone . '"'
        . ', "' . $this->Mobile . '"'
        . ', "' . $this->Email . '"'
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
      $vSQL = 'UPDATE `mng_cont` SET'
        . '  `num`="' . $this->Num . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `username`="' . $this->Username . '"'
        . ', `password`="' . $this->Password . '"'
        . ', `title`="' . $this->Title . '"'
        . ', `legal`="' . $this->Legal . '"'
        . ', `owner`="' . $this->Owner . '"'
        . ', `person`="' . $this->Person . '"'
        . ', `nlmt`="' . $this->Nlmt . '"'
        . ', `dlmt`="' . $this->Dlmt . '"'
        . ', `price_id`="' . $this->PriceId . '"'
        . ', `repr_id`="' . $this->ReprId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `blm_id`="' . $this->BlmId . '"'
        . ', `nat_id`="' . $this->NatId . '"'
        . ', `class1_id`="' . $this->Class1Id . '"'
        . ', `class2_id`="' . $this->Class2Id . '"'
        . ', `class3_id`="' . $this->Class3Id . '"'
        . ', `class4_id`="' . $this->Class4Id . '"'
        . ', `class5_id`="' . $this->Class5Id . '"'
        . ', `phone`="' . $this->Phone . '"'
        . ', `mobile`="' . $this->Mobile . '"'
        . ', `email`="' . $this->Email . '"'
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

  public function saveRep($nUId) {
    $nId = $this->Id;
    $vSQL = 'UPDATE `mng_cont` SET'
      . '  `repr_id`="' . $this->ReprId . '"'
      . ', `sdate`="' . $this->Sdate . '"'
      . ', `edate`="' . $this->Edate . '"'
      . ', `upd_user`="' . $nUId . '"'
      . ' WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `mng_cont` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
