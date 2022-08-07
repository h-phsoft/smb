<?php
$diary = cFundDiary::getInstance($aParams[0]);
?>
<div class = "container">
  <div class="row">
    <div class="col-8 mx-auto text-center">
      <img class="py-3" src = "assets/media/<?php echo $oCopy->URL; ?>/logo/loginlogo.png" width="50%">
    </div>
  </div>
  <?php
  ?>
  <div class="row pt-2">
    <div class="col-6 mx-auto text-center">
      <h1 class="text-danger" id='message'><?php echo $diary->BoxName; ?></h1>
    </div>
  </div>
</div>
