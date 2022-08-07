<?php
if ($oUser->oGrp->Id <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Insert || $oUser->oGrp->aPerms[$requestProg->Id]->Update) {
  ?>
  <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center mx-1 pl-4 pr-2 d-print-none">
    <i class="icon-x flaticon2-check-mark"></i>
  </button>
  <?php
}
?>
