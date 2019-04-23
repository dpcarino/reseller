<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Annoucement</h3>

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
                        <?php if($announcement_id == 0): ?>
                            <a href="#">Add Annoucement</a>
                        <?php else: ?>
                            <a href="#">Edit Annoucement</a>
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
                            <?php echo form_open_multipart('admin/settings/annoucement-form/'.$announcement_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Annoucement Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Enable Notification <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <select name="notify" class="form-control">
                                                        <option value="1" <?php echo ($notify == 1 ? 'selected' : ''); ?>>Enable</option>
                                                        <option value="0" <?php echo ($notify == 0 ? 'selected' : ''); ?>>Disable</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Teaser <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="10" name="teaser"><?php echo $teaser; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Message <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="10" name="message"><?php echo $message; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Announcement Image <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <?php if (empty($announcement_img)): ?>
                                                        <input type="file" id="announcement_img" name="announcement_img"/>
                                                    <?php else: ?>
                                                        <?php //echo $profile_photo; ?>
                                                        <img src="<?php echo site_url('uploads') . '/announcement/' . $announcement_img; ?>" style="width: 150px;">
                                                        <br/><br/>
                                                        <input type="file" id="announcement_img" name="announcement_img"/>
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
                                        <button type="submit" class="btn green">Submit</button>
                                        <a href="<?php echo site_url('admin/settings/announcements');?>" class="btn default">Cancel</a>
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

</script>