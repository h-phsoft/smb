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

class cStrVoumst {

  var $MstId;
  var $SrcId;
  var $TrntypeId;
  var $RelId;
  var $VhrId;
  var $FinId;
  var $CurnRate;
  var $BcurnRate;
  var $MstDocn;
  var $MstDocd;
  var $MstNum;
  var $MstDate;
  var $MstPerson;
  var $MstPhone;
  var $MstRem;
  var $WperId;
  var $WperName;
  var $StorId;
  var $StorNum;
  var $StorName;
  var $AccId;
  var $AccNum;
  var $AccName;
  var $CostId;
  var $CostNum;
  var $CostName;
  var $CurnId;
  var $CurnNum;
  var $CurnCode;
  var $CurnName;
  var $BcurnId;
  var $BcurnNum;
  var $BcurnCode;
  var $BcurnName;
  var $DocId;
  var $DocName;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `mst_id`, `src_id`, `trntype_id`, `rel_id`, `vhr_id`, `fin_id`, `curn_rate`'
      . ', `bcurn_rate`, `mst_docn`, `mst_docd`, `mst_num`, `mst_date`, `mst_person`, `mst_phone`'
      . ', `mst_rem`, `wper_id`, `wper_name`, `stor_id`, `stor_num`, `stor_name`, `acc_id`'
      . ', `acc_num`, `acc_name`, `cost_id`, `cost_num`, `cost_name`, `curn_id`, `curn_num`'
      . ', `curn_code`, `curn_name`, `bcurn_id`, `bcurn_num`, `bcurn_code`, `bcurn_name`, `doc_id`'
      . ', `doc_name`'
      . ' FROM `str_voumst`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_voumst`';
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
    $res = ph_Execute(cStrVoumst::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVoumst::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVoumst();
    $res = ph_Execute(cStrVoumst::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVoumst::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVoumst();
    $cClass->MstId = intval($res->fields('mst_id'));
    $cClass->SrcId = intval($res->fields('src_id'));
    $cClass->TrntypeId = intval($res->fields('trntype_id'));
    $cClass->RelId = intval($res->fields('rel_id'));
    $cClass->VhrId = intval($res->fields('vhr_id'));
    $cClass->FinId = intval($res->fields('fin_id'));
    $cClass->CurnRate = floatval($res->fields('curn_rate'));
    $cClass->BcurnRate = floatval($res->fields('bcurn_rate'));
    $cClass->MstDocn = $res->fields('mst_docn');
    $cClass->MstDocd = $res->fields('mst_docd');
    $cClass->MstNum = intval($res->fields('mst_num'));
    $cClass->MstDate = $res->fields('mst_date');
    $cClass->MstPerson = $res->fields('mst_person');
    $cClass->MstPhone = $res->fields('mst_phone');
    $cClass->MstRem = $res->fields('mst_rem');
    $cClass->WperId = intval($res->fields('wper_id'));
    $cClass->WperName = $res->fields('wper_name');
    $cClass->StorId = intval($res->fields('stor_id'));
    $cClass->StorNum = intval($res->fields('stor_num'));
    $cClass->StorName = $res->fields('stor_name');
    $cClass->AccId = intval($res->fields('acc_id'));
    $cClass->AccNum = $res->fields('acc_num');
    $cClass->AccName = $res->fields('acc_name');
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->CostNum = $res->fields('cost_num');
    $cClass->CostName = $res->fields('cost_name');
    $cClass->CurnId = intval($res->fields('curn_id'));
    $cClass->CurnNum = intval($res->fields('curn_num'));
    $cClass->CurnCode = $res->fields('curn_code');
    $cClass->CurnName = $res->fields('curn_name');
    $cClass->BcurnId = intval($res->fields('bcurn_id'));
    $cClass->BcurnNum = intval($res->fields('bcurn_num'));
    $cClass->BcurnCode = $res->fields('bcurn_code');
    $cClass->BcurnName = $res->fields('bcurn_name');
    $cClass->DocId = intval($res->fields('doc_id'));
    $cClass->DocName = $res->fields('doc_name');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_voumst` ('
        . '  `src_id`, `trntype_id`, `rel_id`, `vhr_id`, `fin_id`, `curn_rate`, `bcurn_rate`'
        . ', `mst_docn`, `mst_docd`, `mst_num`, `mst_date`, `mst_person`, `mst_phone`, `mst_rem`'
        . ', `wper_id`, `wper_name`, `stor_id`, `stor_num`, `stor_name`, `acc_id`, `acc_num`'
        . ', `acc_name`, `cost_id`, `cost_num`, `cost_name`, `curn_id`, `curn_num`, `curn_code`'
        . ', `curn_name`, `bcurn_id`, `bcurn_num`, `bcurn_code`, `bcurn_name`, `doc_id`, `doc_name`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->SrcId . '"'
        . ', "' . $this->TrntypeId . '"'
        . ', "' . $this->RelId . '"'
        . ', "' . $this->VhrId . '"'
        . ', "' . $this->FinId . '"'
        . ', "' . $this->CurnRate . '"'
        . ', "' . $this->BcurnRate . '"'
        . ', "' . $this->MstDocn . '"'
        . ', "' . $this->MstDocd . '"'
        . ', "' . $this->MstNum . '"'
        . ', "' . $this->MstDate . '"'
        . ', "' . $this->MstPerson . '"'
        . ', "' . $this->MstPhone . '"'
        . ', "' . $this->MstRem . '"'
        . ', "' . $this->WperId . '"'
        . ', "' . $this->WperName . '"'
        . ', "' . $this->StorId . '"'
        . ', "' . $this->StorNum . '"'
        . ', "' . $this->StorName . '"'
        . ', "' . $this->AccId . '"'
        . ', "' . $this->AccNum . '"'
        . ', "' . $this->AccName . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->CostNum . '"'
        . ', "' . $this->CostName . '"'
        . ', "' . $this->CurnId . '"'
        . ', "' . $this->CurnNum . '"'
        . ', "' . $this->CurnCode . '"'
        . ', "' . $this->CurnName . '"'
        . ', "' . $this->BcurnId . '"'
        . ', "' . $this->BcurnNum . '"'
        . ', "' . $this->BcurnCode . '"'
        . ', "' . $this->BcurnName . '"'
        . ', "' . $this->DocId . '"'
        . ', "' . $this->DocName . '"'
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
      $vSQL = 'UPDATE `str_voumst` SET'
        . '  `src_id`="' . $this->SrcId . '"'
        . ', `trntype_id`="' . $this->TrntypeId . '"'
        . ', `rel_id`="' . $this->RelId . '"'
        . ', `vhr_id`="' . $this->VhrId . '"'
        . ', `fin_id`="' . $this->FinId . '"'
        . ', `curn_rate`="' . $this->CurnRate . '"'
        . ', `bcurn_rate`="' . $this->BcurnRate . '"'
        . ', `mst_docn`="' . $this->MstDocn . '"'
        . ', `mst_docd`="' . $this->MstDocd . '"'
        . ', `mst_num`="' . $this->MstNum . '"'
        . ', `mst_date`="' . $this->MstDate . '"'
        . ', `mst_person`="' . $this->MstPerson . '"'
        . ', `mst_phone`="' . $this->MstPhone . '"'
        . ', `mst_rem`="' . $this->MstRem . '"'
        . ', `wper_id`="' . $this->WperId . '"'
        . ', `wper_name`="' . $this->WperName . '"'
        . ', `stor_id`="' . $this->StorId . '"'
        . ', `stor_num`="' . $this->StorNum . '"'
        . ', `stor_name`="' . $this->StorName . '"'
        . ', `acc_id`="' . $this->AccId . '"'
        . ', `acc_num`="' . $this->AccNum . '"'
        . ', `acc_name`="' . $this->AccName . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `cost_num`="' . $this->CostNum . '"'
        . ', `cost_name`="' . $this->CostName . '"'
        . ', `curn_id`="' . $this->CurnId . '"'
        . ', `curn_num`="' . $this->CurnNum . '"'
        . ', `curn_code`="' . $this->CurnCode . '"'
        . ', `curn_name`="' . $this->CurnName . '"'
        . ', `bcurn_id`="' . $this->BcurnId . '"'
        . ', `bcurn_num`="' . $this->BcurnNum . '"'
        . ', `bcurn_code`="' . $this->BcurnCode . '"'
        . ', `bcurn_name`="' . $this->BcurnName . '"'
        . ', `doc_id`="' . $this->DocId . '"'
        . ', `doc_name`="' . $this->DocName . '"'
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
    $vSQL = 'DELETE FROM `str_voumst` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

