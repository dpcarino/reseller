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
                            <?php echo form_open_multipart('', array('class'=>'form-horizontal', 'id'=>'company_form')); ?>
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
                                                <label class="control-label col-md-2">Member Account
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="member_account" id="member_account" class="form-control" data-required="1" value="">
                                                    <input type="text" name="member_id" id="member_id" class="form-control" data-required="1" value="0">
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Code Type
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="code_type" id="code_type" class="form-control">
                                                        <option value="0">CD</option>
                                                        <option value="1">Paid</option>
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
                                        <button type="button" class="btn green" id="generate-code">Generate Code</button>
                                        <a href="<?php echo site_url('admin/codes/all');?>" class="btn default">Cancel</a>
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

<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='alert-type'></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="alert-msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="alert-close">Close</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="alert-ok" style="display: none;">Ok</button>
      </div>      
    </div>
  </div>
</div>


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
            $('#member_id').val(suggestion.data)
        }
    });

    $("#generate-code").on('click', function (){

        var member_id = $('#member_id').val();
        var code_type = $('#code_type').val();
        var code_quantity = $('#code_quantity').val();
        var purchase_no = $('#purchase_no').val();

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

        if(code_quantity == ''){
            error = 1;
            error_str = 'Please enter number of codes to be generated';
            alert_type = 'Error';
            $('#alert-msg').html(error_str);
            $('#alert-type').html(alert_type);
            $('#alert').modal('show');

            return;
        }


        if(purchase_no == ''){
            error = 1;
            error_str = 'Please enter purchase number';
            alert_type = 'Error';
            $('#alert-msg').html(error_str);
            $('#alert-type').html(alert_type);
            $('#alert').modal('show');

            return;
        }

        if(error != 1){

            $('#generate-code').text('Generating..');
            $('#generate-code').attr("disabled", "disabled");

            $.ajax({
                url: base_url+"admin/codes/ajax/generate-code",
                data:{'member_id' : member_id, 'code_type' : code_type, 'code_quantity' : code_quantity, 'purchase_no' : purchase_no},
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
        }
    });

    $("#alert-ok").on('click', function (){
        window.location.href = base_url+"admin/codes/listings";
    });
</script>