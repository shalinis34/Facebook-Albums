<?php
require_once 'config.php';
require_once 'function.php';
session_start();
session_destroy();
$files = glob(ABSOLUTE_PATH . '/assets/images/archive/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
header('Location:'.BASE_URL);