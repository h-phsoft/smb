<?php
$vMessage = 'Done';
if (is_array($aParams)) {
  $vIdType = 'tinyint(4)';
  $vAutoIncrement = '';
  if (isset($aParams[1]) && $aParams[1] == 1) {
    $vAutoIncrement = 'AUTO_INCREMENT';
  }
  if (isset($aParams[2])) {
    if (strtolower($aParams[2]) == 's') {
      $vIdType = 'smallint(6)';
    } else if (strtolower($aParams[2]) == 'i') {
      $vIdType = 'int(11)';
    }
  }
  $vSQL = "CREATE TABLE IF NOT EXISTS `" . $aParams[0] . "` ("
          . "  `id` " . $vIdType . " NOT NULL " . $vAutoIncrement . " COMMENT 'PK',"
          . "  `name` varchar(100) NOT NULL COMMENT 'Name',"
          . "  `rem` varchar(100) DEFAULT NULL COMMENT 'Remarks',"
          . "  `ins_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'User Inserted Record',"
          . "  `ins_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inserted at',"
          . "  `upd_user` int(11) NOT NULL DEFAULT '-9' COMMENT 'Laste User Updated Record',"
          . "  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Laste Update at',"
          . "  PRIMARY KEY (`id`),"
          . "  UNIQUE KEY `name` (`name`)"
          . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  try {
    ph_Execute($vSQL);
    $vSQL = "ALTER TABLE `" . $aParams[0] . "`"
            . " ADD FOREIGN KEY (`ins_user`) REFERENCES `cpy_user` (`id`),"
            . " ADD FOREIGN KEY (`upd_user`) REFERENCES `cpy_user` (`id`);";
    ph_Execute($vSQL);
  } catch (Exception $exc) {
    $vMessage = $exc->getTraceAsString();
  }
}
?>
<div class = "container">
  <div class="row pt-2">
    <div class="col-6 mx-auto text-center">
      <h1 class="text-danger" id='message'><?php echo $vMessage; ?></h1>
    </div>
  </div>
</div>
