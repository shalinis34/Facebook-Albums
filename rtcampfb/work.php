<?php
session_start();
require_once 'header.php';
?>

<!-- Page Content -->
<section id="middle">
    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <div class="animatedParent">
                    <div class="section-heading text-center animated bounceInDown">
                        <h2 class="text-uppercase">How it works </h2>
                        <div class="divider-header"></div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="container text-center margin-10">
        <div class="row">
            <div class="row animatedParent">
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="animated rotateInDownLeft go">
                        <div class="service-box">
                            <div class="service-icon">
                                <span class="glyphicon glyphicon-picture"></span>
                            </div>
                            <div class="service-desc">
                                <h5>Part-1: View album</h5>
                                <div class="divider-header"></div>
                                <p>
                                <ol>
                                    <li> User must be first login via their facebook account.</li>
                                    <li>Once authenticated,albums will be listed in Albums section.</li>
                                    <li> User can preview their album when they will click on an album name/thumbnail.</li>
                                </ol>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="animated rotateInDownLeft slow go">
                        <div class="service-box">
                            <div class="service-icon">
                                <span class="glyphicon glyphicon-download-alt"></span>
                            </div>
                            <div class="service-desc">
                                <h5> Part-2:Download Album </h5>
                                <div class="divider-header"></div>
                                <p>
                                <ol>
                                    <li> User can download single album by clicking download option below respective album.</li>
                                    <li> Once you click download button progress bar will show progress,as zip is created ,link will be shown to download zip file .</li>
                                    <li> User can select multiple album to download all album in zip format .</li>
                                    <li> User can also download all album in zip format .</li>
                                </ol>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="animated rotateInDownLeft slower go">
                        <div class="service-box">
                            <div class="service-icon">
                                <span class="glyphicon glyphicon-move"></span>
                            </div>
                            <div class="service-desc">
                                <h5>Part-3: Move to Picasa/Google+</h5>
                                <div class="divider-header"></div>
                                <p>
                                <ol>
                                    <li> User must be first login to google account in order to move albums to their Picasa/Google+ account.</li>
                                    <li> User can move photos to Picasa/Google+ account by clicking move option below respective album.</li>
                                    <li> User can select multiple album to move all album to their Picasa/Google+ account.</li>
                                    <li> User can also move all album to their Picasa/Google+ account.</li>
                                </ol>


                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>
<?php include'footer.php'; ?>