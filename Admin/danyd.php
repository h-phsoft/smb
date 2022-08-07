<?php
$vMessage = 'if you understand you can got it now ';
?>
<div class = "container">
  <div class="row">
    <div class="col-8 mx-auto text-center">
      <img class="py-3" src = "assets/media/<?php echo $vCopy; ?>/logo/loginlogo.png" width="50%">
    </div>
  </div>
  <?php
  $dCurrentDate = date('Y-m-d H:i:s');
  $oToken = cCpyToken::getNewInstance('::1', ' +100 year', -1, -9);
  $oToken->oDevice->enable();
  $vScript = "localStorage.setItem(PhSettings.copy, "
    . "JSON.stringify({'vCId': '" . $oCopy->GId . "',"
    . " 'vDId': '" . $oToken->oDevice->Guid . "',"
    . " 'EDate': '" . date('Y-m-d H:i:s', strtotime($dCurrentDate . ' +100 year')) . "'}))";
  ?>
  <div class="row pt-2">
    <div class="col-6 mx-auto text-center">
      <h1 class="text-danger" id='message'><?php echo $vMessage; ?></h1>
    </div>
  </div>
</div>
