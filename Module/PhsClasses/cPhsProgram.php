<?php

class cPhsProgram {

  var $Id = -999;
  var $PId = -999;
  var $PName = '';
  var $nGrp = 127;
  var $nStatus = 1;
  var $vStatus = '';
  var $nSystem = 0;
  var $nSysStatus = 1;
  var $vSystem = '';
  var $nType = 0;
  var $vType = '';
  var $Open = 0;
  var $Order = 0;
  var $Name;
  var $Icon;
  var $File;
  var $CSS;
  var $JS;
  var $Attributes;
  var $vParams = '';
  var $aParams = array();
  var $aSub = array();

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `prog_id`, `grp_id`, `open`, `ord`,'
            . ' `name`, `icon`, `file`, `css`, `js`, `attributes`, `params`,'
            . ' `sys_id`, `sys_name`, `sys_status_id`, `status_id`, `status_name`, `type_id`, `type_name`'
            . ' FROM `phs_vprogram`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `phs_vprogram`';
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

  public static function getQArray($vWhere = '', $vOrder = '', $nPage = 0, $nPageSize = 0) {
    $aArray = array();
    $nIdx = 0;
    $vLimit = '';
    if ($nPage != 0 && $nPageSize != 0) {
      $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
    }
    if ($vOrder == '') {
      $vOrder = '`sys_id`, `prog_id`, `ord`, `id`';
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

  public static function getArray($vWhere = '', $vSubWhere = '', $vOrder = '') {
    $aArray = array();
    $nIdx = 0;
    if ($vWhere == '') {
      $vWhere = '(`status_id`=1)';
    } else {
      $vWhere .= ' AND (`status_id`=1)';
    }
    if ($vOrder == '') {
      $vOrder = '`sys_id`, `ord`';
    }
    $res = ph_Execute(self::getSelectStatement($vWhere, $vOrder));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = self::getFields($res, $vSubWhere);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPhsProgram();
    $res = ph_Execute(self::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceByFile($vFile) {
    $cClass = new cPhsProgram();
    if ($vFile != '' && $vFile != null) {
      $res = ph_Execute(self::getSelectStatement('(`file`="' . $vFile . '")'));
      if ($res != '') {
        if (!$res->EOF) {
          $cClass = self::getFields($res);
        }
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getUserGroupMenu($nGrp, $nParent = 1) {
    $aArray = array();
    $vWhere = '(`prog_id`="' . $nParent . '"';
    if ($nGrp > 0) {
      $vWhere .= ' AND `id` IN (SELECT `prog_id` FROM `cpy_perm` AS `pr` WHERE `pr`.`type_id`="' . $nGrp . '" AND `isok`=1)';
    }
    $vWhere .= ')';
    $res = ph_Execute(self::getSelectStatement($vWhere, '`ord`'));
    if ($res != '') {
      $nIdx = 0;
      while (!$res->EOF) {
        $cClass = new cPhsProgram();
        $cClass->Id = intval($res->fields("id"));
        $cClass->PId = intval($res->fields("prog_id"));
        $cClass->PName = ph_GetDBValue('Name', 'phs_program', 'id=' . $res->fields("prog_id"));
        $cClass->nGrp = intval($res->fields("grp_id"));
        $cClass->nSystem = intval($res->fields("sys_id"));
        $cClass->nSysStatus = $res->fields("sys_status_id");
        $cClass->vSystem = $res->fields("sys_name");
        $cClass->nStatus = intval($res->fields("status_id"));
        $cClass->vStatus = $res->fields("status_name");
        $cClass->nType = intval($res->fields("type_id"));
        $cClass->vType = $res->fields("type_name");
        $cClass->Name = $res->fields("name");
        $cClass->Open = intval($res->fields("open"));
        $cClass->Order = intval($res->fields("ord"));
        $cClass->Icon = $res->fields("icon");
        $cClass->File = $res->fields("file");
        $cClass->CSS = $res->fields("css");
        $cClass->JS = $res->fields("js");
        $cClass->Attributes = $res->fields("attributes");
        $cClass->vParams = $res->fields("params");
        if ($cClass->vParams != '') {
          $cClass->aParams = json_decode($cClass->vParams);
        }
        $cClass->aSub = self::getUserGroupMenu($nGrp, $cClass->Id);
        $aArray[$nIdx] = $cClass;
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getFields($res, $vSubWhere = '') {
    $cClass = new cPhsProgram();
    $cClass->Id = intval($res->fields("id"));
    $cClass->PId = intval($res->fields("prog_id"));
    $cClass->PName = ph_GetDBValue('Name', 'phs_program', 'id=' . $res->fields("prog_id"));
    $cClass->nGrp = intval($res->fields("grp_id"));
    $cClass->nSystem = intval($res->fields("sys_id"));
    $cClass->nSysStatus = $res->fields("sys_status_id");
    $cClass->vSystem = $res->fields("sys_name");
    $cClass->nStatus = intval($res->fields("status_id"));
    $cClass->vStatus = $res->fields("status_name");
    $cClass->Open = intval($res->fields("open"));
    $cClass->nType = intval($res->fields("type_id"));
    $cClass->vType = $res->fields("type_name");
    $cClass->Name = $res->fields("name");
    $cClass->Order = intval($res->fields("ord"));
    $cClass->Icon = $res->fields("icon");
    $cClass->File = $res->fields("file");
    $cClass->CSS = $res->fields("css");
    $cClass->JS = $res->fields("js");
    $cClass->Attributes = $res->fields("attributes");
    $cClass->vParams = $res->fields("params");
    if ($cClass->vParams != '') {
      $cClass->aParams = json_decode($cClass->vParams);
    }
    $vWhere = '(`prog_id`="' . $cClass->Id . '")';
    if ($vSubWhere != '') {
      $vWhere .= ' AND ' . $vSubWhere;
    }
    $cClass->aSub = self::getArray($vWhere, $vSubWhere);
    return $cClass;
  }

  public function save() {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `phs_program` ('
              . '  `prog_id`, `sys_id`, `grp_id`, `status_id`, `type_id`, `open`, `ord`'
              . ', `name`, `icon`, `file`, `css`, `js`, `attributes`, `params`'
              . ') VALUES ('
              . '  "' . $this->PId . '"'
              . ', "' . $this->nSystem . '"'
              . ', "' . $this->nGrp . '"'
              . ', "' . $this->nStatus . '"'
              . ', "' . $this->nType . '"'
              . ', "' . $this->Open . '"'
              . ', "' . $this->Order . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Icon . '"'
              . ', "' . $this->File . '"'
              . ', "' . $this->Css . '"'
              . ', "' . $this->Js . '"'
              . ', "' . $this->Attributes . '"'
              . ', "' . $this->vParams . '"'
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
      $vSQL = 'UPDATE `phs_program` SET'
              . '  `prog_id`="' . $this->PId . '"'
              . ', `sys_id`="' . $this->nSystem . '"'
              . ', `grp_id`="' . $this->nGrp . '"'
              . ', `status_id`="' . $this->nStatus . '"'
              . ', `type_id`="' . $this->nType . '"'
              . ', `open`="' . $this->Open . '"'
              . ', `ord`="' . $this->Order . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `icon`="' . $this->Icon . '"'
              . ', `file`="' . $this->File . '"'
              . ', `css`="' . $this->Css . '"'
              . ', `js`="' . $this->Js . '"'
              . ', `attributes`="' . $this->Attributes . '"'
              . ', `params`="' . $this->vParams . '"'
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
    $vSQL = 'DELETE FROM `phs_program` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

  public static function getTopButtons($vCopyURL, $aMenu) {
    $vHtmlMenu = '';
    if (count($aMenu) > 0) {
      foreach ($aMenu as $menu) {
        $vHtmlMenu .= '<div class="topbar-item">';
        $vHtmlMenu .= '  <div id="' . $menu->Id . '" class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-4" data-toggle="tooltip" title="' . getLabel($menu->Name) . '">';
        $vHtmlMenu .= '    <span class="text-dark-50 font-weight-bolder font-size-base topbar-item-link" data-id="' . $menu->Id . '" data-file="' . $vCopyURL . '/' . $menu->File . '" ' . $menu->Attributes . '>';
        $vHtmlMenu .= '      <i class="icon-lg ' . $menu->Icon . '"></i>';
        $vHtmlMenu .= '    </span>';
        $vHtmlMenu .= '  </div>';
        $vHtmlMenu .= '</div>';
      }
    }
    return $vHtmlMenu;
  }

  public static function getUserMenu($vCopyURL, $aMenu) {
    $vHtmlMenu = '';
    if (count($aMenu) > 0) {
      foreach ($aMenu as $menu) {
        if (count($menu->aSub) <= 0) {
          if ($menu->nType === 4) {
            $vHtmlMenu .= '<div class="topbar-item">';
            $vHtmlMenu .= '  <div id="' . $menu->Id . '" class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-4" data-toggle="tooltip" title="' . getLabel($menu->Name) . '">';
            $vHtmlMenu .= '    <span class="text-dark-50 font-weight-bolder font-size-base topbar-item-link" data-id="' . $menu->Id . '" data-file="' . $vCopyURL . '/' . $menu->File . '" ' . $menu->Attributes . '>';
            $vHtmlMenu .= '      <i class="icon-lg ' . $menu->Icon . '"></i>';
            $vHtmlMenu .= '    </span>';
            $vHtmlMenu .= '  </div>';
            $vHtmlMenu .= '</div>';
          } else if ($menu->nType === 5) {
            $vHtmlMenu .= '<li class="navi-item">';
            $vHtmlMenu .= '  <a href="javascipt:;" class="navi-link">';
            $vHtmlMenu .= '    <i class="icon-lg ' . $menu->Icon . '"></i>';
            $vHtmlMenu .= '    <span class="menu-text" ' . $menu->Attributes . '>&nbsp;&nbsp;&nbsp;' . getLabel($menu->Name) . '</span>';
            $vHtmlMenu .= '  </a>';
            $vHtmlMenu .= '</li>';
          } else {
            $vHtmlMenu .= '<li class="navi-item">';
            $vHtmlMenu .= '  <a href="' . $vCopyURL . '/' . $menu->File . '" class="navi-link">';
            $vHtmlMenu .= '    <i class="icon-lg ' . $menu->Icon . '"></i>';
            $vHtmlMenu .= '    <span class="menu-text">&nbsp;&nbsp;&nbsp;' . getLabel($menu->Name) . '</span>';
            $vHtmlMenu .= '  </a>';
            $vHtmlMenu .= '</li>';
          }
        } else if (count($menu->aSub) > 0) {
          $vHtmlMenu .= '<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="javascript:;" class="menu-link menu-toggle">';
          $vHtmlMenu .= '    <span class="menu-text">' . getLabel($menu->Name) . '</span>';
          $vHtmlMenu .= '    <span class="menu-desc"></span>';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '  <div class="menu-submenu menu-submenu-classic menu-submenu-left py-0">';
          $vHtmlMenu .= '    <ul class="menu-subnav">';
          $vHtmlMenu .= '      ' . self::getUserMenu($vCopyURL, $menu->aSub);
          $vHtmlMenu .= '    </ul>';
          $vHtmlMenu .= '  </div>';
          $vHtmlMenu .= '</li>';
        }
      }
    }
    return $vHtmlMenu;
  }

  public static function getTopMenu($vCopyURL, $aMenu) {
    $vHtmlMenu = '';
    if (count($aMenu) > 0) {
      foreach ($aMenu as $menu) {
        if (count($menu->aSub) <= 0) {
          if ($menu->nType === 4) {
            $vHtmlMenu .= '<div class="topbar-item">';
            $vHtmlMenu .= '  <div id="' . $menu->Id . '" class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-4" data-toggle="tooltip" title="' . getLabel($menu->Name) . '">';
            $vHtmlMenu .= '    <span class="text-dark-50 font-weight-bolder font-size-base topbar-item-link" data-id="' . $menu->Id . '" data-file="' . $vCopyURL . '/' . $menu->File . '" ' . $menu->Attributes . '>';
            $vHtmlMenu .= '      <i class="icon-lg ' . $menu->Icon . '"></i>';
            $vHtmlMenu .= '    </span>';
            $vHtmlMenu .= '  </div>';
            $vHtmlMenu .= '</div>';
          } else {
            $vHtmlMenu .= '<li class="menu-item" aria-haspopup="true">';
            $vHtmlMenu .= '  <a href="' . $vCopyURL . '/' . $menu->File . '" class="menu-link">';
            $vHtmlMenu .= '    <span class="menu-text">' . getLabel($menu->Name) . '</span>';
            $vHtmlMenu .= '  </a>';
            $vHtmlMenu .= '</li>';
          }
        } else if (count($menu->aSub) > 0) {
          $vHtmlMenu .= '<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="javascript:;" class="menu-link menu-toggle">';
          $vHtmlMenu .= '    <span class="menu-text">' . getLabel($menu->Name) . '</span>';
          $vHtmlMenu .= '    <span class="menu-desc"></span>';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '  <div class="menu-submenu menu-submenu-classic menu-submenu-left py-0">';
          $vHtmlMenu .= '    <ul class="menu-subnav">';
          $vHtmlMenu .= '      ' . self::getTopMenu($vCopyURL, $menu->aSub);
          $vHtmlMenu .= '    </ul>';
          $vHtmlMenu .= '  </div>';
          $vHtmlMenu .= '</li>';
        }
      }
    }
    return $vHtmlMenu;
  }

  public static function getASideMenu($vCopyURL, $aMenu, $oUser, $nReqId) {
    $vHtmlMenu = '';
    foreach ($aMenu as $menu) {
      if ($menu->nGrp >= $oUser->oGrp->Id) {
        if (count($menu->aSub) > 0) {
          $vParent = '';
          if (self::isContains($menu->aSub, $nReqId)) {
            $vParent = 'menu-item-open menu-item-here';
          }
          $vHtmlMenu .= '<li class="menu-item menu-item-submenu ' . $vParent . '" aria-haspopup="true" data-menu-toggle="hover">';
          $vHtmlMenu .= '  <a href="javascript:;" class="menu-link menu-toggle">';
          $vHtmlMenu .= '    <span class="menu-icon">';
          $vHtmlMenu .= '      <i class="icon-lg ' . $menu->Icon . '"></i>';
          $vHtmlMenu .= '    </span>';
          $vHtmlMenu .= '    <span class="menu-text">' . getLabel($menu->Name) . '</span>';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '  <div class="menu-submenu">';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '    <ul class="menu-subnav">';
          $vHtmlMenu .= '      ' . self::getASideMenu($vCopyURL, $menu->aSub, $oUser, $nReqId);
          $vHtmlMenu .= '    </ul>';
          $vHtmlMenu .= '  </div>';
          $vHtmlMenu .= '</li>';
        } else {
          $activ = '';
          if ($menu->Id == $nReqId) {
            $activ = 'menu-item-active';
          }
          $vHtmlMenu .= '<li class="menu-item ' . $activ . '" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="' . $vCopyURL . '/' . $menu->File . '" class="menu-link" ' . $menu->Attributes . '>';
          $vHtmlMenu .= '    <span class="menu-icon">';
          $vHtmlMenu .= '      <i class="icon-lg ' . $menu->Icon . '"></i>';
          $vHtmlMenu .= '    </span>';
          $vHtmlMenu .= '    <span class="menu-text">' . getLabel($menu->Name) . '</span>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '</li>';
        }
      }
    }
    return $vHtmlMenu;
  }

  public static function isContains($aMenu, $nReqId) {
    $bReturn = false;
    foreach ($aMenu as $menu) {
      if (count($menu->aSub) > 0) {
        $bReturn = self::isContains($menu->aSub, $nReqId);
        if ($bReturn) {
          break;
        }
      } else {
        if ($menu->Id == $nReqId) {
          $bReturn = true;
          break;
        }
      }
    }
    return $bReturn;
  }

}
