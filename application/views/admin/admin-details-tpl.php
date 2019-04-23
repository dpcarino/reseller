<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Admin Details</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Admin</a>
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
                            <?php echo form_open_multipart('admin/detail/'.$admin_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Admin Information</span>
                                            </div>                                       
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">First Name <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="first_name" class="form-control" data-required="1" value="<?php echo $first_name; ?>">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Last Name <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="last_name" class="form-control" data-required="1" value="<?php echo $last_name; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Username <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="username" class="form-control" data-required="1" value="<?php echo $username; ?>" <?php echo ($admin_id != 0 ? 'readonly': ''); ?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Email <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="email" class="form-control" data-required="1" value="<?php echo $email; ?>" <?php echo ($admin_id != 0 ? 'readonly': ''); ?>>
                                                </div>
                                            </div>
                                            <?php if($admin_id != 0): ?>
                                                <h3 class="form-section" style="font-size: 15px;">Leave password fields blank to not change the password</h3>  
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Password <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="password" name="password" class="form-control" data-required="1">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Confirm Password <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="password" name="password_confirm" class="form-control" data-required="1">
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
        <h3 class="modal-title" id='confirm-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="confirm-msg">Are you sure you want to continue update the status?</p>
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

$('#setting_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#setting_form').unbind('submit').submit();
});
</script>