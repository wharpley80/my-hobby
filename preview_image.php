<?php
require_once('inc/config.php');
require_once('inc/database.php');

if (isset($_POST['preview'])) {
  // $preview = $_POST['preview'];
  $preview = addslashes($_POST['preview'] ['tmp_name']);
  //$preview = file_get_contents($preview);
  echo $preview;
}
?>