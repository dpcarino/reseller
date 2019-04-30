<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Add New Member</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Add Member</span>
                    <i class="fa fa-angle-right"></i>
	            </li>
                <li>
                    <span><?php echo $current_head; ?></span>
                </li>                 
	        </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Change Head
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php foreach($heads as $head): ?>
                        <li <?php echo ($current_head == $head->headname ? 'style="background-color: #4BA547; height: 30px;
                            padding-left: 15px;
                            padding-top: 5px;' : ''); ?>>
                            <a href="javascript:;" 
                                <?php if($current_head != $head->headname): ?>
                                    onclick="changeMemberHead('<?php echo $head->headname; ?>');"
                                <?php endif; ?> 
                            ><i class="icon-user"></i> <?php echo $head->headname; ?></a>
                        </li>                        
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div>            
	    </div>
	    <!-- END PAGE HEADER-->
	    <div class="row">
	        <div class="col-md-12">
                <?php include('includes/notes.php'); ?>
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Membership Form 
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <?php echo form_open_multipart('member/add/', array('id'=>'member_form')); ?>
                            <div class="form-body">
                                <h3 class="form-section">MEMBER INFORMATION</h3>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">First Name <span class="required"> * </span></label>                                            
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name; ?>" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Middle Name</label>
                                            <input type="text" name="middle_name" id="middle_name" class="form-control" value="<?php echo $middle_name; ?>" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Last Name<span class="required"> * </span></label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name; ?>" placeholder="">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Citizenship<span class="required"> * </span></label>
                                            <select class="form-control" name="citizenship" id="citizenship">
                                            <option value="">Select Citizenship</option>
                                            <?php foreach($citizenships as $citizenship): ?>
                                                <option value="<?php echo $citizenship->nationality; ?>" <?php echo ($city == $citizenship->nationality ? 'selected': ''); ?>><?php echo $citizenship->nationality; ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->                                     
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Date of Birth<span class="required"> * </span></label>
                                            <input type="text" class="form-control" value="<?php echo $dob; ?>" placeholder="yyyy-mm-dd" name="dob" id="dob" readonly> 
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Place of Birth<span class="required"> * </span></label>
                                            <select class="form-control" name="pob" id="pob">
                                                <option value="">Select City</option>
                                                <?php foreach($cities as $city): ?>
                                                    <option value="<?php echo $city->name; ?>" <?php echo ($pob == $city->name ? 'selected': ''); ?>><?php echo $city->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Civil Status</label>
                                            <select class="form-control" name="civil_status" id="civil_status">
                                                <option value="single" <?php echo ($civil_status == 'single' ? 'selected': ''); ?>>Single</option>
                                                <option value="married" <?php echo ($civil_status == 'married' ? 'selected': ''); ?>>Married</option>
                                                <option value="divorced" <?php echo ($civil_status == 'divorced' ? 'selected': ''); ?>>Divorced</option>
                                                <option value="widow" <?php echo ($civil_status == 'widow' ? 'selected': ''); ?>>Widow</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tin Number</label>
                                            <input type="text" name="tin_number" id="tin_number" value="<?php echo $tin_number; ?>" class="form-control">
                                        </div>
                                    </div>                                   
                                </div>
                                <h3 class="form-section">CONTACT DETAILS</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Telephone No.</label>
                                            <input type="text" value="<?php echo $telephone; ?>" name="telephone" id="telephone" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Mobile No.<span class="required"> * </span></label>
                                            <input type="text" value="<?php echo $mobile; ?>" name="mobile" id="mobile" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Email Address<span class="required"> * </span></label>
                                            <input type="text" value="<?php echo $email; ?>" name="email" id="email" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>                                
                                <!--/row-->
                                <h3 class="form-section">ADDRESS</h3>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Full Address<span class="required"> * </span></label>
                                            <textarea class="form-control" rows="3" name="address" id="address"><?php echo $address; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province<span class="required"> * </span></label>
                                            <select class="form-control" name="province" id="province">
                                                <option value="">Select Provinces</option>
                                                <?php foreach($provinces as $province): ?>
                                                    <option value="<?php echo $province->name; ?>"  <?php echo ($province == $province->name ? 'selected': ''); ?>><?php echo $province->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Town / City</label>
                                            <input type="text" name="city" id="city" value="" class="form-control">
                                        </div>
                                    </div>                                    
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <h3 class="form-section">PLACEMENT DETAILS</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upline Placement Position<span class="required"> * </span></label>
                                            <select name="upline_placement_position" class="form-control" id="upline_placement_position">
                                                <option value="">Select Upline</option>
                                                <?php foreach($available_uplines as $available_upline): ?>
                                                <option value="<?php echo $available_upline->head_id; ?>"><?php echo $available_upline->headname; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Placement Position<span class="required"> * </span></label>
                                            <select id="upline_pos" name="upline_pos" class="form-control">
                                                <option value="">Select Position</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Entry Code Package Type<span class="required"> * </span></label>
                                            <select id="package_id" name="package_id" class="form-control">
                                                <option value="">Choose Package</option>
                                                <?php foreach($packages as $package): ?>
                                                    <option value="<?php echo $package->package_id; ?>"><?php echo $package->package_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
											<br>
											<a href="javascript:;" class="btn btn-sm yellow" id="entry-summary">
												<i class="fa fa-search"></i>
												View Entry Codes Summary
											</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code<span class="required"> * </span></label>
                                            <br>
                                            <span id="available-code"></span>
                                            <input type="hidden" name="code_available" id="code_available" class="form-control" value="">
                                        </div>
                                    </div>                                    
                                </div>
                                <!--/row-->
                                <h3 class="form-section">ACCOUNT INFORMATION</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Desired Username<span class="required"> * </span></label>
                                            <input type="text" value="<?php echo $desired_username; ?>" name="desired_username" id="desired_username" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>                                
                                <!--/row-->
                                <h3 class="form-section">PHOTOS</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Member Photo</label>
                                            <input type="file" id="authorized_id_img_1" name="authorized_id_img_1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Valid ID</label>
                                            <input type="file" id="authorized_id_img_2" name="authorized_id_img_2"/>
                                        </div>
                                    </div>
                                </div>                                
                                <h3 class="form-section">GOLD - ELITE PROGRAM TERMS AND CONDITION</h3>
                                <div class="row">
                                	<div style="width: 100%; padding-left: 50px;">
	                                	<p class="form-control-static">
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
                                </div>                                
                            </div>
                            <div class="form-actions right">
                                <a href="<?php echo site_url('/'); ?>" class="btn default"> Cancel </a>
                                <button type="submit" class="btn yellow" id="btn-save-member">
                                    <i class="fa fa-check"></i> Agree & Save</button>
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

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='confirm-type'>Confirm Details</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left">Upline Name: <span id="sponsor-name"></span></p>
        <p class="text-left">Placement Name: <span id="placement-name"></span></p>
        <p class="text-left">Member Username: <span id="user-name"></span></p>
        <br>
        <p class="text-left" id="confirm-msg">Do you agree that all data that you have entered is correct? Click YES to continue</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="paylite" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='paylite-type'>GOLD ELITE PAYLITE Reminder</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="paylite-msg">You are about to create a Gold Elite Pay Lite Account. 
            <br><br>
            Please be reminded that this type of account is an installment account and must not be used to create a fully paid account.  
            <br><br>
            Using this type of account for a fully paid account is tantamount to invalid sponsorship and may be subject to disciplinary action if found true.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="paylite-yes">Continue</button>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="available-codes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='paylite-type'>Available Entry Codes</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="70%">
                                <i class="fa fa-briefcase"></i> Package
                            </th width="30%">
                            <th>
                                <i class="fa fa-money"></i> Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($available_codes as $available_code): ?>
                        <tr>
                            <td>
                                <?php echo $available_code->package_name; ?>
                            </td>
                            <td> 
                                <?php echo $available_code->quantity; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>                             
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="available-codes-close">Close</button>
      </div>      
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$( function() {
    $('#dob').datepicker({
        changeMonth: true, 
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: "-100:+0",
    });

    $('#upline_placement_position').select2();
});

$("#package_id").change(function() {
    var package_id = $('#package_id').val();
    if(package_id == ''){
        $('#available-code').html('');
        $('#code_available').val('');
    }else{
        
        if(package_id == 5){
            $('#paylite').modal('show');
        }

        $.ajax({
            url: base_url+"member/ajax/get-available-code",
            data:{'package_id' : package_id},
            success: function(data) {           
                if(data.status == 'error'){
                    $('#available-code').html('No Codes Available');
                }else{
                    $('#available-code').html(data.code_available);
                    $('#code_available').val(data.code_available);
                }                
            },
            type: 'POST',
        });        
    }
});

$("#entry-summary").click(function() {
    $('#available-codes-modal').modal('show');
});

$("#upline_placement_position").change(function() {
    var upline_id = $('#upline_placement_position').val();

    $('#upline_pos').prop( "disabled", true );

    $.ajax({
        url: base_url+"member/ajax/check-upline-position-available",
        data:{'upline_id' : upline_id},
        success: function(data) {           
            if(data.status == 'error'){
                alert(data.msg);
                location.reload();
            }else{
                $('#upline_pos').html('');
                $('#upline_pos').append('<option value="">Select Position</option>');
                if(data.upline_pos == 'R'){
                    $('#upline_pos').append('<option value="R">Right</option>');
                }else if(data.upline_pos == 'L'){
                    $('#upline_pos').append('<option value="L">Left</option>');
                }else if(data.upline_pos == 'B'){
                    $('#upline_pos').append('<option value="L">Left</option>');
                    $('#upline_pos').append('<option value="R">Right</option>');
                }

                $('#upline_pos').prop( "disabled", false );
            }                
        },
        type: 'POST',
    });

});

$('#member_form').submit(function(e) {
    e.preventDefault();
    var sponsor_name = $("#upline_placement_position option:selected").text();

    var first_name = $('#first_name').val();
    var middle_name = $('#middle_name').val();
    var last_name = $('#last_name').val();
    var desired_username = $('#desired_username').val();

    var fullname = first_name +' '+middle_name+' '+last_name;

    $('#sponsor-name').text(sponsor_name);
    $('#placement-name').text(fullname);
    $('#user-name').text(desired_username);

    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#member_form').unbind('submit').submit();
});
</script>