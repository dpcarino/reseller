<?php include('includes/header-login.php'); ?>
    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="<?php echo base_url('assets/admin/pages/img/logo-big.png'); ?>" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <?php echo form_open_multipart('admin/login', array('class'=>'login-form', 'id'=>'login_form')); ?>
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="email"/>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn green uppercase pull-right">Login</button>
                </div>
            </form>
        </div>
        <div class="copyright"> <?php echo date('Y'); ?> © Essensa Elite. Admin Dashboard Template. </div>
        <!-- END LOGIN -->
        <?php include('includes/scripts-login.php'); ?>
    </body>
</html>