<?php
$vMessage = '';
$vComma = '';
?>
<div class = "container">
  <div class="row">
    <div class="col-8 mx-auto text-center">
      <img class="py-3" src = "assets/media/<?php echo $vCopy; ?>/logo/loginlogo.png" width="50%">
    </div>
  </div>
  <?php
  if (is_array($aParams) && count($aParams) > 2) {
    $notif = cCpyNotification::getInstance(-999);
    $notif->UserId = $aParams[0];
    $notif->Title = $aParams[1];
    $notif->Body = $aParams[2];
    $notif->save();
  }
  ?>
  <div class="row pt-2">
    <div class="col-6 mx-auto text-center">
      <h1 class="text-danger" id='message'><?php echo $vMessage; ?></h1>
    </div>
  </div>
</div>
