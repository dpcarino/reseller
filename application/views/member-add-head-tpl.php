<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Add New Head</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Add Head</span>
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
                            <i class="fa fa-gift"></i>Member Head Form 
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <?php echo form_open_multipart('member/add_heads/', array('id'=>'head_form')); ?>
                            <div class="form-body">
                                <h3 class="form-section">PLACEMENT DETAILS</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sponsor<span class="required"> * </span></label>
                                            <select name="sponsor_id" class="form-control" id="sponsor_id">
                                                <option value="">Select Sponsor</option>
                                                <?php foreach($heads as $head): ?>
                                                <option value="<?php echo $head->head_id; ?>"><?php echo $head->headname; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>      
                                </div>
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
                                <?php if($head_count < $member_setting->head_count): ?>
                                <a href="<?php echo site_url('/'); ?>" class="btn default"> Cancel </a>
                                <button type="submit" class="btn yellow" id="btn-save-member">
                                    <i class="fa fa-check"></i> Agree & Save</button>
                                <?php else: ?>
                                    <a href="<?php echo site_url('/'); ?>" class="btn default"> Full Head Count </a>
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
        <p class="text-left" id="confirm-msg">Do you agree that all data that you have entered is correct? Click YES to continue</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
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

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$( function() {
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
        endDate: '+0d',
	});
});

$("#package_id").change(function() {
    var package_id = $('#package_id').val();
    if(package_id == ''){
        $('#available-code').html('');
        $('#code_available').val('');
    }else{
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

$("#entry-summary").click(function() {
    $('#available-codes-modal').modal('show');
});

$('#head_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$('#head_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#head_form').unbind('submit').submit();
});
</script>