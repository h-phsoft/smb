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

class cStrVintrn {

  var $TrnId;
  var $TrelId;
  var $IcsId;
  var $SicsId;
  var $UnitId;
  var $UnitName;
  var $ColorId;
  var $ColorName;
  var $SizeId;
  var $SizeName;
  var $ItemId;
  var $ItemNum;
  var $ItemName;
  var $ItemPartnum;
  var $ItemTypeId;
  var $ItemStatusId;
  var $ItemCosttypeId;
  var $ItemMethodId;
  var $ItemUnitId;
  var $ItemInsaleId;
  var $ItemSeasonId;
  var $ItemWarntyDays;
  var $ItemNofp;
  var $ItemCatId;
  var $ItemSpc1Id;
  var $ItemSpc2Id;
  var $ItemSpc3Id;
  var $ItemSpc4Id;
  var $ItemSpc5Id;
  var $ItemMinUnit;
  var $ItemBox;
  var $ItemCcost;
  var $ItemNprice;
  var $ItemDprice;
  var $ItemSprice;
  var $ItemWprice;
  var $ItemRprice;
  var $ItemHprice;
  var $ItemMprice;
  var $ItemImage;
  var $ItemDesc;
  var $ItemRem;
  var $TrnOrd;
  var $TrnUperc;
  var $TrnQnt;
  var $TrnWqnt;
  var $TrnCqnt;
  var $TrnCwqnt;
  var $TrnSqnt;
  var $TrnSwqnt;
  var $TrnPrice;
  var $TrnCamt;
  var $TrnBamt;
  var $TrnAmt;
  var $TrnCost;
  var $TrnBcost;
  var $TrnLength;
  var $TrnWidth;
  var $TrnHeight;
  var $TrnBarcode;
  var $TrnModel;
  var $TrnLotser;
  var $TrnSdate;
  var $TrnEdate;
  var $TrnRem;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `trn_id`, `trel_id`, `ics_id`, `sics_id`, `unit_id`, `unit_name`, `color_id`'
      . ', `color_name`, `size_id`, `size_name`, `item_id`, `item_num`, `item_name`, `item_partnum`'
      . ', `item_type_id`, `item_status_id`, `item_costtype_id`, `item_method_id`, `item_unit_id`, `item_insale_id`, `item_season_id`'
      . ', `item_warnty_days`, `item_nofp`, `item_cat_id`, `item_spc1_id`, `item_spc2_id`, `item_spc3_id`, `item_spc4_id`'
      . ', `item_spc5_id`, `item_min_unit`, `item_box`, `item_ccost`, `item_nprice`, `item_dprice`, `item_sprice`'
      . ', `item_wprice`, `item_rprice`, `item_hprice`, `item_mprice`, `item_image`, `item_desc`, `item_rem`'
      . ', `trn_ord`, `trn_uperc`, `trn_qnt`, `trn_wqnt`, `trn_cqnt`, `trn_cwqnt`, `trn_sqnt`'
      . ', `trn_swqnt`, `trn_price`, `trn_camt`, `trn_bamt`, `trn_amt`, `trn_cost`, `trn_bcost`'
      . ', `trn_length`, `trn_width`, `trn_height`, `trn_barcode`, `trn_model`, `trn_lotser`, `trn_sdate`'
      . ', `trn_edate`, `trn_rem`'
      . ' FROM `str_vintrn`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_vintrn`';
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
    $res = ph_Execute(cStrVintrn::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVintrn::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVintrn();
    $res = ph_Execute(cStrVintrn::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVintrn::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVintrn();
    $cClass->TrnId = intval($res->fields('trn_id'));
    $cClass->TrelId = intval($res->fields('trel_id'));
    $cClass->IcsId = intval($res->fields('ics_id'));
    $cClass->SicsId = intval($res->fields('sics_id'));
    $cClass->UnitId = intval($res->fields('unit_id'));
    $cClass->UnitName = $res->fields('unit_name');
    $cClass->ColorId = intval($res->fields('color_id'));
    $cClass->ColorName = $res->fields('color_name');
    $cClass->SizeId = intval($res->fields('size_id'));
    $cClass->SizeName = $res->fields('size_name');
    $cClass->ItemId = intval($res->fields('item_id'));
    $cClass->ItemNum = $res->fields('item_num');
    $cClass->ItemName = $res->fields('item_name');
    $cClass->ItemPartnum = $res->fields('item_partnum');
    $cClass->ItemTypeId = intval($res->fields('item_type_id'));
    $cClass->ItemStatusId = intval($res->fields('item_status_id'));
    $cClass->ItemCosttypeId = intval($res->fields('item_costtype_id'));
    $cClass->ItemMethodId = intval($res->fields('item_method_id'));
    $cClass->ItemUnitId = intval($res->fields('item_unit_id'));
    $cClass->ItemInsaleId = intval($res->fields('item_insale_id'));
    $cClass->ItemSeasonId = intval($res->fields('item_season_id'));
    $cClass->ItemWarntyDays = intval($res->fields('item_warnty_days'));
    $cClass->ItemNofp = intval($res->fields('item_nofp'));
    $cClass->ItemCatId = intval($res->fields('item_cat_id'));
    $cClass->ItemSpc1Id = intval($res->fields('item_spc1_id'));
    $cClass->ItemSpc2Id = intval($res->fields('item_spc2_id'));
    $cClass->ItemSpc3Id = intval($res->fields('item_spc3_id'));
    $cClass->ItemSpc4Id = intval($res->fields('item_spc4_id'));
    $cClass->ItemSpc5Id = intval($res->fields('item_spc5_id'));
    $cClass->ItemMinUnit = floatval($res->fields('item_min_unit'));
    $cClass->ItemBox = floatval($res->fields('item_box'));
    $cClass->ItemCcost = floatval($res->fields('item_ccost'));
    $cClass->ItemNprice = floatval($res->fields('item_nprice'));
    $cClass->ItemDprice = floatval($res->fields('item_dprice'));
    $cClass->ItemSprice = floatval($res->fields('item_sprice'));
    $cClass->ItemWprice = floatval($res->fields('item_wprice'));
    $cClass->ItemRprice = floatval($res->fields('item_rprice'));
    $cClass->ItemHprice = floatval($res->fields('item_hprice'));
    $cClass->ItemMprice = floatval($res->fields('item_mprice'));
    $cClass->ItemImage = $res->fields('item_image');
    $cClass->ItemDesc = $res->fields('item_desc');
    $cClass->ItemRem = $res->fields('item_rem');
    $cClass->TrnOrd = intval($res->fields('trn_ord'));
    $cClass->TrnUperc = floatval($res->fields('trn_uperc'));
    $cClass->TrnQnt = floatval($res->fields('trn_qnt'));
    $cClass->TrnWqnt = floatval($res->fields('trn_wqnt'));
    $cClass->TrnCqnt = floatval($res->fields('trn_cqnt'));
    $cClass->TrnCwqnt = floatval($res->fields('trn_cwqnt'));
    $cClass->TrnSqnt = floatval($res->fields('trn_sqnt'));
    $cClass->TrnSwqnt = floatval($res->fields('trn_swqnt'));
    $cClass->TrnPrice = floatval($res->fields('trn_price'));
    $cClass->TrnCamt = floatval($res->fields('trn_camt'));
    $cClass->TrnBamt = floatval($res->fields('trn_bamt'));
    $cClass->TrnAmt = floatval($res->fields('trn_amt'));
    $cClass->TrnCost = floatval($res->fields('trn_cost'));
    $cClass->TrnBcost = floatval($res->fields('trn_bcost'));
    $cClass->TrnLength = floatval($res->fields('trn_length'));
    $cClass->TrnWidth = floatval($res->fields('trn_width'));
    $cClass->TrnHeight = floatval($res->fields('trn_height'));
    $cClass->TrnBarcode = $res->fields('trn_barcode');
    $cClass->TrnModel = $res->fields('trn_model');
    $cClass->TrnLotser = $res->fields('trn_lotser');
    $cClass->TrnSdate = $res->fields('trn_sdate');
    $cClass->TrnEdate = $res->fields('trn_edate');
    $cClass->TrnRem = $res->fields('trn_rem');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_vintrn` ('
        . '  `trel_id`, `ics_id`, `sics_id`, `unit_id`, `unit_name`, `color_id`, `color_name`'
        . ', `size_id`, `size_name`, `item_id`, `item_num`, `item_name`, `item_partnum`, `item_type_id`'
        . ', `item_status_id`, `item_costtype_id`, `item_method_id`, `item_unit_id`, `item_insale_id`, `item_season_id`, `item_warnty_days`'
        . ', `item_nofp`, `item_cat_id`, `item_spc1_id`, `item_spc2_id`, `item_spc3_id`, `item_spc4_id`, `item_spc5_id`'
        . ', `item_min_unit`, `item_box`, `item_ccost`, `item_nprice`, `item_dprice`, `item_sprice`, `item_wprice`'
        . ', `item_rprice`, `item_hprice`, `item_mprice`, `item_image`, `item_desc`, `item_rem`, `trn_ord`'
        . ', `trn_uperc`, `trn_qnt`, `trn_wqnt`, `trn_cqnt`, `trn_cwqnt`, `trn_sqnt`, `trn_swqnt`'
        . ', `trn_price`, `trn_camt`, `trn_bamt`, `trn_amt`, `trn_cost`, `trn_bcost`, `trn_length`'
        . ', `trn_width`, `trn_height`, `trn_barcode`, `trn_model`, `trn_lotser`, `trn_sdate`, `trn_edate`'
        . ', `trn_rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->TrelId . '"'
        . ', "' . $this->IcsId . '"'
        . ', "' . $this->SicsId . '"'
        . ', "' . $this->UnitId . '"'
        . ', "' . $this->UnitName . '"'
        . ', "' . $this->ColorId . '"'
        . ', "' . $this->ColorName . '"'
        . ', "' . $this->SizeId . '"'
        . ', "' . $this->SizeName . '"'
        . ', "' . $this->ItemId . '"'
        . ', "' . $this->ItemNum . '"'
        . ', "' . $this->ItemName . '"'
        . ', "' . $this->ItemPartnum . '"'
        . ', "' . $this->ItemTypeId . '"'
        . ', "' . $this->ItemStatusId . '"'
        . ', "' . $this->ItemCosttypeId . '"'
        . ', "' . $this->ItemMethodId . '"'
        . ', "' . $this->ItemUnitId . '"'
        . ', "' . $this->ItemInsaleId . '"'
        . ', "' . $this->ItemSeasonId . '"'
        . ', "' . $this->ItemWarntyDays . '"'
        . ', "' . $this->ItemNofp . '"'
        . ', "' . $this->ItemCatId . '"'
        . ', "' . $this->ItemSpc1Id . '"'
        . ', "' . $this->ItemSpc2Id . '"'
        . ', "' . $this->ItemSpc3Id . '"'
        . ', "' . $this->ItemSpc4Id . '"'
        . ', "' . $this->ItemSpc5Id . '"'
        . ', "' . $this->ItemMinUnit . '"'
        . ', "' . $this->ItemBox . '"'
        . ', "' . $this->ItemCcost . '"'
        . ', "' . $this->ItemNprice . '"'
        . ', "' . $this->ItemDprice . '"'
        . ', "' . $this->ItemSprice . '"'
        . ', "' . $this->ItemWprice . '"'
        . ', "' . $this->ItemRprice . '"'
        . ', "' . $this->ItemHprice . '"'
        . ', "' . $this->ItemMprice . '"'
        . ', "' . $this->ItemImage . '"'
        . ', "' . $this->ItemDesc . '"'
        . ', "' . $this->ItemRem . '"'
        . ', "' . $this->TrnOrd . '"'
        . ', "' . $this->TrnUperc . '"'
        . ', "' . $this->TrnQnt . '"'
        . ', "' . $this->TrnWqnt . '"'
        . ', "' . $this->TrnCqnt . '"'
        . ', "' . $this->TrnCwqnt . '"'
        . ', "' . $this->TrnSqnt . '"'
        . ', "' . $this->TrnSwqnt . '"'
        . ', "' . $this->TrnPrice . '"'
        . ', "' . $this->TrnCamt . '"'
        . ', "' . $this->TrnBamt . '"'
        . ', "' . $this->TrnAmt . '"'
        . ', "' . $this->TrnCost . '"'
        . ', "' . $this->TrnBcost . '"'
        . ', "' . $this->TrnLength . '"'
        . ', "' . $this->TrnWidth . '"'
        . ', "' . $this->TrnHeight . '"'
        . ', "' . $this->TrnBarcode . '"'
        . ', "' . $this->TrnModel . '"'
        . ', "' . $this->TrnLotser . '"'
        . ', "' . $this->TrnSdate . '"'
        . ', "' . $this->TrnEdate . '"'
        . ', "' . $this->TrnRem . '"'
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
      $vSQL = 'UPDATE `str_vintrn` SET'
        . '  `trel_id`="' . $this->TrelId . '"'
        . ', `ics_id`="' . $this->IcsId . '"'
        . ', `sics_id`="' . $this->SicsId . '"'
        . ', `unit_id`="' . $this->UnitId . '"'
        . ', `unit_name`="' . $this->UnitName . '"'
        . ', `color_id`="' . $this->ColorId . '"'
        . ', `color_name`="' . $this->ColorName . '"'
        . ', `size_id`="' . $this->SizeId . '"'
        . ', `size_name`="' . $this->SizeName . '"'
        . ', `item_id`="' . $this->ItemId . '"'
        . ', `item_num`="' . $this->ItemNum . '"'
        . ', `item_name`="' . $this->ItemName . '"'
        . ', `item_partnum`="' . $this->ItemPartnum . '"'
        . ', `item_type_id`="' . $this->ItemTypeId . '"'
        . ', `item_status_id`="' . $this->ItemStatusId . '"'
        . ', `item_costtype_id`="' . $this->ItemCosttypeId . '"'
        . ', `item_method_id`="' . $this->ItemMethodId . '"'
        . ', `item_unit_id`="' . $this->ItemUnitId . '"'
        . ', `item_insale_id`="' . $this->ItemInsaleId . '"'
        . ', `item_season_id`="' . $this->ItemSeasonId . '"'
        . ', `item_warnty_days`="' . $this->ItemWarntyDays . '"'
        . ', `item_nofp`="' . $this->ItemNofp . '"'
        . ', `item_cat_id`="' . $this->ItemCatId . '"'
        . ', `item_spc1_id`="' . $this->ItemSpc1Id . '"'
        . ', `item_spc2_id`="' . $this->ItemSpc2Id . '"'
        . ', `item_spc3_id`="' . $this->ItemSpc3Id . '"'
        . ', `item_spc4_id`="' . $this->ItemSpc4Id . '"'
        . ', `item_spc5_id`="' . $this->ItemSpc5Id . '"'
        . ', `item_min_unit`="' . $this->ItemMinUnit . '"'
        . ', `item_box`="' . $this->ItemBox . '"'
        . ', `item_ccost`="' . $this->ItemCcost . '"'
        . ', `item_nprice`="' . $this->ItemNprice . '"'
        . ', `item_dprice`="' . $this->ItemDprice . '"'
        . ', `item_sprice`="' . $this->ItemSprice . '"'
        . ', `item_wprice`="' . $this->ItemWprice . '"'
        . ', `item_rprice`="' . $this->ItemRprice . '"'
        . ', `item_hprice`="' . $this->ItemHprice . '"'
        . ', `item_mprice`="' . $this->ItemMprice . '"'
        . ', `item_image`="' . $this->ItemImage . '"'
        . ', `item_desc`="' . $this->ItemDesc . '"'
        . ', `item_rem`="' . $this->ItemRem . '"'
        . ', `trn_ord`="' . $this->TrnOrd . '"'
        . ', `trn_uperc`="' . $this->TrnUperc . '"'
        . ', `trn_qnt`="' . $this->TrnQnt . '"'
        . ', `trn_wqnt`="' . $this->TrnWqnt . '"'
        . ', `trn_cqnt`="' . $this->TrnCqnt . '"'
        . ', `trn_cwqnt`="' . $this->TrnCwqnt . '"'
        . ', `trn_sqnt`="' . $this->TrnSqnt . '"'
        . ', `trn_swqnt`="' . $this->TrnSwqnt . '"'
        . ', `trn_price`="' . $this->TrnPrice . '"'
        . ', `trn_camt`="' . $this->TrnCamt . '"'
        . ', `trn_bamt`="' . $this->TrnBamt . '"'
        . ', `trn_amt`="' . $this->TrnAmt . '"'
        . ', `trn_cost`="' . $this->TrnCost . '"'
        . ', `trn_bcost`="' . $this->TrnBcost . '"'
        . ', `trn_length`="' . $this->TrnLength . '"'
        . ', `trn_width`="' . $this->TrnWidth . '"'
        . ', `trn_height`="' . $this->TrnHeight . '"'
        . ', `trn_barcode`="' . $this->TrnBarcode . '"'
        . ', `trn_model`="' . $this->TrnModel . '"'
        . ', `trn_lotser`="' . $this->TrnLotser . '"'
        . ', `trn_sdate`="' . $this->TrnSdate . '"'
        . ', `trn_edate`="' . $this->TrnEdate . '"'
        . ', `trn_rem`="' . $this->TrnRem . '"'
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
    $vSQL = 'DELETE FROM `str_vintrn` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

