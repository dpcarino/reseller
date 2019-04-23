<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Packages</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Packages</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php if($package_id == 0): ?>
                            <a href="#">Add Package</a>
                        <?php else: ?>
                            <a href="#">Edit Package</a>
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
                            <?php echo form_open_multipart('admin/packages/package-form/'.$package_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Package Details</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Enable Package <span class="required">
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
                                                <label class="control-label col-md-2">Package Name <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <input type="text" name="package_name" class="form-control" data-required="1" value="<?php echo $package_name; ?>">
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Package Prefix <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="package_prefix" class="form-control" data-required="1" value="<?php echo $package_prefix; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Is CD <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <select name="is_cd" id="is_cd" class="form-control">
                                                        <option value="0" <?php echo ($is_cd == 0 ? 'selected' : ''); ?> >No</option>
                                                        <option value="1" <?php echo ($is_cd == 1 ? 'selected' : ''); ?> >Yes</option>
                                                     </select>
                                                </div>
                                            </div>
                                            <?php if($is_cd == 1 && $package_id != 0): ?>
                                            <div class="form-group" id="cd_value_form">
                                                <label class="control-label col-md-2">CD Value <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="cd_value" class="form-control" data-required="1" value="<?php echo $cd_value; ?>">
                                                </div>
                                            </div>  
                                            <?php else: ?>
                                            <div class="form-group" id="cd_value_form" style="display: none;">
                                                <label class="control-label col-md-2">CD Value <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="cd_value" class="form-control" data-required="1" value="<?php echo $cd_value; ?>">
                                                </div>
                                            </div>  
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="package_id" class="form-control" data-required="1" value="<?php echo $package_id; ?>">
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

<?php include('includes/footer.php'); ?>


<script type="text/javascript">
jQuery(document).ready(function() {
   // initiate layout and plugins
    Layout.init(); // init current layout
});

$('#is_cd').on('change', function() {
  var is_cd = this.value;

  if(is_cd == 1){
    $('#cd_value_form').show();
  }else{
    $('#cd_value_form').hide();
  }
});

</script>