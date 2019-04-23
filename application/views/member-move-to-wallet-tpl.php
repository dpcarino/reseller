<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Move to Wallet</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Wallet</span>
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
                            <i class="fa fa-money"></i> Move to Wallet
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
                        <?php echo form_open_multipart('transactions/move_wallet/'.$head_id, array('class'=>'form-horizontal', 'id'=>'login_form')); ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Current Head Income: </label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo number_format($head_info->total_income); ?> </p>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Amount to Move: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="Amount Here (No Commas)" onkeypress="return validateFloatKeyPress(this,event);" name="amount"> 
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
 function validateFloatKeyPress(el, evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46){
         return false;
    }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
        return false;
    }
    return true;
}

//thanks: http://javascript.nwbox.com/cursor_position/
function getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
        return o.value.lastIndexOf(r.text)
    } else return o.selectionStart
}
</script>