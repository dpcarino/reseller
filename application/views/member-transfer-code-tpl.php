<?php include('includes/header.php'); ?>
<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1435px;">
        <!-- BEGIN PAGE HEADER-->
        <h1 class="page-title"> Transfer Code</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('/'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Codes</span>
                    <i class="fa fa-angle-right"></i>
                </li>                
                <li>
                    <span>Transfer</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <?php include('includes/notes.php'); ?>
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Transfer Code 
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <?php if($member_pin_info->security_pin == ''): ?>
                        <div class="note note-danger">
                            <p> Dear member,</p>
                            <br>
                            <p> Please complete the ff in your profile page: </p>
                            <br>
                            <?php if($member_pin_info->security_pin == ''): ?>
                                <p>Security Pin</p>
                            <?php endif; ?>                        
                            <br>                 
                            <p> Thanks,</p>
                            <p> Essensa Administrator</p>
                        </div>  
                        <?php endif; ?>
                        <?php echo form_open_multipart('codes/transfer/', array('class'=>'form-horizontal', 'id'=>'login_form', 'autocomplete' => 'off')); ?>
                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Transfer Code: </label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo $code_info->code; ?> </p>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Member Account: </label>
                                    <div class="col-md-9">
                                        <select name="member_account" class="form-control" id="member_account">
                                            <option value="">Select Member Account</option>
                                            <?php foreach($members as $member): ?>
                                                <option value="<?php echo $member->member_id; ?>"><?php echo $member->username; ?></option>
                                            <?php endforeach; ?>
                                        </select>                                        
                                        <!-- <input type="text" style="width: 50%;" class="form-control" name="member_account" id="member_account" autocomplete="off">  -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Security Pin: </label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" placeholder="Enter Security Pin" onkeypress="return isNumberKey(event);" name="security_pin" maxlength="6"> 
                                    </div>
                                </div>                                
                            </div>                        
                            <div class="form-actions right">
                                <input type="hidden" name="member_id" id="member_id" class="form-control" data-required="1" value="0">
                                <input type="hidden" name="code_id" id="code_id" class="form-control" data-required="1" value="<?php echo $code_info->code_id; ?>">
                                <a href="<?php echo site_url('codes/listing'); ?>" class="btn default"> Cancel </a>
                                <?php if($member_pin_info->security_pin != ''): ?>
                                    <button type="submit" class="btn yellow"><i class="fa fa-check"></i> Transfer</button>
                                <?php else: ?>
                                    <a href="<?php echo site_url('profile'); ?>" class="btn default"> Update Profile </a>
                                <?php endif; ?>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>

<script>
$( function() {
    $('#member_account').select2();
});
/*    
    var base_url = '<?php echo site_url(); ?>';
    
    members = [

        <?php foreach($members as $member): ?>

            {value : '<?php echo $member->username; ?>', data: '<?php echo $member->member_id; ?>'},

        <?php endforeach; ?>

    ];

    $('#member_account').autocomplete({
        lookup: members,
        onSelect: function (suggestion) {
            $('#member_id').val(suggestion.data)
        }
    });

    $("#confirm-yes").on('click', function (){
        var code_id = $('#code_id').val();
        var member_id = $('#member_id').val();
     
        $('#generate-code').text('Transferring Code..');
        $('#transfer-code').attr("disabled", "disabled");
        $('#transfer-cancel').attr("disabled", "disabled");

        $.ajax({
            url: base_url+"member/ajax/transfer-code",
            data:{'code_id' : code_id, 'member_id' : member_id},
            success: function(data) {           
                if(data.status == 'error'){
                    $('#alert-msg').html(data.msg);
                    $('#alert-type').html('error');
                    $('#alert').modal('show');  
                }else{
                    $('#alert-msg').html(data.msg);
                    $('#alert-type').html('Success');
                    $('#alert-close').hide();
                    $('#alert-ok').show();
                    $('#alert').modal('show');
                }                
            },
            type: 'POST',
        });

    });

    $("#transfer-code").on('click', function (){

        var code_id = $('#code_id').val();
        var member_id = $('#member_id').val();

        var error = 0;
        var error_str;
        var alert_type;


        if(member_id == 0){
            error = 1;
            error_str = 'Please specify an account';
            alert_type = 'Error';
            $('#alert-msg').html(error_str);
            $('#alert-type').html(alert_type);
            $('#alert').modal('show');

            return;
        }   

        $('#confirm').modal('show');

    });


    $("#alert-ok").on('click', function (){
        window.location.href = base_url+"member/codes/history";
    });
*/
</script>