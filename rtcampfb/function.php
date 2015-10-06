<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 function curlinfo($url)
  {     error_reporting('E_ALL');
  	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output=curl_exec($ch);
        $output=(json_decode($output));
        if(curl_errno($ch)){
          echo '<p class="bg-danger">Curl error: ' . curl_error($ch).'</p>'; exit();
        }
        curl_close($ch);
        return $output;
        
  }

  function getUserInfo()
  {
        $userInfoUrl="https://graph.facebook.com/me?access_token=".$_SESSION['fb_access_token'];
        return curlinfo($userInfoUrl);
  }

  function fetchAllAlbums()
  {
    $url="https://graph.facebook.com/me/albums?access_token=".$_SESSION['fb_access_token'];
    return curlinfo($url);
  }

    function fetchSingleAlbums($album_id)
  {
     $url="https://graph.facebook.com/$album_id/photos?fields=name,source,id&access_token=".$_SESSION['fb_access_token'];
     $singleAlbumDetail=curlinfo($url);
     return $singleAlbumDetail->data;
  }
  function downloadImage($sourceurl,$destination_path)
  {
     $fp = fopen($destination_path,"wb");
     fwrite($fp,file_get_contents($sourceurl));
     fclose($fp);
  }

   function createArchive($album_id,$zip) {
      if (!file_exists(ABSOLUTE_PATH . "/assets/images/albums/$album_id")) {
            mkdir(ABSOLUTE_PATH . "/assets/images/albums/$album_id");
        }
        $singleAlbum = fetchSingleAlbums($album_id);
        foreach ($singleAlbum as $photo) {
            $url = $photo->source;
            $destination_path = ABSOLUTE_PATH . '/assets/images/albums/' . $album_id . '/' . $photo->id . '.jpg';
            downloadImage($url, $destination_path);
            $zip->addFile($destination_path, $album_id . '/' . $photo->id . '.jpg');
        }
       
}
        function googleConnect()
        {
            require_once ('lib/Google/autoload.php');

        /* * *********************Google login************************ */
        $client = new Google_Client();
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->addScope("openid email");
        $client->addScope("https://picasaweb.google.com/data/");
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        return $client;
        }