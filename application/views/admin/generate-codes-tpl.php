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
            <h3 class="page-title">Generate Codes</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/codes');?>">Codes</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Generate Codes</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <?php include('includes/notes.php'); ?>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-grid"></i>Generate Codes
                            </div>
                        </div>
                        <div class="portlet-body form" id="country-container">
                            <?php echo form_open_multipart('admin/codes/generate', array('class'=>'form-horizontal', 'id'=>'generate_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Code Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Member Account <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="member_account" id="member_account" class="form-control" data-required="1" value="">
                                                    <input type="hidden" name="member_id" id="member_id" class="form-control" data-required="1" value="0">
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Package <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="package" id="package" class="form-control">
                                                        <option value="">Select Entry Package</option>
                                                        <?php foreach($packages as $package): ?>
                                                            <option value="<?php echo $package->package_id; ?>"><?php echo $package->package_name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Quantity <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="code_quantity" id="code_quantity" class="form-control" data-required="1" value="">
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Purchase Number <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="purchase_no" id="purchase_no" class="form-control" data-required="1" value="">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green" id="generate-code">Generate Code</button>
                                        <a href="<?php echo site_url('admin/codes/listings');?>" class="btn default">Cancel</a>
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
        <h3 class="modal-title" id='confirm-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="confirm-msg">Are you sure you want to continue generate and transfer the codes to <span id="member-account"></span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
      </div>      
    </div>
  </div>
</div>


<!--div class="modal fade" id="reseller" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='reseller-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="reseller-msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="reseller-yes">Ok</button>
      </div>      
    </div>
  </div>
</div-->

<?php include('includes/footer.php'); ?>


<script type="text/javascript">
jQuery(document).ready(function() {
   // initiate layout and plugins
    Layout.init(); // init current layout
});
</script>

<script>
    members = [

        <?php foreach($members as $member): ?>

            {value : '<?php echo $member->username; ?>', data: '<?php echo $member->member_id; ?>'},

        <?php endforeach; ?>

    ];

    $('#member_account').autocomplete({
        lookup: members,
        onSelect: function (suggestion) {
            $('#member_id').val(suggestion.data);
            //$('#package').removeAttr("disabled");
        }
    });

    $('#generate_form').submit(function(e) {
        e.preventDefault();
        var member_account = $('#member_account').val();
        $('#member-account').text(member_account);
        $('#confirm').modal('show');
    });

    /* for max 30
    $('#package').on('change', function() {
        
        if(this.value == 9){

            var member_id = $('#member_id').val();

            $.ajax({
                url: base_url+"admin/codes/ajax/check-member-reseller-code",
                data:{'member_id' : member_id},
                success: function(data) {
                    if(data.status == 'success'){

                        $('#reseller-msg').text(data.msg);
                        $('#reseller').modal('show');
                    }
                },
                type: 'POST',
            });
        }

    });
    */

    $("#confirm-yes").on('click', function (){
        var member_account = $('#member_account').val();
        var code_type = $('#code_type').val();
        var code_quantity = $('#code_quantity').val();

        App.blockUI({
            message: 'GENERATING '+code_quantity+' ENTRY CODES FOR '+member_account,
        });
                
        $('#generate_form').unbind('submit').submit();
    });
</script>