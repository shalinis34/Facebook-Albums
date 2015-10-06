<?php
session_start();
include 'config.php';
include 'function.php';
/* creates a compressed zip file */
if (extension_loaded('zip')) {
    $album_ids = explode(',', $_GET['album_ids']);
    if (!file_exists(ABSOLUTE_PATH . "/assets/images/archive")) {
        mkdir(ABSOLUTE_PATH . "/assets/images/archive");
    }
    $filepath = $album_ids[0] . time();
    $zip = new ZipArchive();
    $zip_name = ABSOLUTE_PATH . '/assets/images/archive/' . $filepath . ".zip";
    if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
        echo '<p class="bg-danger">Error Occur While Zip Creation ,Please Try After Some Time.</p> ';
        exit;
    }
    foreach ($album_ids as $album_id) {
      createArchive($album_id,$zip); // Function to add files to zip and download image from facebook
    }
    $zip->close();
    if (file_exists($zip_name)) {
        echo '<p class="bg-success"><a href="' . BASE_URL . '/assets/images/archive/' . $filepath . '.zip"><strong class="text-uppercase">Download Your Zip File</strong></a></p>';
        exit;
    }
} else {
    echo  '<p class="bg-danger">Sorry ,Zip extension is not loaded.</p>';
}