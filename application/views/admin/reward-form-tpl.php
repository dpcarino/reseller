<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Reward</h3>

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
                        <?php if($reward_id == 0): ?>
                            <a href="#">Add Reward</a>
                        <?php else: ?>
                            <a href="#">Edit Reward</a>
                        <?php endif; ?>
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
                            <?php echo form_open_multipart('admin/settings/reward-form/'.$reward_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Reward Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Enable Reward <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <select name="status" class="form-control">
                                                        <option value="0" <?php echo ($status == 0 ? 'selected' : ''); ?> >Yes</option>
                                                        <option value="1" <?php echo ($status == 1 ? 'selected' : ''); ?> >No</option>
                                                     </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Reward <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="reward" class="form-control" data-required="1" value="<?php echo $reward; ?>">
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Description <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="10" name="reward_description"><?php echo $reward_description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Stars Required <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="stars_required" class="form-control" data-required="1" value="<?php echo $stars_required; ?>" onkeypress="return isNumberKey(event);" maxlength="3">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Reward Image <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <?php if (empty($reward_img)): ?>
                                                        <input type="file" id="reward_img" name="reward_img"/>
                                                    <?php else: ?>
                                                        <?php //echo $profile_photo; ?>
                                                        <img src="<?php echo site_url('uploads') . '/rewards/' . $reward_img; ?>" style="width: 150px;">
                                                        <br/><br/>
                                                        <input type="file" id="reward_img" name="reward_img"/>
                                                    <?php endif; ?>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="reward_id" class="form-control" data-required="1" value="<?php echo $reward_id; ?>">
                                        <button type="submit" class="btn green">Submit</button>
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

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$("#reward_img-edit").click(function () {
    $("#reward_img").trigger('click');
}); 
</script>