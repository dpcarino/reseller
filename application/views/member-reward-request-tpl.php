<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Request Rewards</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Request</span>
                    <i class="fa fa-angle-right"></i>
	            </li>
                <li>
                    <span>Rewards</span>
                </li>                
	        </ul>         
	    </div>
	    <!-- END PAGE HEADER-->
        <?php if($encashment_settings['active'] == 0): ?>
	    <div class="row">
	        <div class="col-md-12">
                <?php include('includes/notes.php'); ?>
                <?php if($member_details_info->encashment == 1): ?>
                    <div class="note note-danger">
                        <p> Dear member,</p>
                        <br>
                        <p> Rewards request will be de-activated after this encashment period, to fully enjoy please complete the ff in your profile page: </p>
                        <br>
                        <?php if($memberhead_details_info->is_profile_complete == 0): ?>
                            <p>Valid ID</p>
                        <?php endif; ?>
                        <?php if($memberhead_details_info->tin_number == ''): ?>
                            <p>Tin Number</p>
                        <?php endif; ?>
                        <?php if($member_pin_info->security_pin == ''): ?>
                            <p>Security Pin</p>
                        <?php endif; ?>
                        <?php if($memberhead_details_info->bank_acct_name == '' && $memberhead_details_info->bank_acct_number == ''): ?>
                            <p>To activate request type BANK please update your banking informtion</p>
                        <?php endif; ?>
                        <br>                 
                        <p> Thanks,</p>
                        <p> Essensa Administrator</p>
                    </div>                         
                <?php else: ?>                
                    <?php if($memberhead_details_info->is_profile_complete == 0 OR $memberhead_details_info->tin_number == '' OR $member_pin_info->security_pin == ''): ?>
                    <div class="note note-danger">
                        <p> Dear member,</p>
                        <br>
                        <p> Please complete the ff in your profile page: </p>
                        <br>
                        <?php if($memberhead_details_info->is_profile_complete == 0): ?>
                            <p>Valid ID</p>
                        <?php endif; ?>
                        <?php if($memberhead_details_info->tin_number == ''): ?>
                            <p>Tin Number</p>
                        <?php endif; ?>
                        <?php if($member_pin_info->security_pin == ''): ?>
                            <p>Security Pin</p>
                        <?php endif; ?>                        
                        <br>                 
                        <p> Thanks,</p>
                        <p> Essensa Administrator</p>
                    </div>  
                    <?php endif; ?>                  
                <?php endif; ?>                  
                <div class="portlet box yellow ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i>Reward Claim Details
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php echo form_open_multipart('request/rewards/', array('class'=>'form-horizontal', 'id'=>'request_form')); ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Current Star Wallet: </label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> <?php echo number_format($member_star_wallet_info->stars); ?> </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Reward: </label>
                                    <div class="col-md-9">
                                        <select name="reward" style="width: 50%;" class="form-control">
                                            <option value="">Select Reward</option>
                                            <?php foreach($rewards as $reward): ?>
                                                <?php if($member_star_wallet_info->stars >= $reward->stars_required): ?>
                                                    <option value="<?php echo $reward->reward_id; ?>"><?php echo $reward->reward; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Security Pin: </label>
                                    <div class="col-md-9">
                                        <input type="password" style="width: 50%;" class="form-control" placeholder="Enter Security Pin" onkeypress="return isNumberKey(event);" name="security_pin" maxlength="6"> 
                                    </div>
                                </div>                                
                            </div>
                            <?php if($member_details_info->encashment == 1): ?>
                            <div class="form-actions right">
                                <a href="<?php echo site_url('/'); ?>" class="btn default"> Cancel </a>
                                <button type="submit" class="btn yellow"><i class="fa fa-check"></i> Submit Request</button>
                            </div>
                            <?php else: ?>
                            <div class="form-actions right">
                                <a href="<?php echo site_url('/'); ?>" class="btn default"> Cancel </a>
                                <?php if($memberhead_details_info->is_profile_complete == 1 && $memberhead_details_info->tin_number != '' && $member_pin_info->security_pin != ''): ?>
                                    <button type="submit" class="btn yellow"><i class="fa fa-check"></i> Submit Request</button>
                                <?php else: ?>
                                    <a href="<?php echo site_url('profile'); ?>" class="btn default"> Update Profile </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
	        </div>
	    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                </div>                
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="10%">Date Requested</th>
                            <th width="10%">Reward</th>
                            <th width="5%">Stars</th>
                            <th width="10%">Reward Claiming Status</th>
                            <th width="15%">
                                 Actions
                            </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td></td>
                            <td></td>     
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>             
        <?php else: ?>
        <div class="note note-info">
            <p> To our valued members,</p>
            <br>
            <p> Rewards claiming are only available every Monday and Tuesday </p>
            <br>
            <p> Thanks,</p>
            <p> Essensa Administrator</p>
        </div>
        <?php endif; ?>       
	</div>
	<!-- END CONTENT BODY -->
</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='confirm-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="confirm-msg">Are you sure you want to continue your request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='cancel-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="cancel-msg">Are you sure you want to cancel your request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="cancel-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="cancel-no">No</button>
      </div>      
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
function cancelRequest(){
    $('#cancel').modal('show');
}

$("#cancel-yes").on('click', function (){

    var reward_claims_id = $('#cancel-request-button').data('claim-id');

    $.ajax({
        url: base_url+"requests/ajax/cancel-claim-request",
        data:{'reward_claims_id' : reward_claims_id},
        success: function(data) {           
            if(data.status == 'success'){
                location.reload();
            }                
        },
        type: 'POST',
    });
});


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$('#request_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#request_form').unbind('submit').submit();
});

var base_url = '<?php echo site_url(); ?>';

var Codes = function () {

    var handleCodes = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#datatable_admins"),
            onSuccess: function (grid) {
                // execute some code on network or other general error  
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": base_url + 'requests/ajax/get_current_claim_request', // ajax source
                },
                "order": [
                    [0, "desc"]
                ] // set first column as a default sort by asc
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleCodes();
        }
    };
}();

jQuery(document).ready(function() {
    Codes.init()
});
</script>