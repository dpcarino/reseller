<?php include('includes/header.php'); ?>

<style>
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
</style>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Add Member</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Members</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Add Member</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <?php include('includes/notes.php'); ?>
                    <div class="portlet light bordered">
                        <div class="portlet-body form" id="country-container">
                            <?php echo form_open_multipart('admin/members/add', array('class'=>'form-horizontal', 'id'=>'member_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> MEMBERS INFORMATION</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">First Name <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="form-control" data-required="1" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Middle Name
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="middle_name" id="middle_name" value="<?php echo $middle_name; ?>" class="form-control" data-required="1" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Last Name <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name; ?>" data-required="1" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Citizenship <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="citizenship" id="citizenship">
                                                    <option value="">Select Citizenship</option>
                                                    <?php foreach($citizenships as $citizenship): ?>
                                                        <option value="<?php echo $citizenship->nationality; ?>" <?php echo ($city == $citizenship->nationality ? 'selected': ''); ?>><?php echo $citizenship->nationality; ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Place of Birth <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="pob" id="pob">
                                                        <option value="">Select City</option>
                                                        <?php foreach($cities as $city): ?>
                                                            <option value="<?php echo $city->name; ?>" <?php echo ($pob == $city->name ? 'selected': ''); ?>><?php echo $city->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Civil Status
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="civil_status" id="civil_status">
                                                        <option value="single" <?php echo ($civil_status == 'single' ? 'selected': ''); ?>>Single</option>
                                                        <option value="married" <?php echo ($civil_status == 'married' ? 'selected': ''); ?>>Married</option>
                                                        <option value="divorced" <?php echo ($civil_status == 'divorced' ? 'selected': ''); ?>>Divorced</option>
                                                        <option value="widow" <?php echo ($civil_status == 'widow' ? 'selected': ''); ?>>Widow</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Tin Number
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="tin_number" id="tin_number" value="<?php echo $tin_number; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> CONTACT DETAILS</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Telephone No.
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" value="<?php echo $telephone; ?>" name="telephone" id="telephone" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Mobile No. <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" value="<?php echo $mobile; ?>" name="mobile" id="mobile" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Email Address <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" value="<?php echo $email; ?>" name="email" id="email" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> ADDRESS</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Full Address<span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" rows="3" name="address" id="address"><?php echo $address; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Province <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="province" id="province">
                                                        <option value="">Select Provinces</option>
                                                        <?php foreach($provinces as $province): ?>
                                                            <option value="<?php echo $province->name; ?>"  <?php echo ($province == $province->name ? 'selected': ''); ?>><?php echo $province->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Town / City 
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="city" id="city" value="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> PLACEMENT DETAILS</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Member Upline Username <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="member_account" id="member_account" class="form-control" data-required="1" value="">
                                                    <input type="hidden" name="member_id" id="member_id" class="form-control" data-required="1" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Sponsor <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="sponsor_head" id="sponsor_head" class="form-control" data-required="1">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Upline Placement Position <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="upline_placement_position" id="upline_placement_position" class="form-control" data-required="1">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Placement Position <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="upline_pos" id="upline_pos" class="form-control" data-required="1">
                                                        <option value="">Select Position</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Account Type <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select id="code_type" name="code_type" class="form-control">
                                                        <option value="">Choose Account Type</option>
                                                        <option value="0">CD</option>
                                                        <option value="1">Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> ACCOUNT INFORMATION</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Desired Username<span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" value="<?php echo $desired_username; ?>" name="desired_username" id="desired_username" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Application Form ID<span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" value="<?php echo $application_form_id; ?>" name="application_form_id" id="application_form_id" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="<?php echo site_url('admin/search');?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>                             
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
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
        <p class="text-left">Sponsor Name: <span id="sponsor-name"></span></p>
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


<?php include('includes/footer.php'); ?>
<script>

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

members = [

    <?php foreach($members as $member): ?>

        {value : '<?php echo $member->username; ?>', data: '<?php echo $member->member_id; ?>'},

    <?php endforeach; ?>

];

$('#member_account').autocomplete({
    lookup: members,
    onSelect: function (suggestion) {
        var member_id = suggestion.data;
        var member_account = $('#member_account').val();
        
        App.blockUI({
            message: 'RETRIEVING MEMBER HEADS OF '+member_account,
        });

        $.ajax({
            url: base_url+"admin/members/ajax/get_heads",
            data:{'member_id' : member_id},
            success: function(data) {           
              
              $('#sponsor_head').html(data.opts_head);

            },
            type: 'POST',
        }); 

        App.blockUI({
            message: 'RETRIEVING AVAILABLE UPLINE HEADS OF '+member_account,
        });

        $.ajax({
            url: base_url+"admin/members/ajax/get_member_heads",
            data:{'member_id' : member_id},
            success: function(data) {           
              
              App.unblockUI();

              $('#upline_placement_position').html(data.opts);

            },
            type: 'POST',
        }); 
    }
});

$("#upline_placement_position").change(function() {
    var upline_id = $('#upline_placement_position').val();

    $('#upline_pos').prop( "disabled", true );

    $.ajax({
        url: base_url+"admin/members/ajax/check-upline-position-available",
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

jQuery(document).ready(function() {
   // initiate layout and plugins
    Layout.init(); // init current layout
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