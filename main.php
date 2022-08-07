<?php
$vTitle = cCpyPref::getPrefValue('Copy_Title');
if ($requestProg->Id != -999) {
  if (($oUser->oGrp->Id <= 0) ||
          (is_array($oUser->oGrp->aPerms) &&
          isset($oUser->oGrp->aPerms[$requestProg->Id]) &&
          $oUser->oGrp->aPerms[$requestProg->Id]->isOK)
  ) {
    $vTitle = $vTitle . ' | ' . getLabel($requestProg->Name);
  }
}
$aStatus = cPhsCode::getArray(cPhsCode::STATUS);
$aProcCats = cclncProcedureCategory::getArray();
$aColors = cPhsCodColor::getArray();
$aAppTypes = cClncAppType::getArray();
$aAppStatuses = cPhsCodAppStatus::getArray();
$aClinics = cClncClinic::getArray('status_id=1');
$aSpec = cClncSpecialtie::getArray();
//
$permCurrent = $oUser->oGrp->getPermission($requestProg->File);
$permTreats = $oUser->oGrp->getPermission('openTreatments');
$permPatient = $oUser->oGrp->getPermission('addPatient');
$permApps = $oUser->oGrp->getPermission('addAppointment');
$permInvoice = $oUser->oGrp->getPermission('addInvoice');
?>
<!DOCTYPE html>
<html <?php echo $vHTMLDirection; ?>>
  <head><base href="<?php echo $vRootPath; ?>">
    <meta charset="utf-8" />
    <title><?php echo $vTitle; ?></title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php
    if (file_exists($vStyles)) {
      include $vStyles;
    }
    ?>
    <?php
    if ($bIsASideHidden) {
      ?>
      <link href="assets/css/themes/layout/aside/hidden-aside-<?php echo $vDir; ?>.css" rel="stylesheet" type="text/css" />
      <?php
    }
    ?>
    <?php
    if (file_exists($vPageStyles)) {
      ?>
      <link href="<?php echo $vPageStyles; ?>" rel="stylesheet" type="text/css" />
      <?php
    }
    ?>
    <link rel="shortcut icon" href="assets/media/erp/erp_icon.ico" />
  </head>
  <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed <?php echo ($bASide ? 'aside-enabled aside-fixed' . ($bASideMinimized ? ' aside-minimize-hoverable aside-minimize' : '') : ''); ?>">
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed d-print-none">
      <div>
        <?php
        if ($bASide) {
          ?>
          <button class="btn p-0 burger-icon ml-4 burger-icon-right" id="kt_aside_mobile_toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo getLabel('Main Menu'); ?>">
            <span></span>
          </button>
          <?php
        }
        ?>
        <!--
        <button class="btn p-0 ml-4"data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo getLabel('Cart'); ?>">
           <i class="icon-lg fas fa-shopping-cart"></i>
         </button>
        -->
      </div>
      <a href="<?php echo $vCopy; ?>">
        <img alt="Logo" src="<?php echo $vMediaCopyRootPath; ?>/logo/logo.png" style="max-height: 55px; max-width: 90%;"/>
      </a>
      <div>
        <!--
         <button class="btn p-0 ml-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo getLabel('Favorit'); ?>">
           <i class="icon-xl far fa-check-square"></i>
         </button>
        -->
        <?php
        if ($bTopMenu) {
          ?>
          <button class="btn p-0 burger-icon ml-4 burger-icon-left" id="kt_header_mobile_toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo getLabel('Top Menu'); ?>">
            <span></span>
          </button>
          <?php
        }
        ?>
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo getLabel('User Menu'); ?>">
          <i class="icon-2x text-dark-50 flaticon2-user"></i>
        </button>
      </div>
    </div>
    <div class="d-flex flex-column flex-root">
      <div class="d-flex flex-row flex-column-fluid page">
        <?php
        if ($bASide) {
          include 'section/sectionAside.php';
        }
        ?>
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
          <?php include 'section/sectionHeader.php'; ?>
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <?php
            if ($requestProg->Id != -999) {
              if (($oUser->oGrp->Id <= 0) ||
                      (is_array($oUser->oGrp->aPerms) &&
                      isset($oUser->oGrp->aPerms[$requestProg->Id]) &&
                      $oUser->oGrp->aPerms[$requestProg->Id]->isOK)
              ) {
                if ($vURI !== '' && file_exists($vPage)) {
                  include $vPage;
                } else {
                  include 'section/section404.php';
                }
              } else {
                include 'section/section404.php';
              }
            }
            ?>
          </div>
          <?php include 'section/sectionFooter.php'; ?>
        </div>
      </div>
    </div>
    <?php include 'section/sectionScrollTop.php'; ?>

    <?php include 'section/modal_change_password.php'; ?>

    <?php include 'section/modal_change_image.php'; ?>

    <?php include 'section/clinic/modal_Appointment.php'; ?>
    <?php include 'section/clinic/modal_Invoice.php'; ?>
    <?php include 'section/clinic/modal_Patient.php'; ?>
    <?php include 'section/clinic/modal_Payment.php'; ?>
    <?php include 'section/clinic/modal_Treatment.php'; ?>

    <script>var HOST_URL = "<?php echo PHS_HOST_URL . $vRootPath; ?>";</script>
    <script>
      var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
          "theme": {
            "base": {"white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121"},
            "light": {"white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0"},
            "inverse": {"white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff"}
          },
          "gray": {"gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121"}
        },
        "font-family": "Poppins"
      };
    </script>
    <?php
    $vCDId = '"null"';
    if (!($oCopy->Devices > 0 || $oCopy->Restriction > 0)) {
      $vCDId = '{"vCId": "' . $oCopy->GId . '", "vDId": "' . $oCopy->GId . '", "EDate": "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +365 day')) . '"}';
    }
//
    $vPrefs = '';
    $aPrefs = cCpyPref::getArray();
    for ($index = 0; $index < count($aPrefs); $index++) {
      $cpyPref = $aPrefs[$index];
      $vPrefs .= '"' . strtolower($cpyPref->Key) . '": "' . $cpyPref->Value . '",';
    }
//
    $vLabels = '';
    foreach ($aPhLabels as $key => $value) {
      $vLabels .= '"' . strtolower($key) . '": "' . $value . '",';
    }
    $vColors = '';
    foreach ($aColors as $element) {
      $vColors .= '{"Id": "' . $element->Id . '", "Name": "' . $element->Name . '", "fgClass": "' . $element->Fgclass . '", "bgClass": "' . $element->Bgclass . '", "bgText": "' . $element->Bgtext . '"},';
    }
    $vAppTypes = '';
    foreach ($aAppTypes as $element) {
      $vAppTypes .= '{"Id": "' . $element->Id . '", "Name": "' . $element->Name . '", "Capacity": "' . $element->Capacity . '", "Time": "' . $element->Time . '", "TitleBG": "' . $element->TbgId . '", "TitleFG": "' . $element->TfgId . '", "NameFG": "' . $element->NfgId . '"},';
    }
    $vAppStatuses = '';
    foreach ($aAppStatuses as $element) {
      $vAppStatuses .= '{"Id": "' . $element->Id . '", "Name": "' . $element->Name . '", "Icon": "' . $element->Icon . '", "Color": "' . $element->ColorId . '"},';
    }
    ?>
    <script>
      var PhSettings = {"rootPath": '<?php echo $vRootPath; ?>',
        "copyMediaPath": '<?php echo $vMediaPath; ?>',
        "copyRootPath": '<?php echo $vRootPath . $vCopy . '/'; ?>',
        "serviceURL": "Module/API/",
        "copy": "<?php echo $oCopy->GId; ?>",
        "copyName": '<?php echo $vCopy; ?>',
        "WPId": '<?php echo $oWorkperiod->Id; ?>',
        "WPSDate": '<?php echo $oWorkperiod->SDate; ?>',
        "WPEDate": '<?php echo $oWorkperiod->EDate; ?>',
        "us": <?php echo $oCopy->Users; ?>,
        "ds": <?php echo $oCopy->Devices; ?>,
        "rs": <?php echo $oCopy->Restriction; ?>,
        "CDId": <?php echo $vCDId ?>,
        "GUId": {'UId': <?php echo $aGUId['UId']; ?>,
          'GId': '<?php echo $aGUId['GId']; ?>',
          'WPId': <?php echo $aGUId['WPId']; ?>,
          'vLang': '<?php echo $aGUId['vLang']; ?>',
          'vDir': '<?php echo $aGUId['vDir']; ?>',
          'SDate': '<?php echo $aGUId['SDate']; ?>',
          'EDate': '<?php echo $aGUId['EDate']; ?>'
        },
        "token": "0",
        "locale": "<?php echo $vLang; ?>",
        "direction": "<?php echo $vDir; ?>",
        "uid": "<?php echo ($oUser != null) ? $oUser->Id : 0; ?>",
        "utype": "<?php echo ($oUser != null) ? $oUser->GrpId : 999; ?>",
        "UName": "<?php echo ($oUser != null) ? $oUser->Name : ''; ?>",
        "Title": "<?php echo getLabel($requestProg->Name); ?>",
        "progId": "<?php echo getLabel($requestProg->Id); ?>",
        "current": {
          "insert": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Insert) ? 'true' : 'false'; ?>,
          "update": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Update) ? 'true' : 'false'; ?>,
          "delete": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Delete) ? 'true' : 'false'; ?>,
          "query": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Query) ? 'true' : 'false'; ?>,
          "print": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Print) ? 'true' : 'false'; ?>,
          "export": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Export) ? 'true' : 'false'; ?>,
          "import": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Import) ? 'true' : 'false'; ?>,
          "commit": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Commit) ? 'true' : 'false'; ?>,
          "revoke": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Revoke) ? 'true' : 'false'; ?>,
          "special": <?php echo ($oUser->GrpId <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Special) ? 'true' : 'false'; ?>
        },
        "Prefs": {<?php echo $vPrefs; ?>},
        "color": [<?php echo $vColors; ?>],
        "appType": [<?php echo $vAppTypes; ?>],
        "appStatus": [<?php echo $vAppStatuses; ?>],
        "labels": {<?php echo $vLabels; ?>}
      };
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/jquery-ui/jquery-ui.js"></script>
    <script src="assets/plugins/global/jquery.redirect.js"></script>
    <script src="assets/plugins/custom/jstree/jstree.js"></script>
    <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="assets/plugins/custom/phsoft/PhDataTable.js"></script>
    <script src="assets/plugins/custom/tabulator/js/tabulator.js"></script>
    <script src="assets/plugins/custom/tabulator/xlsx.full.min.js"></script>
    <script src="assets/plugins/custom/tabulator/jspdf.min.js"></script>
    <script src="assets/plugins/custom/tabulator/jspdf.plugin.autotable.js"></script>

    <script src="assets/js/main.js"></script>
    <?php
    if (file_exists($vPageScript)) {
      ?>
      <script src="<?php echo $vPageScript; ?>"></script>
      <?php
    }
    ?>
  </body>
</html>