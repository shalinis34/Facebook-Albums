<?php
session_start();
require_once '../config.php';
require_once '../function.php';
/**
 * Utilizes the Zend Framework Gdata components to communicate with the Google API.
 * Requires the Zend Framework Gdata components and PHP >= 5.2.11
 */
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');
Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');
Zend_Loader::loadClass('Zend_Gdata_Photos_PhotoQuery');
Zend_Loader::loadClass('Zend_Gdata_App_Extension_Category');

/**
 * Adds a new photo to the specified album
 *
 * @param  Zend_Http_Client $client  The authenticated client
 * @param  string           $user    The user's account name
 * @param  integer          $albumId The album's id
 * @param  array            $photo   The uploaded photo
 * @return void
 */
function addPhoto($client, $user, $albumId, $photo_name, $photo_path) {
    $photos = new Zend_Gdata_Photos($client);
    $fd = $photos->newMediaFileSource($photo_path);
    $fd->setContentType('image/jpeg');
    $entry = new Zend_Gdata_Photos_PhotoEntry();
    $entry->setMediaSource($fd);
    $entry->setTitle($photos->newTitle($photo_name));
    $albumQuery = new Zend_Gdata_Photos_AlbumQuery;
    $albumQuery->setUser($user);
    $albumQuery->setAlbumId($albumId);
    $albumEntry = $photos->getAlbumEntry($albumQuery);
    $result = $photos->insertPhotoEntry($entry, $albumEntry);
    if ($result) {
        return $result;
    } else {
        echo "There was an issue with the file upload.";
    }
}

/**
 * Adds a new album to the specified user's album
 *
 * @param  Zend_Http_Client $client The authenticated client
 * @param  string           $name   The name of the new album
 * @return void
 */
function addAlbum($client,$name) {
    $photos = new Zend_Gdata_Photos($client);

    $entry = new Zend_Gdata_Photos_AlbumEntry();
    $entry->setTitle($photos->newTitle($name));
    $result = $photos->insertAlbumEntry($entry);
    if ($result) {
        return $result;
    } else {
        echo "There was an issue with the album creation.";
    }
}

/* * **********************************************
  If we're signed in we can go ahead and retrieve
  data
 * ********************************************** */
set_time_limit('10000');
if (isset($_SESSION['google_token'])) {
    $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['google_token']);
    $userInfo = $_SESSION['google_userInfo'];
    $album_ids = explode(',', $_GET['album_ids']);
    foreach ($album_ids as $album_id) {
        $singleAlbum = fetchSingleAlbums($album_id);
        if (!file_exists(ABSOLUTE_PATH . "/assets/images/archive")) {
            mkdir(ABSOLUTE_PATH . "/assets/images/archive");
        }
        $filepath = $album_id;
        if (!file_exists(ABSOLUTE_PATH . "/assets/images/albums/$filepath")) {
            mkdir(ABSOLUTE_PATH . "/assets/images/albums/$filepath");
        }
        $result = addAlbum($client,'Test Album');
        $albumId = $result->getGphotoId()->getText();
        foreach ($singleAlbum as $photo) {
            $url = $photo->source;
            $destination_path = ABSOLUTE_PATH . '/assets/images/albums/' . $filepath . '/' . $photo->id . '.jpg';
            downloadImage($url, $destination_path);
            addPhoto($client, $userInfo->user_id, $albumId, $photo->id, $destination_path);
        }
    }
      echo '<p class="bg-success"> Your album has been move to your picasa account successfully.</p>';
} else {
    echo 'first login via google inorder to move your album to picasa account';
}