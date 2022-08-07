<?php
if ($oUser != null) {
?>
  <div id="kt_header" class="header header-fixed d-print-none">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
      <div class="header-menu-wrapper header-menu-wrapper-right pt-3" id="kt_header_menu_wrapper">
        <?php
        if ($bTopMenu) {
          $vSubWhere = '';
          $vWhere = '(`prog_id`=11 AND `grp_id`>="' . $oUser->GrpId . '")';
          if ($oUser->GrpId > 0) {
            $vSubWhere = '(`id` IN (SELECT `prog_id` FROM `cpy_perm` WHERE `grp_id`="' . $oUser->GrpId . '" AND `isok`=1))';
            $vWhere .= ' AND ' . $vSubWhere;
          }
          $aMenu = cPhsProgram::getArray($vWhere, $vSubWhere);
        ?>
          <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
            <ul class="menu-nav">
              <?php
              echo cPhsProgram::getTopMenu($vCopy, $aMenu);
              ?>
            </ul>
          </div>
        <?php
        }
        ?>
      </div>
      <div class="header-menu-wrapper header-menu-wrapper-left pt-3 d-none d-sm-block">
        <?php include 'clinic/sectionHeaderClinics.php'; ?>
      </div>
      <div class="topbar">
        <div class="topbar-item d-block d-sm-none">
          <?php include 'clinic/sectionHeaderClinics.php'; ?>
        </div>
        <?php
        if (count($aMenu) > 0) {
          foreach ($aMenu as $menu) {
            if ($menu->nType === 2) {
        ?>
              <div class="topbar-item">
                <div id="<?php echo $menu->File; ?>" class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-4" data-toggle="tooltip" title="<?php echo $menu->Name; ?>">
                  <!--<span class="text-dark-50 font-weight-bolder font-size-base topbar-item-link" data-id='<?php echo $menu->Id; ?>' data-file='<?php echo $menu->File; ?>' <?php echo $menu->Attributes; ?>>-->
                  <span class="text-dark-50 font-weight-bolder font-size-base topbar-item-link">
                    <i class="icon-lg <?php echo $menu->Icon; ?>"></i>
                  </span>
                </div>
              </div>
        <?php
            }
          }
        }
        ?>
        <?php
        if ($bTopButtons) {
          $vWhere = '(`prog_id`=14';
          if ($oUser->oGrp->Id > 0) {
            $vWhere .= ' AND `id` IN (SELECT `prog_id` FROM `cpy_perm` AS `pr` WHERE `pr`.`type_id`="' . $oUser->oGrp->Id . '")';
          }
          $vWhere .= ')';
          $aTopButtons = cPhsProgram::getArray($vWhere);
          echo cPhsProgram::getTopButtons($vCopy, $aTopButtons);
        }
        ?>
        <?php
        if ($bIsWorkPeriod) {
          include 'section/sectionHeaderWorkperiod.php';
        }
        ?>
        <?php include 'section/sectionHeaderLanguage.php'; ?>
        <?php include 'section/sectionHeaderUser.php'; ?>
      </div>
    </div>
  </div>
<?php
}
