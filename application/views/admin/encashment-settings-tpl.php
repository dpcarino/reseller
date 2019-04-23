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
            <h3 class="page-title">Encashment Settings</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Settings</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Encashment & Rewards</a>
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
                        <div class="portlet-body form" id="country-container">
                            <?php echo form_open_multipart('admin/settings/encashment-settings', array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Encashment & Rewards Settings Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Encashment & Rewards <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="active" class="form-control">
                                                        <option value="0" <?php echo ($settings['active'] == 0 ? 'selected' : ''); ?>>Enable</option>
                                                        <option value="1" <?php echo ($settings['active'] == 1 ? 'selected' : ''); ?>>Disable</option>
                                                    </select>
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Minimum Request <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="minimum_request" id="minimum_request" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['minimum_request']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Tax <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="tax" id="tax" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['tax']; ?>">
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Processing Fee <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="processing_fee" id="processing_fee" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['processing_fee']; ?>">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Commission Deduction <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="commission_deduction" id="commission_deduction" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['commission_deduction']; ?>">
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green" id="generate-code">Update Settings</button>
                                        <a href="<?php echo site_url('admin/');?>" class="btn default">Cancel</a>
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
        <p class="text-left" id="confirm-msg">Are you sure you want to continue update the settings?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
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

$('#setting_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#setting_form').unbind('submit').submit();
});

</script>