<?php
session_start();
require_once 'function.php';

/* * *********************************************
 * Function for connecting to google
 * ******************************************** */
$client = googleConnect();

/* * **********************************************
  If we're logging out we just need to clear our
  local access token in this case
 * ********************************************** */
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['google_token']);
    unset($_SESSION['access_token']);
}
/* * **********************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
 * ********************************************** */
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/* * **********************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 * ********************************************** */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
    $token = $client->getAccessToken();
    $token = json_decode($token);
    $token = $token->access_token;
    $_SESSION['google_token'] = $token;
    $url = "https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=" . $token;
    $userInfo = curlinfo($url);
    $_SESSION['google_userInfo'] = $userInfo;
}
require_once 'header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<section id="middle">
    <div class="container">
        <?php
        if (isset($_SESSION['fb_access_token']) && ($_SESSION['fb_access_token'] != '')) {
           
            $userResponse = getUserInfo();
            $fetchAllAlbums = fetchAllAlbums();
            $fetchAllAlbums = $fetchAllAlbums->data;
            if (count($fetchAllAlbums)) {
        ?>
                <div class="container">
            <?php
                if (isset($authUrl)) {
                    echo "<a class='btn btn-success login' href='" . $authUrl . "'>  Google Login</a>";
                } else {
                    echo "<a class='btn btn-success logout' href='?logout'>Google Logout</a>";
                }
            ?>

                <div class="page-header">
                    <h1 class="text-center">Welcome <?php echo $userResponse->name; ?></h1>
                </div>
                <p class="lead text-center"> View your facebook Albums . You can download or move your facebook albums to picasa/google+ account. </p>
                <div class="container">
                    <div class="row text-center">
                        <button class="btn btn-danger" title="Download Selected Album" onclick="downloadSelectedAlbum();"><span aria-hidden="true" class="glyphicon glyphicon-download-alt"></span> Download Selected</button>
                        <button class="btn btn-danger"  title="Download All Album" onclick="downloadAllAlbum();"><span aria-hidden="true" class="glyphicon glyphicon-download-alt"></span> Download All</button>
                        <button class="btn btn-warning"  title="Move Selected Album" onclick="moveSelectedAlbum();"><span aria-hidden="true" class="glyphicon glyphicon-move"></span> Move Selected</button>
                        <button class="btn btn-warning"  title="Move All Album" onclick="moveAllAlbum();"><span aria-hidden="true" class="glyphicon glyphicon-move"></span> Move All</button>
                        <div id="ajaxphp-results"></div>
                    </div>
                    <div class="row stylish-panel">

                    <?php
                    /*                     * **********************************************
                      Listing albums section start here W
                     * ********************************************** */
                    foreach ($fetchAllAlbums as $key => $value) {
                        $url = "https://graph.facebook.com/$value->id/photos?fields=name,source,id&access_token=" . $_SESSION['fb_access_token'];
                        $singleAlbumDetail = curlinfo($url);
                        $singleAlbumDetail = $singleAlbumDetail->data;
                    ?>
                        <div class="col-md-4 margin-10">
                            <div>
                                <img  alt="image" class="img-circle img-thumbnail open-<?php echo $value->id; ?>" src="https://graph.facebook.com/<?php echo $value->id; ?>/picture?type=album&access_token=<?php echo $_SESSION['fb_access_token']; ?>"/>
                                <h2> <a href="javascript:void(0);" class="btn btn-info open-popup open-<?php echo $value->id; ?>"><?php echo $value->name; ?></a></h2>
                                <p>
                                </p>
                                <button title="Download" onclick="downloadSingleAlbum(<?php echo $value->id; ?>);" class="btn btn-primary" ><span aria-hidden="true" class="glyphicon glyphicon-download-alt"></span> Download</button>
                                <input type="checkbox" class="download" id="download" name="download" value="<?php echo $value->id; ?>" /><span aria-hidden="true" class="glyphicon"></span> Select
                                <button title="Move" onclick="moveSingleAlbum(<?php echo $value->id; ?>);" class="btn btn-warning" ><span aria-hidden="true" class="glyphicon glyphicon-move"></span> Move</button>
                                <div id="my-<?php echo $value->id; ?>" class="mfp-hide white-popup">
                                    Inline popup
                                </div>
                                <script>

                                    $('.open-<?php echo $value->id; ?>').magnificPopup({
                                        items: [
<?php
                        foreach ($singleAlbumDetail as $key1 => $value1) {
                            print_r($value1);
                        
?>
                    {
                        src: '<?php echo $value1->source; ?>',
                        title: '<?php echo $value1->name; ?>'
                    },
<?php
                        }
?>
            ],
            gallery: {
                enabled: true
            },
            type: 'image' // this is a default type
        });
                                </script>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <input type="hidden" name="timer" id="timer" value="1">
            </div>
        </div>
        <?php
                } else {
                    echo 'Sorry ,no album available in your facebook account.';
                }
            } else {
        ?>
                <p class="bg-danger">First login via facebook in order to view your album .</p>
        <?php } ?>
        </div>
    </div>
    </section>
    <script>
        var handler;
        function afterSucess(data)
        {
            $('#timer').val('1');
            clearTimeout(handler);
            $('#cover').fadeOut(1000);
            $('.ui-progressbar-value').css('width','100%');
            $('.progress-label').text('Completed !');
            //called when successful
            $('#ajaxphp-results').html(data);
        }
        function progressBar()
        {    $('#cover').fadeIn(1000);
            var progressbar = $( "#progress" ),
            progressLabel = $( ".progress-label" );
            progressbar.progressbar({
                value: false,
                change: function() {
                    progressLabel.text( progressbar.progressbar( "value" ) + "%" );
                },
                complete: function() {
                    progressLabel.text( "Complete!" );
                }
            });
            function progress() {
                var val = progressbar.progressbar( "value" ) || 0;
                progressbar.progressbar( "value", val + 1 );
                timer=$('#timer').val();
                if(timer !=0 && val < 80) {
                    var handler= setTimeout( progress,100);
                }
            }

            setTimeout( progress,200 );//after
        }
        function downloadSingleAlbum(album_id)
        {
            progressBar();
            $.ajax({
                url: 'download.php',
                type: 'GET',
                data: 'type=single&album_ids='+album_id,
                success: function(data) {
                    afterSucess(data);
                }
            });
        }
        function downloadSelectedAlbum()
        {  //By each()
            var count = $("[class='download']:checked").length; // count the checked rows
            if(count == 0)
            {
                alert("Please select atleast one album.");
                return false;
            }
            var c = [];
            $('.download:checked').each(function() {
                c.push($(this).val());
            });


            progressBar();
            $.ajax({
                url: 'download.php',
                type: 'GET',
                data: 'type=selected&album_ids='+c,
                success: function(data) {
                    afterSucess(data);
                }
            });
        }
        function downloadAllAlbum(album_id)
        {  
            var c = [];
            $('.download').each(function() {
                c.push($(this).val());
            });
            console.log(c);
            progressBar();
            $.ajax({
                url: 'download.php',
                type: 'GET',
                data: 'type=all&album_ids='+c,
                success: function(data) {
                    afterSucess(data);
                }
            });
        }
<?php $fbset = isset($_SESSION['google_token']) ? $_SESSION['google_token'] : '0'; ?>
        var googleconnect='<?php echo $fbset; ?>';
        function moveSingleAlbum(album_id)
        {
            if(googleconnect!='0')
            {
                progressBar();
                $.ajax({
                    url: 'lib/move.php',
                    type: 'GET',
                    data: 'type=single&album_ids='+album_id,
                    success: function(data) {
                        afterSucess(data);
                    }
                });
            }
            else { alert('Please connect via google in order to continue to move your albums.');}

        }
        function moveSelectedAlbum(album_id)
        {
            if(googleconnect!='0')
            {
                var count = $("[class='download']:checked").length; // count the checked rows
                if(count == 0)
                {
                    alert("Please select atleast one album.");
                    return false;
                }
                //By each()
                var c = [];
             $('.download:checked').each(function() {
                c.push($(this).val());
            });
                console.log(c);
                progressBar();
                $.ajax({
                    url: 'lib/move.php',
                    type: 'GET',
                    data: 'type=selected&album_ids='+c,
                    success: function(data) {
                        afterSucess(data);
                    }
                });
            }
            else { alert('Please connect via google in order to continue');}
        }
        function moveAllAlbum(album_id)
        {
            if(googleconnect!='0')
            {
               
                //By each()
                var c = [];
                $('.download').each(function() {
                    c.push($(this).val());
                });
                console.log(c);
                progressBar();
                $.ajax({
                    url: 'lib/move.php',
                    type: 'GET',
                    data: 'type=all&album_ids='+c,
                    success: function(data) {
                        afterSucess(data);
                    }
                });
            }
            else { alert('Please connect via google in order to continue');}
        }
    </script>
<?php include 'footer.php'; ?>
