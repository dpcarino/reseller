<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Member Information</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Member</span>
                    <i class="fa fa-angle-right"></i>
	            </li>
                <li>
                    <span>Search</span>
                </li>                
	        </ul>         
	    </div>
	    <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <?php include('includes/notes.php'); ?>             
                <div class="portlet box yellow ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i>Member Search Details
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php echo form_open_multipart('member/search/', array('class'=>'form-horizontal', 'id'=>'request_form')); ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">First Name: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="First Name" name="first_name" value="<?php echo $first_name; ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Middle Name: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="Middle Name" name="middle_name" value="<?php echo $middle_name; ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Last Name: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo $last_name; ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: left; width: 15%;">Email Address: </label>
                                    <div class="col-md-9">
                                        <input type="text" style="width: 50%;" class="form-control" placeholder="Email Address" name="email" value="<?php echo $email; ?>"> 
                                    </div>
                                </div>  
                            </div>
                            <div class="form-actions right">
                                <a href="<?php echo site_url('member/search'); ?>" class="btn default"> Reset </a>
                                <button type="submit" class="btn yellow"><i class="fa fa-check"></i> Search</button>
                            </div>
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
                            <th width="5%">Username</th>
                            <th width="5%">First Name</th>
                            <th width="5%">Middle Name</th>
                            <th width="5%">Last Name</th>
                            <th width="5%">Membership Status</th>
                            <th width="10%">Date of Registration</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($members)): ?>
                                <tr>
                                    <td colspan="6">No data available in table</td>
                                </tr>                                
                            <?php else: ?>
                                <?php foreach($members as $member): ?>
                                    <tr>
                                        <td><?php echo $member->username; ?></td>
                                        <td><?php echo $member->first_name; ?></td>
                                        <td><?php echo $member->middle_name; ?></td>
                                        <td><?php echo $member->last_name; ?></td>
                                        <td>
                                            <?php
                                                $member_status_info = $this->Settings_model->get_setting_member($member->member_status);
                                            ?>
                                            <?php echo $member_status_info->status_name; ?>
                                        </td>
                                        <td><?php echo $member->created_on; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>            
	</div>
	<!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>

<script>

</script>