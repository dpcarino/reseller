<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Trimatrix Lab">
    <meta name="description" content="">
    <meta name="keywords" content="">


    <title>Essensa Elite Membership Information</title>
    <link rel="icon" href="images/fav-icon.png">

    <!--APPLE TOUCH ICON-->
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/vcard/images/apple-touch-icon.png'); ?>">


    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>


    <!-- MATERIAL ICON FONT -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/font-awesome.min.css'); ?>" rel="stylesheet">


    <!-- ANIMATION -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/animate.min.css'); ?>" rel="stylesheet">


    <!-- MATERIALIZE -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/materialize.css'); ?>" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/bootstrap.min.css'); ?>" rel="stylesheet">


    <!-- CUSTOM STYLE -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/style.css'); ?>" id="switch_style" rel="stylesheet">

</head>
<body>


<!--==========================================
                  PRE-LOADER
===========================================-->
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="box-holder animated bounceInDown">
                <span class="load-box"><span class="box-inner"></span></span>
            </div>
            <!-- NAME & STATUS -->
            <div class="text-holder text-center">
                <h2><?php echo $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name; ?></h2>
                <!-- <h6>Software Engineer & UI/UX Expert</h6> -->
            </div>
        </div>
    </div>
</div>

<!--==========================================
                    HEADER
===========================================-->
<header id="home">
    <div class="header-background section">
        <div id="v-card-holder">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <!-- V-CARD -->
                        <div id="v-card" class="card">

                            <!-- PROFILE PICTURE -->
                            <div id="profile" class="right">
                                <?php if($member_details_info->authorized_id_img_1 != ''): ?>
                                <img alt="profile-image" class="img-responsive" src="<?php echo site_url('uploads') . '/members/image/' . $member_details_info->authorized_id_img_1; ?>">
                                <?php else: ?>
                                <img alt="profile-image" class="img-responsive" src="<?php echo base_url('assets/layouts/layout2/img/default-profile.png'); ?>">
                                <?php endif; ?>
                                <div class="slant"></div>
                            </div>

                            <div class="card-content">

                                <!-- NAME & STATUS -->
                                <div class="info-headings">
                                    <h4 class="text-uppercase left"><?php echo $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name; ?></h4>
                                    <?php if($member_details_info->member_status == 0): ?>
                                    <h6 class="text-capitalize left">Authorized Dealer</h6>
                                    <?php elseif($member_details_info->member_status == 1): ?>
                                    <h6 class="text-capitalize left">Authorized Leader</h6>
                                    <?php elseif($member_details_info->member_status == 2): ?>
                                    <h6 class="text-capitalize left">Authorized Service Center</h6>
                                    <?php elseif($member_details_info->member_status == 3): ?>
                                    <h6 class="text-capitalize left">Authorized Business Center</h6>
                                    <?php endif; ?>
                                </div>

                                <!-- CONTACT INFO -->
                                <!--div class="infos">
                                    <ul class="profile-list">
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">email</i></span>
                                            <span class="content"><?php echo $member_info->email; ?></span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">language</i></span>
                                            <span class="content">yourpersonalwebsite.com</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="fa fa-skype" aria-hidden="true"></i></span>
                                            <span class="content">yourusername@skype.com</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">phone</i></span>
                                            <span class="content">+152 25634 254 846</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">place</i></span>
                                            <span class="content">LampStreet 34/3, London, UK</span>
                                        </li>

                                    </ul>
                                </div-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================== SCRIPTS ================== -->
<script src="<?php echo base_url('assets/vcard/javascript/jquery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/materialize.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY"></script>
<script src="<?php echo base_url('assets/vcard/javascript/markerwithlabel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/retina.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/scrollreveal.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/jquery.touchSwipe.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/custom.js'); ?>"></script>


</body>
</html>