<?php

class cAccVTrn {

  public $MstId = -999;
  public $WperId;
  public $WperOrd;
  public $WperName;
  public $WperSDate;
  public $MstSrcId;
  public $MstNum;
  public $MstPnum;
  public $MstDate;
  public $MstRem;
  public $TrnId;
  public $AccId;
  public $AccNum;
  public $DbcrId;
  public $StatusId;
  public $oStatus;
  public $CloseId;
  public $AccName;
  public $CostId;
  public $CostNum;
  public $CostName;
  public $AccRId;
  public $TrnOrd;
  public $TrnDeb;
  public $TrnCrd;
  public $CurnId;
  public $CurnCode;
  public $CurnName;
  public $CurnColor;
  public $CurnRate;
  public $TrnDebc;
  public $TrnCrdc;
  public $BCurnId;
  public $BCurnName;
  public $BCurnColor;
  public $BCurnRate;
  public $TrnDebb;
  public $TrnCrdb;
  public $TrnRid;
  public $TrnSRem;
  public $TrnRem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `mst_id` , `wper_id`, `wper_ord`, `wper_name`, `wper_sdate`, `wper_edate`,'
      . ' `mst_src_id`, `mst_num`,`mst_pnum`, `mst_date`, `mst_rem`,'
      . ' `trn_id`,`acc_id`, `acc_num`, `dbcr_id`, `status_id`,'
      . ' `close_id`, `acc_name`,'
      . ' `cost_id`, `cost_num`, `cost_name`, `acc_rid`, `trn_ord`,'
      . ' `trn_deb`, `trn_crd`,'
      . ' `curn_id`, `curn_code`, `curn_name`, `curn_color`, `curn_rate`,'
      . ' `trn_debc`, `trn_crdc`,'
      . ' `bcurn_id`, `bcurn_name`,  `bcurn_color`, `bcurn_rate`,'
      . ' `trn_debb`, `trn_crdb`, `trn_rid`, `trn_srem`,`trn_rem`'
      . ' FROM `acc_vtrn`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `acc_vtrn`';
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
      $vOrder = '`mst_date`, `mst_num`, `trn_id`';
    }
    $res = ph_Execute(cAccVTrn::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccVTrn::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccVTrn();
    $res = ph_Execute(cAccVTrn::getSelectStatement('(`trn_id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccVTrn::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccVTrn();
    $cClass->MstId = intval($res->fields("mst_id"));
    $cClass->MstSrcId = intval($res->fields("mst_src_id"));
    $cClass->MstNum = $res->fields("mst_num");
    $cClass->MstPnum = intval($res->fields("mst_pnum"));
    $cClass->MstDate = $res->fields("mst_date");
    $cClass->MstRem = $res->fields("mst_rem");

    $cClass->WperId = intval($res->fields("wper_id"));
    $cClass->WperOrd = intval($res->fields("wper_ord"));
    $cClass->WperName = $res->fields("wper_name");
    $cClass->WperSDate = $res->fields("wper_sdate");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->CloseId = intval($res->fields("close_id"));

    $cClass->TrnId = intval($res->fields("trn_id"));
    $cClass->TrnDebb = intval($res->fields("trn_debb"));
    $cClass->TrnCrdb = $res->fields("trn_crdb");
    $cClass->TrnSRem = $res->fields("trn_srem");
    $cClass->TrnRid = intval($res->fields("trn_rid"));
    $cClass->TrnOrd = intval($res->fields("trn_ord"));
    $cClass->TrnDeb = $res->fields("trn_deb");
    $cClass->TrnCrd = intval($res->fields("trn_crd"));
    $cClass->TrnDebc = intval($res->fields("trn_debc"));
    $cClass->TrnCrdc = intval($res->fields("trn_crdc"));
    $cClass->TrnRem = $res->fields("trn_rem");

    $cClass->AccId = intval($res->fields("acc_id"));
    $cClass->AccRId = intval($res->fields("acc_rid"));
    $cClass->AccNum = $res->fields("acc_num");
    $cClass->AccName = $res->fields("acc_name");

    $cClass->DbcrId = intval($res->fields("dbcr_id"));
    $cClass->CostId = intval($res->fields("cost_id"));
    $cClass->CostNum = intval($res->fields("cost_id"));
    $cClass->CostName = $res->fields("cost_name");

    $cClass->BCurnId = intval($res->fields("bcurn_id"));
    $cClass->CurnId = intval($res->fields("curn_id"));
    $cClass->CurnCode = $res->fields("curn_code");
    $cClass->CurnName = $res->fields("curn_name");
    $cClass->CurnColor = $res->fields("curn_color");
    $cClass->CurnRate = $res->fields("curn_rate");
    $cClass->BCurnName = $res->fields("bcurn_name");
    $cClass->BCurnColor = $res->fields("bcurn_color");
    $cClass->BCurnRate = $res->fields("bcurn_rate");

    return $cClass;
  }

}
