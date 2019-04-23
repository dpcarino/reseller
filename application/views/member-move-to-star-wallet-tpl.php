<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Move to Star Wallet</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Star Wallet</span>
	            </li>              
	        </ul>         
	    </div>
	    <!-- END PAGE HEADER-->
	    <div class="row">
	        <div class="col-md-12">
                <?php include('includes/notes.php'); ?>
                <div class="portlet box yellow ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i> Move to Star Wallet
                        </div>
                    </div>
                    <div class="portlet-body form">
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
                        <?php echo form_open_multipart('transactions/move_star_wallet/'.$head_id, array('class'=>'form-horizontal', 'id'=>'login_form')); ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Current Head Star: </label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo $memberhead_info->stars; ?> </p>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Stars to Move: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="Enter number of stars" onkeypress="return isNumberKey(event);" name="stars"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Security Pin: </label>
                                    <div class="col-md-9">
                                        <input type="password" style="width: 50%;" class="form-control" placeholder="Enter Security Pin" onkeypress="return isNumberKey(event);" name="security_pin" maxlength="6"> 
                                    </div>
                                </div> 
                            </div>
                            <div class="form-actions right">
                                <input type="hidden" name="head_id" value="<?php echo $head_id; ?>">
                                <button type="button" class="btn default">Cancel</button>
                                <?php if($member_pin_info->security_pin != ''): ?>
                                    <button type="submit" class="btn yellow"><i class="fa fa-check"></i> Transfer</button>
                                <?php else: ?>
                                    <a href="<?php echo site_url('profile'); ?>" class="btn default"> Update Profile </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
	        </div>
	    </div>
	</div>
	<!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>