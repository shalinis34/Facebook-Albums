<?php
session_start();
require_once 'config.php';
require_once 'function.php';
/* * **********************************************
  If we're signed in we can go ahead and retrieve
  data
 * ********************************************** */
set_time_limit('10000');
if (isset($_SESSION['google_token']))
{
    require_once 'move_lib.php';
    $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['google_token']);
    //    addAlbum($client, $userInfo->user_id,'Shalini Album');
    $userInfo=$_SESSION['google_userInfo'];
    $album_ids = explode(',', $_GET['album_ids']);
     foreach ($album_ids as $album_id) { 
       
      $singleAlbum=fetchSingleAlbums($album_id);
     // print_r($singleAlbum);
     if(!file_exists(ABSOLUTE_PATH."/assets/images/archive"))
      {
              mkdir(ABSOLUTE_PATH."/assets/images/archive");
      }
      $filepath=$album_id;
       if(!file_exists(ABSOLUTE_PATH."/assets/images/albums/$filepath"))
      {
              mkdir(ABSOLUTE_PATH."/assets/images/albums/$filepath");
      }
       $result=addAlbum($client, $userInfo->user_id,'Shalu');
       $albumId = $result->getGphotoId()->getText();
	foreach($singleAlbum as $photo)
	{
	  $url=$photo->source;
          $destination_path=ABSOLUTE_PATH.'/assets/images/albums/'.$filepath.'/'.$photo->id.'.jpg';
          downloadImage($url,$destination_path);
            /////Add album////////////
           addPhoto($client,$userInfo->user_id, $albumId,$photo->id,$destination_path);
	}


      
    }
}
else
{
    echo 'first login via google inorder to move your album to picasa account';
}
?>

