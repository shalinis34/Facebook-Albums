<?php
session_start();
require_once 'config.php';
require_once 'lib/Facebook/autoload.php';
require_once 'header.php';
$fb = new Facebook\Facebook([
'app_id' => FB_APP_ID,
 'app_secret' => FB_SECRET_KEY,
 'default_graph_version' => 'v2.2',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_photos']; // optional
$loginUrl = $helper->getLoginUrl(BASE_URL . '/fb-callback.php', $permissions);
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['access_token']);
}
?>
<section class="hero" id="intro">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center inner">
                <div class="">
                    <h1 class="animated slideInDown">  Facebook Albums</h1>
                    <p class="animated slideInUp">Download and view your  facebook albums </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center inner">
                <div class="animatedParent">

                    <p class="animated fadeInUp">
                        <?php
                        if (!isset($_SESSION['fb_access_token'])) {
                        ?>
                            <a class="btn btn-info btn-special" href="<?php echo htmlspecialchars($loginUrl); ?>">Log in with Facebook!</a>
                        <?php } else {
                        ?>
                            <a   class="btn btn-info " href="logout.php">Logout Facebook!</a>

                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include'footer.php'; ?>