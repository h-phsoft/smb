<?php

class cCpyMenu {

  var $Id = -999;
  var $PId = null;
  var $Order = 0;
  var $Name;
  var $aSub = array();

  public static function getSelectStatement($vWhere = '', $vOrder = '') {
    $sSQL = 'SELECT `id`, `menu_id`, `name`, `ord`'
            . ' FROM `cpy_menu`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $vOrder = ' ORDER BY ' . $vOrder;
    }
    $sSQL .= $vOrder;
    return $sSQL;
  }

  public static function getArray($vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(self::getSelectStatement($vWhere, '`ord`'));
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
    $cClass = new cCpyMenu();
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
    $cClass = new cCpyMenu();
    $cClass->Id = intval($res->fields("id"));
    $cClass->PId = intval($res->fields("menu_id"));
    $cClass->Order = intval($res->fields("ord"));
    $cClass->Name = $res->fields("name");
    $cClass->aSub = self::getArray('(`menu_id`="' . $cClass->Id . '")');
    return $cClass;
  }

  public static function getMenu($aMenu) {
    $vHtmlMenu = '';
    if (count($aMenu) > 0) {
      foreach ($aMenu as $menu) {
        if (count($menu->aSub) <= 0) {
          $vHtmlMenu .= '<li class="menu-item" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="' . $menu->Id . '" class="menu-link">';
          $vHtmlMenu .= '    <span class="menu-text">' . $menu->Name . '</span>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '</li>';
        } else if (count($menu->aSub) > 0) {
          $vHtmlMenu .= '<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="javascript:;" class="menu-link menu-toggle">';
          $vHtmlMenu .= '    <span class="menu-text">' . $menu->Name . '</span>';
          $vHtmlMenu .= '    <span class="menu-desc"></span>';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '  <div class="menu-submenu menu-submenu-classic menu-submenu-left py-0">';
          $vHtmlMenu .= '    <ul class="menu-subnav">';
          $vHtmlMenu .= '      ' . self::getSubMenu($menu->aSub);
          $vHtmlMenu .= '    </ul>';
          $vHtmlMenu .= '  </div>';
          $vHtmlMenu .= '</li>';
        }
      }
    }
    return $vHtmlMenu;
  }

  public static function getSubMenu($aMenu) {
    $vHtmlMenu = '';
    if (count($aMenu) > 0) {
      foreach ($aMenu as $menu) {
        if (count($menu->aSub) <= 0) {
          $vHtmlMenu .= '<li class="menu-item" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="' . $menu->Id . '" class="menu-link">';
          $vHtmlMenu .= '    <span class="menu-text">' . $menu->Name . '</span>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '</li>';
        } else if (count($menu->aSub) > 0) {
          $vHtmlMenu .= '<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">';
          $vHtmlMenu .= '  <a href="javascript:;" class="menu-link menu-toggle">';
          $vHtmlMenu .= '    <span class="menu-text">' . $menu->Name . '</span>';
          $vHtmlMenu .= '    <i class="menu-arrow"></i>';
          $vHtmlMenu .= '  </a>';
          $vHtmlMenu .= '  <div class="menu-submenu menu-submenu-classic menu-submenu-right py-0">';
          $vHtmlMenu .= '    <ul class="menu-subnav">';
          $vHtmlMenu .= '      ' . self::getSubMenu($menu->aSub);
          $vHtmlMenu .= '    </ul>';
          $vHtmlMenu .= '  </div>';
          $vHtmlMenu .= '</li>';
        }
      }
    }
    return $vHtmlMenu;
  }

}
