<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Demos
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

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
function addPhoto($client, $user, $albumId, $photo_name,$photo_path)
{
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
       // print_r($result);
    } else {
        echo "There was an issue with the file upload.";
    }
}


/**
 * Adds a new album to the specified user's album
 *
 * @param  Zend_Http_Client $client The authenticated client
 * @param  string           $user   The user's account name
 * @param  string           $name   The name of the new album
 * @return void
 */
function addAlbum($client, $user, $name)
{
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

