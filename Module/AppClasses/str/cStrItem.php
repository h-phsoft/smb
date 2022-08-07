<?php

class cStrItem {

  var $Id = -999;
  var $CatId = 0;
  var $CatName = '';
  var $oCat;
  var $TypeId = 1;
  var $TypeName = '';
  var $oType;
  var $StatusId = 1;
  var $StatusName = '';
  var $oStatus;
  var $UnitId = 1;
  var $UnitName = '';
  var $oUnit;
  var $CostTypeId = 1;
  var $CostTypeName = '';
  var $oCostType;
  var $MethodId = 1;
  var $MethodName = '';
  var $oMethod;
  var $Spec1Id = 0;
  var $Spec1Name = 'None';
  var $oSpec1;
  var $Spec2Id = 0;
  var $Spec2Name = 'None';
  var $oSpec2;
  var $Spec3Id = 0;
  var $Spec3Name = 'None';
  var $oSpec3;
  var $Spec4Id = 0;
  var $Spec4Name = 'None';
  var $oSpec4;
  var $Spec5Id = 0;
  var $Spec5Name = 'None';
  var $oSpec5;
  var $Num;
  var $PartNum;
  var $Name;
  var $CCost = 0;
  var $nPrice = 0;
  var $dPrice = 0;
  var $sPrice = 0;
  var $wPrice = 0;
  var $hPrice = 0;
  var $rPrice = 0;
  var $mPrice = 0;
  var $MinUnit = 1;
  var $FQnt = 1;
  var $Box = 1;
  var $Image = '';
  var $Desc;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id` , `num`, `partnum`, `name`,'
            . ' `cat_id`, `type_id`, `status_id`, `unit_id`, `costtype_id`, `method_id`,'
            . ' `spc1_id`, `spc2_id`, `spc3_id`, `spc4_id`, `spc5_id`, `image`,'
            . ' `ccost`, `nprice`, `dprice`, `sprice`, `wprice`, `hprice`, `rprice`, `mprice`,'
            . ' `min_unit`, `fqnt`, `box`, `desc`, `rem`'
            . ' FROM `str_item`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_item`';
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
      $vOrder = '`num`, `Id`';
    }
    $res = ph_Execute(cStrItem::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrItem::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrItem();
    $res = ph_Execute(cStrItem::getSelectStatement('`id`="' . $nId . '"'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrItem::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrItem();
    $cClass->Id = intval($res->fields("id"));
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->StatusName = $cClass->oStatus->Name;
    $cClass->UnitId = intval($res->fields("unit_id"));
    $cClass->oUnit = cCpyCode::getInstance(cCpyCode::UNIT, $cClass->UnitId);
    $cClass->UnitName = $cClass->oUnit->Name;
    $cClass->Spec1Id = intval($res->fields("spc1_id"));
    $cClass->oSpec1 = cCpyCode::getInstance(cCpyCode::STR_CLASSIFICATION1, $cClass->Spec1Id);
    $cClass->Spec1Name = $cClass->oSpec1->Name;
    $cClass->Spec2Id = intval($res->fields("spc2_id"));
    $cClass->oSpec2 = cCpyCode::getInstance(cCpyCode::STR_CLASSIFICATION2, $cClass->Spec2Id);
    $cClass->Spec2Name = $cClass->oSpec2->Name;
    $cClass->Spec3Id = intval($res->fields("spc3_id"));
    $cClass->oSpec3 = cCpyCode::getInstance(cCpyCode::STR_CLASSIFICATION3, $cClass->Spec3Id);
    $cClass->Spec3Name = $cClass->oSpec3->Name;
    $cClass->Spec4Id = intval($res->fields("spc4_id"));
    $cClass->oSpec4 = cCpyCode::getInstance(cCpyCode::STR_CLASSIFICATION4, $cClass->Spec4Id);
    $cClass->Spec4Name = $cClass->oSpec4->Name;
    $cClass->Spec5Id = intval($res->fields("spc5_id"));
    $cClass->oSpec5 = cCpyCode::getInstance(cCpyCode::STR_CLASSIFICATION5, $cClass->Spec5Id);
    $cClass->Spec5Name = $cClass->oSpec5->Name;
    $cClass->Num = $res->fields("num");
    $cClass->PartNum = $res->fields("partnum");
    $cClass->Name = $res->fields("name");
    $cClass->MinUnit = $res->fields("min_unit");
    $cClass->FQnt = $res->fields("fqnt");
    $cClass->Box = $res->fields("box");
    $cClass->CCost = $res->fields("ccost");
    $cClass->nPrice = floatval($res->fields("nprice"));
    $cClass->dPrice = floatval($res->fields("dprice"));
    $cClass->sPrice = floatval($res->fields("sprice"));
    $cClass->wPrice = floatval($res->fields("wprice"));
    $cClass->hPrice = floatval($res->fields("hprice"));
    $cClass->rPrice = floatval($res->fields("rprice"));
    $cClass->mPrice = floatval($res->fields("mprice"));
    $cClass->Image = $res->fields("image");
    $cClass->Desc = $res->fields("desc");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_item` (`num`, `partnum`, `name`,'
              . ' `status_id`, `unit_id`,'
              . ' `spc1_id`, `spc2_id`, `spc3_id`, `image`,'
              . ' `ccost`, `nprice`, `desc`, `rem`, `ins_user`'
              . ') VALUES ('
              . ' "' . $this->Num . '"'
              . ', "' . $this->PartNum . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->UnitId . '"'
              . ', "' . $this->Spec1Id . '"'
              . ', "' . $this->Spec2Id . '"'
              . ', "' . $this->Spec3Id . '"'
              . ', "' . $this->Image . '"'
              . ', "' . $this->CCost . '"'
              . ', "' . $this->nPrice . '"'
              . ', "' . $this->Desc . '"'
              . ', "' . $this->Rem . '"'
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
      $vSQL = 'UPDATE `str_item` SET'
              . ' `num`="' . $this->Num . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `unit_id`="' . $this->UnitId . '"'
              . ', `spc1_id`="' . $this->Spec1Id . '"'
              . ', `spc2_id`="' . $this->Spec2Id . '"'
              . ', `spc3_id`="' . $this->Spec3Id . '"'
              . ', `image`="' . $this->Image . '"'
              . ', `fqnt`="' . $this->FQnt . '"'
              . ', `ccost`="' . $this->CCost . '"'
              . ', `nprice`="' . $this->nPrice . '"'
              . ', `desc`="' . $this->Desc . '"'
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
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `str_item` WHERE `id`="' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public static function updateFormula($nItemFId, $nFQnt, $vDesc) {
    if (intval($nItemFId) > 0) {
      $vSQL = 'UPDATE `str_item` SET'
              . ' `fqnt`="' . $nFQnt . '"'
              . ',`desc`="' . $vDesc . '"'
              . ' WHERE `id`=' . $nItemFId;
      $res = ph_ExecuteUpdate($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
  }

}
