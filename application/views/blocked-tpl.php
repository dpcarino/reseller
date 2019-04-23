<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Essensa Gold Elite - Members</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url('assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/global/css/components.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/global/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url('assets/pages/css/login-5.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/pages/css/error.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/pages/css/lock.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="">

        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="page-lock">
            <div class="page-body">
                <div class="lock-head"> Blocked </div>
                <div class="lock-body">
                    <div class="lock-cont">
                        <div class="lock-item">
                            <div class="pull-left lock-avatar-block">
                                <?php if($member_details->authorized_id_img_1 != ''): ?>
                                <img src="<?php echo site_url('uploads') . '/members/image/' . $member_details->authorized_id_img_1; ?>" class="lock-avatar"> 
                                <?php else: ?>
                                <img src="<?php echo base_url('assets/layouts/layout2/img/default-profile.png'); ?>" class="lock-avatar"> 
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="lock-item lock-item-full">
                            <form class="lock-form pull-left">
                                <h4><?php echo $member_details->first_name.' '.$member_details->last_name; ?></h4>
                                <div class="form-actions">
                                    <a href="mailto:customerservice@essensanaturale.org" class="btn red uppercase">Email Essensa Admin</a>
                                </div>
                                <br><br><br><br>
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/scripts.php'); ?>

    </body>
</html>