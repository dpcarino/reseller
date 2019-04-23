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
            <h3 class="page-title">Elite Settings</h3>

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
                        <a href="#">Elite</a>
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
                            <?php echo form_open_multipart('admin/settings/elite-settings', array('class'=>'form-horizontal', 'id'=>'company_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Elite Settings Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">                                     
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Gold Direct Refferal <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="GoldDirectRefferal" id="GoldDirectRefferal" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['GoldDirectRefferal']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Gold Pairing Bonus <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="GoldPairingBonus" id="GoldPairingBonus" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['GoldPairingBonus']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Gold GSC Points <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="GoldGSCPoints" id="GoldGSCPoints" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['GoldGSCPoints']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Flush Out <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="FlushOut" id="FlushOut" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['FlushOut']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Knight Days <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="KnightDateDiff" id="KnightDateDiff" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['KnightDateDiff']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">CD Deduction Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="CD_deduction_percentage" id="CD_deduction_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['CD_deduction_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Knight 1 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="knight_lvl_1_percentage" id="knight_lvl_1_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['knight_lvl_1_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Knight 2 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="knight_lvl_2_percentage" id="knight_lvl_2_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['knight_lvl_2_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 1 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_1_percentage" id="leader_lvl_1_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_1_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 2 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_2_percentage" id="leader_lvl_2_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_2_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 3 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_3_percentage" id="leader_lvl_3_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_3_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 4 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_4_percentage" id="leader_lvl_4_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_4_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 5 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_5_percentage" id="leader_lvl_5_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_5_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 6 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_6_percentage" id="leader_lvl_6_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_6_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 7 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_7_percentage" id="leader_lvl_7_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_7_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 8 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_8_percentage" id="leader_lvl_8_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_8_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 9 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_9_percentage" id="leader_lvl_9_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_9_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 10 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_10_percentage" id="leader_lvl_10_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_10_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 11 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_11_percentage" id="leader_lvl_11_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_11_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 12 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_12_percentage" id="leader_lvl_12_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_12_percentage']; ?>">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 13 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_13_percentage" id="leader_lvl_13_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_13_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 14 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_14_percentage" id="leader_lvl_14_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_14_percentage']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Leader 15 Percent <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="leader_lvl_15_percentage" id="leader_lvl_15_percentage" class="form-control" data-required="1" onkeypress="return validateFloatKeyPress(this,event);" value="<?php echo $settings['leader_lvl_15_percentage']; ?>">
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