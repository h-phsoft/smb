<?php include_once "Module/MySQL.php" ?>
<?php include_once "Module/PhFunctions.php" ?>
<?php include_once "Module/CpyFunctions.php" ?>
<?php

ph_Connect('phs_smb_unv');
$vSQL = 'SELECT `plan_id`, `item_id`, `term_id`, `year_id` FROM `a0000` ORDER BY `plan_id`, `item_id`';
$res = ph_Execute($vSQL);
if ($res != '') {
  echo $vSQL . '<br>';
  $nPPlanId = 0;
  $nPItemId = 0;
  while (!$res->EOF) {
    $nPlanId = intval($res->fields("plan_id"));
    $nItemId = intval($res->fields("item_id"));
    $nYearId = intval($res->fields("year_id"));
    $nTermId = intval($res->fields("term_id"));
    if ($nPPlanId != $nPlanId || $nPItemId != $nItemId) {
      $vSQL = 'INSERT INTO unv_plan_item (plan_id, year_id, term_id, item_id, type_id)'
        . ' VALUES("' . $nPlanId . '", "' . $nYearId . '", "' . $nTermId . '", "' . $nItemId . '", 1)';
      echo $vSQL . '<br>';
      $ires = ph_ExecuteInsert($vSQL);
    }
    $nPPlanId = $nPlanId;
    $nPItemId = $nItemId;
    $res->MoveNext();
  }
  $res->Close();
}
