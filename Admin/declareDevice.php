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
  if (is_array($aParams) && isset($aParams[0]) && isset($aParams[1])) {
    $dCurrentDate = date('Y-m-d H:i:s');
    $oRCopy = cPhsCpy::getInstanceByGId($aParams[0]);
    $oToken = cCpyToken::getInstanceByGUID($aParams[1]);
    if ($oCopy->GId != $oRCopy->GId) {
      $vMessage = $vComma . 'Sorry Gid Not Matched';
      $vComma = ', ';
    }
    if ($dCurrentDate < $oToken->Edate) {
      $oDevice = $oToken->oDevice;
      if ($oDevice->StatusId == 2 || ($oDevice->StatusId == 1 && isset($aParams[2]) && $aParams[2] == 1)) {
        $oDevice->enable();
        $vScript = "localStorage.setItem(PhSettings.copy, "
          . "JSON.stringify({'vCId': '" . $oRCopy->GId . "',"
          . " 'vDId': '" . $oDevice->Guid . "',"
          . " 'EDate': '" . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +365 day')) . "'}))";
        $vMessage = 'Welcome to ' . $oRCopy->Name;
        $oToken->delete();
      } else {
        $vMessage = 'Device is Active';
      }
    } else {
      $vMessage .= $vComma . 'Sorry expired key';
      ?>
      <div class="row pt-2">
        <div class="col-6 text-right">
          <h3>Start</h3>
        </div>
        <div class="col-6 text-left">
          <h3><?php echo $oToken->Sdate; ?></h3>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 text-right">
          <h3>End</h3>
        </div>
        <div class="col-6 text-left">
          <h3><?php echo $oToken->Edate; ?></h3>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 text-right">
          <h3>Current</h3>
        </div>
        <div class="col-6 text-left">
          <h3><?php echo $dCurrentDate; ?></h3>
        </div>
      </div>
      <?php
    }
  } else {
    $vMessage = 'Nothing to do';
  }
  ?>
  <div class="row pt-2">
    <div class="col-6 mx-auto text-center">
      <h1 class="text-danger" id='message'><?php echo $vMessage; ?></h1>
    </div>
  </div>
</div>
