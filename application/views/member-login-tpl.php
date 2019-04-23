<?php include('includes/header-login.php'); ?>

    <body class=" login">

        <!-- BEGIN : LOGIN PAGE 5-1 -->

        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset">
                    <div class="login-bg" style="background-image:url(<?php echo base_url('assets/pages/img/login/bg1.png'); ?>);">
                        <img class="login-logo" src="<?php echo base_url('assets/pages/img/login/logo.png'); ?>"  /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset">
                    <div class="login-content">
                        <form action="" method="POST" id="admin-login">
                        <h1>Essensa Elite Login</h1>
                        <?php echo form_open_multipart('member/login', array('class'=>'login-form', 'id'=>'login_form')); ?>
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter any username and password. </span>
                            </div>                         

                            <div class="row">
                                <div class="col-md-12">
                                    <?php include('includes/notes.php'); ?>
                                </div>

                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="email"/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password"/> </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="forgot-password">
                                        <a href="<?php echo site_url('forgot-password'); ?>" id="forget-password" class="forget-password">Forgot Password?</a>
                                    </div>                                      
                                </div>
                                <div class="col-sm-8 text-right">                                  
                                    <button class="btn green" type="submit">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php include('includes/footer-login.php'); ?>
                </div>
            </div>
        </div>
        <?php include('includes/scripts.php'); ?>
        <script>
            $(function(){
                $('#admin-login').keydown(function (e) {
                    var key = e.keyCode;
                    if (key == 13) {
                        $('[type="submit"]').trigger('click');
                    }
                });
            });
        </script>
    </body>
</html>