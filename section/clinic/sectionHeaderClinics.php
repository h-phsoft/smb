<?php
if ($oUser != null ) {
  ?>
  <div class="dropdown d-block">
    <div class="topbar-item pt-2" data-toggle="dropdown" data-offset="55px,5px">
      <div class="btn btn-clean btn-dropdown btn-md"> <!-- data-toggle="tooltip" title="Change Clinic">-->
        <i class="icon-lg fas fa-clinic-medical"></i>
        <span id="current-clininc" class='current-clininc' data-id='<?php echo ph_Session('UClinicId'); ?>'><?php echo ph_Session('UClinicName'); ?></span>
      </div>
    </div>
    <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
      <ul class="navi navi-hover py-4">
        <?php
        for ($index = 0; $index < count($aClinics); $index++) {
          ?>
          <li class="navi-item">
            <span class="navi-link change-clinic" data-id='<?php echo $aClinics[$index]->Id; ?>' data-name='<?php echo $aClinics[$index]->Name; ?>'>
              <span class="navi-text"><?php echo $aClinics[$index]->Name; ?></span>
            </span>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </div>
  <?php
}