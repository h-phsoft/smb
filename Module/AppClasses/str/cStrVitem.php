<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.1.211108.0840
 * 
 * @author Haytham
 * @version 2.0.1.211108.0840
 * @update ????/??/?? ??:??
 *
 */

class cStrVitem {

  var $Id;
  var $Num;
  var $Name;
  var $Partnum;
  var $CatId;
  var $CatName;
  var $UnitId;
  var $UnitName;
  var $Spc1Id;
  var $Spc1Name;
  var $Spc2Id;
  var $Spc2Name;
  var $Spc3Id;
  var $Spc3Name;
  var $Spc4Id;
  var $Spc4Name;
  var $Spc5Id;
  var $Spc5Name;
  var $TypeId;
  var $StatusId;
  var $CosttypeId;
  var $MethodId;
  var $InsaleId;
  var $SeasonId;
  var $WarntyDays;
  var $Nofp;
  var $MinUnit;
  var $Box;
  var $Ccost;
  var $Nprice;
  var $Dprice;
  var $Sprice;
  var $Wprice;
  var $Rprice;
  var $Hprice;
  var $Mprice;
  var $Image;
  var $Desc;
  var $Rem;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `num`, `name`, `partnum`, `cat_id`, `cat_name`, `unit_id`'
      . ', `unit_name`, `spc1_id`, `spc1_name`, `spc2_id`, `spc2_name`, `spc3_id`, `spc3_name`'
      . ', `spc4_id`, `spc4_name`, `spc5_id`, `spc5_name`, `type_id`, `status_id`, `costtype_id`'
      . ', `method_id`, `insale_id`, `season_id`, `warnty_days`, `nofp`, `min_unit`, `box`'
      . ', `ccost`, `nprice`, `dprice`, `sprice`, `wprice`, `rprice`, `hprice`'
      . ', `mprice`, `image`, `desc`, `rem`'
      . ' FROM `str_vitem`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_vitem`';
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
    $res = ph_Execute(cStrVitem::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVitem::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVitem();
    $res = ph_Execute(cStrVitem::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVitem::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVitem();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Num = $res->fields('num');
    $cClass->Name = $res->fields('name');
    $cClass->Partnum = $res->fields('partnum');
    $cClass->CatId = intval($res->fields('cat_id'));
    $cClass->CatName = $res->fields('cat_name');
    $cClass->UnitId = intval($res->fields('unit_id'));
    $cClass->UnitName = $res->fields('unit_name');
    $cClass->Spc1Id = intval($res->fields('spc1_id'));
    $cClass->Spc1Name = $res->fields('spc1_name');
    $cClass->Spc2Id = intval($res->fields('spc2_id'));
    $cClass->Spc2Name = $res->fields('spc2_name');
    $cClass->Spc3Id = intval($res->fields('spc3_id'));
    $cClass->Spc3Name = $res->fields('spc3_name');
    $cClass->Spc4Id = intval($res->fields('spc4_id'));
    $cClass->Spc4Name = $res->fields('spc4_name');
    $cClass->Spc5Id = intval($res->fields('spc5_id'));
    $cClass->Spc5Name = $res->fields('spc5_name');
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->CosttypeId = intval($res->fields('costtype_id'));
    $cClass->MethodId = intval($res->fields('method_id'));
    $cClass->InsaleId = intval($res->fields('insale_id'));
    $cClass->SeasonId = intval($res->fields('season_id'));
    $cClass->WarntyDays = intval($res->fields('warnty_days'));
    $cClass->Nofp = intval($res->fields('nofp'));
    $cClass->MinUnit = floatval($res->fields('min_unit'));
    $cClass->Box = floatval($res->fields('box'));
    $cClass->Ccost = floatval($res->fields('ccost'));
    $cClass->Nprice = floatval($res->fields('nprice'));
    $cClass->Dprice = floatval($res->fields('dprice'));
    $cClass->Sprice = floatval($res->fields('sprice'));
    $cClass->Wprice = floatval($res->fields('wprice'));
    $cClass->Rprice = floatval($res->fields('rprice'));
    $cClass->Hprice = floatval($res->fields('hprice'));
    $cClass->Mprice = floatval($res->fields('mprice'));
    $cClass->Image = $res->fields('image');
    $cClass->Desc = $res->fields('desc');
    $cClass->Rem = $res->fields('rem');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_vitem` ('
        . '  `num`, `name`, `partnum`, `cat_id`, `cat_name`, `unit_id`, `unit_name`'
        . ', `spc1_id`, `spc1_name`, `spc2_id`, `spc2_name`, `spc3_id`, `spc3_name`, `spc4_id`'
        . ', `spc4_name`, `spc5_id`, `spc5_name`, `type_id`, `status_id`, `costtype_id`, `method_id`'
        . ', `insale_id`, `season_id`, `warnty_days`, `nofp`, `min_unit`, `box`, `ccost`'
        . ', `nprice`, `dprice`, `sprice`, `wprice`, `rprice`, `hprice`, `mprice`'
        . ', `image`, `desc`, `rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->Num . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Partnum . '"'
        . ', "' . $this->CatId . '"'
        . ', "' . $this->CatName . '"'
        . ', "' . $this->UnitId . '"'
        . ', "' . $this->UnitName . '"'
        . ', "' . $this->Spc1Id . '"'
        . ', "' . $this->Spc1Name . '"'
        . ', "' . $this->Spc2Id . '"'
        . ', "' . $this->Spc2Name . '"'
        . ', "' . $this->Spc3Id . '"'
        . ', "' . $this->Spc3Name . '"'
        . ', "' . $this->Spc4Id . '"'
        . ', "' . $this->Spc4Name . '"'
        . ', "' . $this->Spc5Id . '"'
        . ', "' . $this->Spc5Name . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->StatusId . '"'
        . ', "' . $this->CosttypeId . '"'
        . ', "' . $this->MethodId . '"'
        . ', "' . $this->InsaleId . '"'
        . ', "' . $this->SeasonId . '"'
        . ', "' . $this->WarntyDays . '"'
        . ', "' . $this->Nofp . '"'
        . ', "' . $this->MinUnit . '"'
        . ', "' . $this->Box . '"'
        . ', "' . $this->Ccost . '"'
        . ', "' . $this->Nprice . '"'
        . ', "' . $this->Dprice . '"'
        . ', "' . $this->Sprice . '"'
        . ', "' . $this->Wprice . '"'
        . ', "' . $this->Rprice . '"'
        . ', "' . $this->Hprice . '"'
        . ', "' . $this->Mprice . '"'
        . ', "' . $this->Image . '"'
        . ', "' . $this->Desc . '"'
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
      $vSQL = 'UPDATE `str_vitem` SET'
        . '  `num`="' . $this->Num . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `partnum`="' . $this->Partnum . '"'
        . ', `cat_id`="' . $this->CatId . '"'
        . ', `cat_name`="' . $this->CatName . '"'
        . ', `unit_id`="' . $this->UnitId . '"'
        . ', `unit_name`="' . $this->UnitName . '"'
        . ', `spc1_id`="' . $this->Spc1Id . '"'
        . ', `spc1_name`="' . $this->Spc1Name . '"'
        . ', `spc2_id`="' . $this->Spc2Id . '"'
        . ', `spc2_name`="' . $this->Spc2Name . '"'
        . ', `spc3_id`="' . $this->Spc3Id . '"'
        . ', `spc3_name`="' . $this->Spc3Name . '"'
        . ', `spc4_id`="' . $this->Spc4Id . '"'
        . ', `spc4_name`="' . $this->Spc4Name . '"'
        . ', `spc5_id`="' . $this->Spc5Id . '"'
        . ', `spc5_name`="' . $this->Spc5Name . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `costtype_id`="' . $this->CosttypeId . '"'
        . ', `method_id`="' . $this->MethodId . '"'
        . ', `insale_id`="' . $this->InsaleId . '"'
        . ', `season_id`="' . $this->SeasonId . '"'
        . ', `warnty_days`="' . $this->WarntyDays . '"'
        . ', `nofp`="' . $this->Nofp . '"'
        . ', `min_unit`="' . $this->MinUnit . '"'
        . ', `box`="' . $this->Box . '"'
        . ', `ccost`="' . $this->Ccost . '"'
        . ', `nprice`="' . $this->Nprice . '"'
        . ', `dprice`="' . $this->Dprice . '"'
        . ', `sprice`="' . $this->Sprice . '"'
        . ', `wprice`="' . $this->Wprice . '"'
        . ', `rprice`="' . $this->Rprice . '"'
        . ', `hprice`="' . $this->Hprice . '"'
        . ', `mprice`="' . $this->Mprice . '"'
        . ', `image`="' . $this->Image . '"'
        . ', `desc`="' . $this->Desc . '"'
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
    $vSQL = 'DELETE FROM `str_vitem` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

