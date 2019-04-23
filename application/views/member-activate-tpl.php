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
                        <h1>Complete Membership Activation</h1>
                        <?php echo form_open_multipart('member/activate/'.$activation_code, array('class'=>'login-form', 'id'=>'login_form')); ?>
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter any username and password. </span>
                            </div>                         

                            <div class="row">
                                <div class="col-md-12">
                                    <?php include('includes/notes.php'); ?>
                                </div>

                                <div class="col-xs-4">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Temporary Password" name="temp_password" value="<?php echo ($temp_password_url != false ? $temp_password_url : ''); ?>"> </div>
                                <div class="col-xs-4">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="New Password" name="new_password"/> </div>
                                <div class="col-xs-4">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Confirm New Password" name="confirm_password"/> </div>                                    
                            </div> 
                            <div class="row">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-8 text-right">
                                    <input type="hidden" name="activation_code" value="<?php echo $activation_code; ?>">
                                    <button class="btn green" type="submit">Activate Account</button>
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
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='confirm-type'>Terms &amp; Conditions</h3>
      </div>
      <div class="modal-body">
        <p class="text-left" id="confirm-msg">
            <ol>
                <li>Dealers / Members are allowed a maximum of 3 accounts.</li>
                <li>Service Centers are allowed a maximum of 7 accounts.</li>
                <li>Business Centers are allowed a maximum of 15 accounts.</li>
                <li>Any member who exceeds the above allowable accounts, excess accounts shall be blocked without any need of further notice and as such shall be blocked forever.</li>
                <li>Considering that the maximum accounts is 15, only 4 levels of the same names shall be allowed. Any excess in 4 levels with the same name shall be considered as void, thus shall be blocked
                without need of further notice.</li>
                <li>Hierarchy of the existing organization shall be observed, therefore, no cross-lining shall be allowed.</li>
                <li>Any member found re-heading to another upline, such account shall be automatically blocked
                without need of further notice.</li>
                <li>Separated members (Resigned / Terminated) are not entitled to join.</li>
                <li>The existing Membership Terms and Condition of Essensa Naturale Inc, and all the other Policies
                and Rules and Regulation promulgated by the company shall still apply to this new BSD Gold-Elite Membership.</li>
                <li>Any misrepresentation of information on this Application Form, proven after due process, shall be a ground for termination of membership.</li>
            </ol>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">I Agree</button>
      </div>      
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){ 
        $("#confirm").modal({
            overlayClose:false,
            backdrop: 'static', 
            keyboard: false,
        });
        // $('#confirm').modal('show');
    });
</script>