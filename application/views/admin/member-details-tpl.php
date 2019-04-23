<?php include('includes/header.php'); ?>
<style>
#container canvas {
    width: 392px;
}

#container-small canvas {
    width: 150px;
}

#id-container canvas {
    width: 150px;
}
</style>
<?php
    $user = $this->ion_auth_admin->user()->row();
?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Members Information</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('/admin/members/search'); ?>">Members</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Search</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-grid"></i>Member Details
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php include('includes/notes.php'); ?>
                </div>                
            </div>
            <div class="profile">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <?php 
                            if(empty($printed_message)){
                                $class_1 = 'active';
                                $class_2 = '';
                            }else{
                                $class_1 = '';
                                $class_2 = 'active';
                            }
                        ?>
                        <li class="<?php echo $class_1; ?>">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> Overview </a>
                        </li>
                        <li class="<?php echo $class_2; ?>">
                            <a href="#tab_1_3" data-toggle="tab" aria-expanded="false"> Account </a>
                        </li>
                    </ul>
                    <?php 
                        if(empty($printed_message)){
                            $class_1 = 'active';
                            $class_2 = '';
                        }else{
                            $class_1 = '';
                            $class_2 = 'active';
                        }
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane <?php echo $class_1; ?>" id="tab_1_1">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            <!-- <img src="" class="img-responsive pic-bordered" alt="" id='profile-pic'> -->
                                            <div id="container"></div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8 profile-info">
                                            <h1 class="font-green sbold uppercase"><?php echo $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name; ?></h1>
                                            <p> 
                                                <?php echo $member_details_info->address; ?>
                                            </p>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-map-marker"></i> <?php echo ucfirst($member_details_info->civil_status); ?> 
                                                </li>
                                                <li>
                                                    <i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($member_details_info->dob)); ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-internet-explorer"></i> <?php echo $member_info->email; ?>
                                                </li>
                                            </ul>
                                            <ul class="list-inline">                                                
                                                <li>
                                                    <i class="fa fa-ticket"></i> CD - <?php echo $cd_codes_cnt; ?>
                                                </li>
                                                <li>
                                                    <i class="fa fa-ticket"></i> PAID - <?php echo $paid_codes_cnt; ?>
                                                </li>
                                            </ul>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-level-up"></i> Member Status - <?php echo $member_setting_info->status_name; ?>
                                                </li>
                                            </ul>
                                            <?php if(!empty($member_used_to_info)): ?>
                                            <!--ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-info-circle"></i> Registered By - <?php echo $member_used_to_info->first_name.' '.$member_used_to_info->middle_name.' '.$member_used_to_info->last_name; ?>
                                                </li>
                                            </ul>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-ticket"></i> Code Used - <?php echo $used_to_info->code; ?>
                                                </li>
                                            </ul-->
                                            <?php endif; ?>
                                        </div>
                                        <!--end col-md-8-->
                                        <div class="col-md-4">
                                            <div class="portlet sale-summary">
                                                <div class="portlet-title">
                                                    <div class="caption font-red sbold">Wallet Summaries </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <span class="sale-info"> WALLET
                                                                <i class="fa fa-img-up"></i>
                                                            </span>
                                                            <span class="sale-num">₱ <?php echo number_format($member_wallet_info->amount); ?> </span>
                                                        </li>
                                                        <li>
                                                            <span class="sale-info"> STARS
                                                                <i class="fa fa-img-down"></i>
                                                            </span>
                                                            <span class="sale-num"> <?php echo $member_star_wallet_info->stars; ?> </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-md-4-->
                                    </div>
                                    <!--end row-->
                                    <div class="tabbable-line tabbable-custom-profile">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_11" data-toggle="tab" aria-expanded="true"> Heads </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1_11">
                                                <div class="portlet-body">
                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <i class="fa fa-briefcase"></i> Head Name 
                                                                </th>
                                                                <th>
                                                                    <i class="fa fa-info"></i> Sponsor 
                                                                </th>
                                                                <th>
                                                                    <i class="fa fa-info"></i> Sponsor Head Name 
                                                                </th>
                                                                <th>
                                                                    <i class="fa fa-money"></i> Total Income 
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($heads as $head): ?>
                                                            <?php
                                                                if($head->sponsor_id != 0){
                                                                    $sponsor_info = $this->Heads_model->get_head($head->sponsor_id);
                                                                    $sponsor_details = $this->Members_model->get_member_details($sponsor_info->member_id);

                                                                    $sponsor_headname = $sponsor_info->headname;
                                                                    $sponsor_name = $sponsor_details->first_name.' '.$sponsor_details->middle_name.' '.$sponsor_details->last_name;
                                                                }else{
                                                                    $sponsor_headname = 'NA';
                                                                    $sponsor_name = 'NA';
                                                                }
                                                                
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $head->headname; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $sponsor_name; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $sponsor_headname; ?>
                                                                </td>
                                                                <td> 
                                                                    ₱ <?php echo number_format($head->total_income); ?>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--tab-pane-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->
                        <?php
                            $personal_info_css = $this->session->userdata('personal_info_css');
                            $valid_photo_css = $this->session->userdata('valid_photo_css');
                            $change_password_css = $this->session->userdata('change_password_css');
                            $bank_info_css = $this->session->userdata('bank_info_css');
                            $security_pin_css = $this->session->userdata('security_pin_css');

                            if(empty($personal_info_css) && empty($valid_photo_css) && empty($change_password_css) && empty($bank_info_css) && empty($security_pin_css)){
                                $initial = 'active';
                            }else{
                                $initial = '';
                            }
                        ?>                    
                        <div class="tab-pane <?php echo $class_2; ?>" id="tab_1_3">
                            <div class="row profile-account">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="<?php echo (!empty($personal_info_css) ? 'active' : '' ); ?> <?php echo $initial; ?>">
                                            <a data-toggle="tab" href="#tab_1-1" aria-expanded="false">
                                                <i class="fa fa-cog"></i> Personal info </a>
                                            <span class="after"> </span>
                                        </li>
                                        <?php if($user->group_id == 1): ?>
                                        <li class="<?php echo (!empty($bank_info_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_4-4" aria-expanded="false">
                                                <i class="fa fa-bank"></i> Bank Information </a>
                                        </li>                                    
                                        <li class="<?php echo (!empty($valid_photo_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_2-2" aria-expanded="false">
                                                <i class="fa fa-picture-o"></i> Valid Photos </a>
                                        </li>
                                        <li class="<?php echo (!empty($change_password_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_3-3" aria-expanded="false">
                                                <i class="fa fa-lock"></i> Change Password </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_5-5" aria-expanded="false">
                                                <i class="fa fa-lock"></i> Security Pin </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_6-6" aria-expanded="false">
                                                <i class="fa fa-user-times"></i> Block Account </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_7-7" aria-expanded="false">
                                                <i class="fa fa-envelope"></i> Update Email </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_11-11" aria-expanded="false">
                                                <i class="fa fa-envelope"></i> Resend Activation </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_8-8" aria-expanded="false">
                                                <i class="fa fa-level-up"></i> Member Status </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_9-9" aria-expanded="false">
                                                <i class="fa fa-user-times"></i> Activate Member </a>
                                        </li> 
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_10-10" aria-expanded="false">
                                                <i class="fa fa-money"></i> Enable Encashment </a>
                                        </li>
                                        <li class="<?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <a data-toggle="tab" href="#tab_12-12" aria-expanded="false">
                                                <i class="fa fa-money"></i> QR Code </a>
                                        </li>
                                        <?php endif; ?>                                        
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div id="tab_1-1" class="tab-pane <?php echo (!empty($personal_info_css) ? 'active' : '' ); ?>  <?php echo $initial; ?>">
                                            <?php echo form_open_multipart('admin/members/update-personal-info/'.$member_info->member_id, array('id'=>'member_form')); ?>
                                                <h3 class="form-section">PERSONAL INFORMATION</h3>
                                                <div class="form-group">
                                                <label class="control-label">First Name <span class="required"> * </span></label>
                                                <input type="text" name="first_name" class="form-control" value="<?php echo $member_details_info->first_name; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Middle Name</label>
                                                    <input type="text" name="middle_name" class="form-control" value="<?php echo $member_details_info->middle_name; ?>" placeholder=""> 
                                                </div>                                            
                                                <div class="form-group">
                                                    <label class="control-label">Last Name<span class="required"> * </span></label>
                                                    <input type="text" name="last_name" class="form-control" value="<?php echo $member_details_info->last_name; ?>" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Citizenship<span class="required"> * </span></label>
                                                    <select class="form-control" name="citizenship" id="citizenship">
                                                    <option value="">Select Citizenship</option>
                                                    <?php foreach($citizenships as $citizenship): ?>
                                                        <option value="<?php echo $citizenship->nationality; ?>" <?php echo ($member_details_info->citizenship == $citizenship->nationality ? 'selected': ''); ?>><?php echo $citizenship->nationality; ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Date of Birth<span class="required"> * </span></label>
                                                    <input type="text" class="form-control" value="<?php echo date('Y-m-d', strtotime($member_details_info->dob)); ?>" placeholder="yyyy-mm-dd" name="dob" id="dob" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Place of Birth<span class="required"> * </span></label>
                                                    <select class="form-control" name="pob" id="pob">
                                                        <option value="">Select City</option>
                                                        <?php foreach($cities as $city): ?>
                                                            <option value="<?php echo $city->name; ?>" <?php echo ($member_details_info->pob == $city->name ? 'selected': ''); ?>><?php echo $city->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>   
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Civil Status</label><span class="required"> * </span>
                                                    <select class="form-control" name="civil_status" id="civil_status">
                                                        <option value="single" <?php echo ($member_details_info->civil_status == 'single' ? 'selected': ''); ?>>Single</option>
                                                        <option value="married" <?php echo ($member_details_info->civil_status == 'married' ? 'selected': ''); ?>>Married</option>
                                                        <option value="divorced" <?php echo ($member_details_info->civil_status == 'divorced' ? 'selected': ''); ?>>Divorced</option>
                                                        <option value="widow" <?php echo ($member_details_info->civil_status == 'widow' ? 'selected': ''); ?>>Widow</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tin Number</label><span class="required"> * </span>
                                                    <input type="text" name="tin_number" id="tin_number" value="<?php echo $member_details_info->tin_number; ?>" class="form-control">
                                                </div>
                                                <h3 class="form-section">CONTACT DETAILS</h3>
                                                <div class="form-group">
                                                    <label class="control-label">Telephone No.</label>
                                                    <input type="text" value="<?php echo $member_details_info->telephone; ?>" name="telephone" id="telephone" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mobile No.<span class="required"> * </span></label>
                                                    <input type="text" value="<?php echo $member_details_info->mobile; ?>" name="mobile" id="mobile" class="form-control" placeholder="" onkeypress='return isNumberKey(event)' maxlength="11">
                                                </div>
                                                <h3 class="form-section">ADDRESS</h3>
                                                <div class="form-group">
                                                    <label>Full Address<span class="required"> * </span></label>
                                                    <textarea class="form-control" rows="3" name="address" id="address"><?php echo $member_details_info->address; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>City<span class="required"> * </span></label>
                                                    <select class="form-control" name="city" id="city">
                                                        <option value="">Select City</option>
                                                        <?php foreach($cities as $city): ?>
                                                            <option value="<?php echo $city->name; ?>" <?php echo ($member_details_info->city == $city->name ? 'selected': ''); ?>><?php echo $city->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Province<span class="required"> * </span></label>
                                                    <select class="form-control" name="province" id="province">
                                                        <option value="">Select Provinces</option>
                                                        <?php foreach($provinces as $province): ?>
                                                            <option value="<?php echo $province->name; ?>"  <?php echo ($member_details_info->province == $province->name ? 'selected': ''); ?>><?php echo $province->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <?php if($user->group_id == 1): ?>
                                                <div class="margiv-top-10">
                                                    <button type="submit" class="btn green"> Save Changes </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                        <div id="tab_2-2" class="tab-pane <?php echo (!empty($valid_photo_css) ? 'active' : '' ); ?>">
                                            <?php echo form_open_multipart('admin/members/upload-valid-photo/'.$member_info->member_id, array('id'=>'photo_form')); ?>
                                                <input type="hidden" name="invalidate" value="">
                                                <input type="hidden" name="member_id" value="<?php echo $member_info->member_id; ?>">
                                                <div class="form-group">
                                                    <label class="control-label">Member Photo</label>
                                                    <?php if (empty($member_details_info->authorized_id_img_1)): ?>
                                                        <input type="file" id="authorized_id_img_1" name="authorized_id_img_1"/>
                                                    <?php else: ?>
                                                        <?php //echo $profile_photo; ?>
                                                        <!-- <img src="<?php echo site_url('uploads') . '/members/image/' . $member_details_info->authorized_id_img_1; ?>" style="width: 150px;"> -->
                                                        <div id="container-small"></div>
                                                        <br/><br/>
                                                        <input type="file" id="authorized_id_img_1" name="authorized_id_img_1"/>
                                                    <?php endif; ?>                                                
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Valid ID</label>
                                                    <?php if (empty($member_details_info->authorized_id_img_2)): ?>
                                                        <input type="file" id="authorized_id_img_2" name="authorized_id_img_2"/>
                                                    <?php else: ?>
                                                        <?php //echo $profile_photo; ?>
                                                        <!-- <img src="<?php echo site_url('uploads') . '/members/valid_id/' . $member_details_info->authorized_id_img_2; ?>" style="width: 150px;"> -->

                                                        <div id="id-container"></div>
                                                        <br/><br/>
                                                        <input type="file" id="authorized_id_img_2" name="authorized_id_img_2"/>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_3-3" class="tab-pane <?php echo (!empty($change_password_css) ? 'active' : '' ); ?>">
                                            <?php echo form_open_multipart('admin/members/update-password/'.$member_info->member_id, array('id'=>'password_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input type="password" class="form-control" name="new_password"> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input type="password" class="form-control" name="confirm_password"> 
                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_4-4" class="tab-pane <?php echo (!empty($bank_info_css) ? 'active' : '' ); ?>">
                                            <?php echo form_open_multipart('admin/members/bank-information/'.$member_info->member_id, array('id'=>'bank_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Bank</label>
                                                    <select class="form-control" name="bank">
                                                        <option value="AUB">AUB</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Account Name</label>
                                                    <input type="text" class="form-control" name="bank_acct_name" value="<?php echo $member_details_info->bank_acct_name; ?>"> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Account Number</label>
                                                    <input type="text" class="form-control" name="bank_acct_number" onkeypress='return isNumberKey(event)' value="<?php echo $member_details_info->bank_acct_number; ?>"> 
                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_5-5" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will reset the members Security PIN</p>
                                            <?php echo form_open_multipart('admin/members/security-pin/'.$member_info->member_id, array('id'=>'security_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Reset Security Pin</label>
                                                    <select class="form-control" name="reset_pin">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_6-6" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will BLOCK the members account</p>
                                            <?php echo form_open_multipart('admin/members/block-account/'.$member_info->member_id, array('id'=>'lock_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Lock Account</label>
                                                    <select class="form-control" name="blocked">
                                                        <option value="0" <?php echo ($member_info->blocked == 0 ? 'selected':''); ?>>Unblocked</option>
                                                        <option value="1" <?php echo ($member_info->blocked == 1 ? 'selected':''); ?>>Blocked</option>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>  
                                        <div id="tab_7-7" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <?php echo form_open_multipart('admin/members/update-email/'.$member_info->member_id, array('id'=>'email_form')); ?>
                                                <h3 class="form-section">EMAIL INFORMATION</h3>
                                                <div class="form-group">
                                                    <label class="control-label">Member E-mail</label>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $member_info->email; ?>">
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div> 
                                        <div id="tab_8-8" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will CHANGE the Member Status</p>
                                            <?php echo form_open_multipart('admin/members/member-status/'.$member_info->member_id, array('id'=>'lock_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Lock Account</label>
                                                    <select class="form-control" name="member_status">
                                                        <?php foreach($setting_members as $setting_member): ?>
                                                            <option value="<?php echo $setting_member->status_number; ?>" <?php echo ($member_details_info->member_status == $setting_member->status_number ? 'selected':''); ?>>
                                                                <?php echo $setting_member->status_name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_9-9" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will ACTIVATE or DEACTIVATE the Member</p>
                                            <?php echo form_open_multipart('admin/members/activate-member/'.$member_info->member_id, array('id'=>'lock_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Activate Account</label>
                                                    <select class="form-control" name="active">
                                                        <option value="1" <?php echo ($member_info->active == 1 ? 'selected':''); ?>>Activated</option>
                                                        <option value="0" <?php echo ($member_info->active == 0 ? 'selected':''); ?>>Deactivated</option>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_10-10" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will ACTIVATE or DEACTIVATE the Encashment of this Member</p>
                                            <?php echo form_open_multipart('admin/members/activate-encashment/'.$member_info->member_id, array('id'=>'lock_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Activate Encashment</label>
                                                    <select class="form-control" name="encashment">
                                                        <option value="1" <?php echo ($member_details_info->encashment == 1 ? 'selected':''); ?>>Activated</option>
                                                        <option value="0" <?php echo ($member_details_info->encashment == 0 ? 'selected':''); ?>>Deactivated</option>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_11-11" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> WARNING: This will reset the members ACTIVE STATUS AND PASSWORD AND WILL RESEND AN ACTIVATION EMAIL</p>
                                            <?php echo form_open_multipart('admin/members/resend-activation/'.$member_info->member_id, array('id'=>'security_form')); ?>
                                                <div class="form-group">
                                                    <label class="control-label">Resend Activation Email</label>
                                                    <select class="form-control" name="resend">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>                                            
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    <a href="<?php echo site_url('admin/members/search'); ?>" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_12-12" class="tab-pane <?php echo (!empty($security_pin_css) ? 'active' : '' ); ?>">
                                            <p style="color: red;"> QR Code</p>
                                            <img src="<?php echo site_url('uploads') . '/qrcode/' . $member_info->username.'.png'; ?>" style="width: 150px;">
                                        </div>
                                    </div>
                                </div>
                                <!--end col-md-9-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( document ).ready(function() {
    var src = '<?php echo site_url('uploads') . '/members/image/' . $member_details_info->authorized_id_img_1; ?>';

    window.loadImage(src, function (img) {
        if (img.type === "error") {
            console.log("couldn't load image:", img);
        } else {
            window.EXIF.getData(img, function () {
                console.log("done!");
                var orientation = window.EXIF.getTag(this, "Orientation");
                var canvas = window.loadImage.scale(img, {orientation: orientation || 0, canvas: true});
                var canvas2 = window.loadImage.scale(img, {orientation: orientation || 0, canvas: true});
                // alert(canvas);
                // document.getElementById("profile-pic").appendChild(canvas);
                $("#container").append(canvas);
                $("#container-small").append(canvas2);
            });
        }
    });

    var id_src = '<?php echo site_url('uploads') . '/members/valid_id/' . $member_details_info->authorized_id_img_2; ?>';

    window.loadImage(id_src, function (id_img) {
        if (id_img.type === "error") {
            console.log("couldn't load image:", id_img);
        } else {
            window.EXIF.getData(id_img, function () {
                console.log("done!");
                var id_orientation = window.EXIF.getTag(this, "Orientation");
                var id_canvas = window.loadImage.scale(id_img, {orientation: id_orientation || 0, canvas: true});
                // alert(canvas);
                // document.getElementById("profile-pic").appendChild(canvas);
                $("#id-container").append(id_canvas);
            });
        }
    });    
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$( function() {
    $('#dob').datepicker({
        changeMonth: true, 
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: "-100:+0",
    });
});

$("#authorized_id_img_1-edit").click(function () {
    $("#authorized_id_img_1").trigger('click');
});

$("#authorized_id_img_2-edit").click(function () {
    $("#authorized_id_img_2").trigger('click');
});     
</script>