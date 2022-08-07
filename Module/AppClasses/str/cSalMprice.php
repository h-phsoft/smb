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
 * @update 2022/02/10 14:37
 *
 */

class cSalMprice
{

    public $Id;
    public $Name;
    public $CurnId;
    public $Sdate;
    public $Edate;
    public $Rem;
    public $InsUser;
    public $InsDate;
    public $UpdUser;
    public $UpdDate;
    //
    public $oCurn;

    public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '')
    {
        $sSQL = 'SELECT `id`, `name`, `curn_id`, `sdate`, `edate`, `rem`, `ins_user`, `ins_date`'
            . ', `upd_user`, `upd_date`'
            . ' FROM `sal_mprice`';
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

    public static function getCount($vWhere = '')
    {
        $nCount = 0;
        $sSQL = 'SELECT count(*) nCnt FROM `sal_mprice`';
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

    public static function getArray($vWhere = '', $vOrder = '', $nPage = 0, $nPageSize = 0)
    {
        $aArray = array();
        $nIdx = 0;
        $vLimit = '';
        if ($nPage != 0 && $nPageSize != 0) {
            $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
        }
        if ($vOrder == '') {
            $vOrder = '`id`';
        }
        $res = ph_Execute(cSalMprice::getSelectStatement($vWhere, $vOrder, $vLimit));
        if ($res != '') {
            while (!$res->EOF) {
                $aArray[$nIdx] = cSalMprice::getFields($res);
                $nIdx++;
                $res->MoveNext();
            }
            $res->Close();
        }
        return $aArray;
    }

    public static function getInstance($nId)
    {
        $cClass = new cSalMprice();
        $res = ph_Execute(cSalMprice::getSelectStatement('(`id`="' . $nId . '")'));
        if ($res != '') {
            if (!$res->EOF) {
                $cClass = cSalMprice::getFields($res);
            }
            $res->Close();
        }
        return $cClass;
    }
    

    public static function getFields($res)
    {
        $cClass = new cSalMprice();
        $cClass->Id = intval($res->fields('id'));
        $cClass->Name = $res->fields('name');
        $cClass->CurnId = intval($res->fields('curn_id'));
        $cClass->Sdate = $res->fields('sdate');
        $cClass->Edate = $res->fields('edate');
        $cClass->Rem = $res->fields('rem');
        $cClass->InsUser = intval($res->fields('ins_user'));
        $cClass->InsDate = $res->fields('ins_date');
        $cClass->UpdUser = intval($res->fields('upd_user'));
        $cClass->UpdDate = $res->fields('user_id');
        //
        $cClass->oCurn = cMngCurrency::getInstance($cClass->CurnId);
        return $cClass;
    }

    public function save($nUId)
    {
        $nId = 0;
        if ($this->Id == 0 || $this->Id == -999) {
            $vSQL = 'INSERT INTO `sal_mprice` ('
            . '  `name`, `curn_id`, `sdate`, `edate`, `rem`, `ins_user`'
            . ') VALUES ('
            . '  "' . $this->Name . '"'
            . ', "' . $this->CurnId . '"'
            . ', "' . $this->Sdate . '"'
            . ', "' . $this->Edate . '"'
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
            $vSQL = 'UPDATE `sal_mprice` SET'
            . '  `name`="' . $this->Name . '"'
            . ', `curn_id`="' . $this->CurnId . '"'
            . ', `sdate`="' . $this->Sdate . '"'
            . ', `edate`="' . $this->Edate . '"'
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


    public function delete()
    {
        $vSQL = 'DELETE FROM `sal_mprice` WHERE `id`="' . $this->Id . '"';
        $res = ph_Execute($vSQL);
        if ($res || $res === 0) {

        } else {
            $aMsg = ph_GetMySQLMessageAsArray();
            $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
            throw new Exception($vMsgs);
        }
    }

}
