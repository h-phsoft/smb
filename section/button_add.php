<?phpif ($oUser->oGrp->Id <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Insert) {  ?>  <button id="ph_add" class="btn btn-light-info font-weight-bold text-center mx-1 pl-4 pr-2 d-print-none" data-toggle="tooltip" title="<?php echo getLabel('New'); ?>">    <i class="icon-x flaticon2-plus"></i>  </button>  <?php}?>