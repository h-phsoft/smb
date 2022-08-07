<?php
if ($oUser->oGrp->Id <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Query) {
  ?>
  <button id="ph_search" class="btn btn-light-warning font-weight-bold text-center mx-1 pl-4 pr-2 d-print-none" data-toggle="tooltip" title="<?php echo getLabel('Execute'); ?>">
    <i class="icon-x fa fa-search"></i>
  </button>
  <?php
}
?>
