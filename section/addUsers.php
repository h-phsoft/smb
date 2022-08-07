<?php include_once "Module/PhCFG.php" ?>
<?php include_once "Module/MySQL.php" ?>
<?php include_once "Module/PhFunctions.php" ?>
<?php

ph_Connect('phs_smb_icloud');
$res = ph_execute("SELECT table_name FROM information_schema.tables WHERE table_schema='phs_smb_demo' AND table_name NOT LIKE 'phs_%'");
while (!$res->EOF) {
  echo '<br>';
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD `ins_user` INT NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record';";
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD `ins_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at' AFTER `ins_user`;";
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD `upd_user` INT NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record' AFTER `ins_date`;";
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD `upd_date` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Laste Update at' AFTER `upd_user`;";
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD FOREIGN KEY (`ins_user`) REFERENCES `cpy_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";
  echo '<br>' . "ALTER TABLE `" . $res->fields('table_name') . "` ADD FOREIGN KEY (`upd_user`) REFERENCES `cpy_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";
  $res->MoveNext();
}
$res->Close();
