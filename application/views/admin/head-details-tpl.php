<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Head Details</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('admin/');?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javasript:;">Heads</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo $head_info->headname; ?></a>
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
                            <?php echo form_open_multipart('admin/heads/detail/'.$head_info->head_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Head Status</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Status <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                     <select name="status" class="form-control">
                                                        <option value="0" <?php echo ($head_info->status == 0 ? 'selected':'');  ?>>Active</option>
                                                        <option value="1" <?php echo ($head_info->status == 1 ? 'selected':'');  ?>>Blocked</option>
                                                     </select>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Head Information</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">                                            
                                            <div class="table-container">
                                                <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th width="5%">Head Name</th>
                                                    <th width="5%">CD Balance</th>
                                                    <th width="5%">Total Direct Bonus</th>
                                                    <th width="5%">Total GSC Bonus</th>
                                                    <th width="5%">Total Leadership Bonus</th>                                                    
                                                    <th width="5%">Total Income</th>                                                    
                                                    <th width="5%">Knight Status</th>                                                    
                                                    <th width="5%">Knight Date</th>                                                    
                                                </tr>
                                                <tr role="row" class="filter">
                                                    <td><?php echo $head_info->headname; ?></td>
                                                    <td><?php echo $head_info->cd_balance; ?></td>
                                                    <td><?php echo $head_info->total_direct_bonus; ?></td>
                                                    <td><?php echo $head_info->total_gsc_bonus; ?></td>
                                                    <td><?php echo $head_info->total_leadership_bonus; ?></td>
                                                    <td><?php echo $head_info->total_income; ?></td>
                                                    <td>
                                                        <?php
                                                            if($head_info->knight_status == 0){
                                                                echo 'NO';
                                                            }else{
                                                                echo 'YES';
                                                            }
                                                        ?>                                                
                                                    </td>
                                                    <td><?php echo $head_info->knight_date; ?></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-info-circle"></i>
                                                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Head Breakdown</span>
                                                </div>
                                            </div>
                                            <br>                                              
                                            <div class="table-container">
                                                <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Head Created On</td>
                                                        <td><?php echo $head_info->created_on;  ?></td>
                                                    </tr>                                                    
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Account Status</td>
                                                        <td><?php echo ($head_info->account_status == 1 ? 'PAID':'CD');  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Is Blocked?</td>
                                                        <td><?php echo ($head_info->status == 1 ? 'YES':'NO');  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Is Paylite?</td>
                                                        <td><?php echo ($head_info->is_paylite == 1 ? 'YES':'NO');  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Paid AR</td>
                                                        <td><?php echo ($head_info->paid_ar == '' ? 'N/A':$head_info->paid_ar);  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Knight AR</td>
                                                        <td><?php echo ($head_info->knight_ar == '' ? 'N/A':$head_info->knight_ar);  ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-info-circle"></i>
                                                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Reseller Information</span>
                                                </div>
                                            </div>
                                            <br>                                          
                                            <div class="table-container">
                                                <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Reseller</td>
                                                        <td><?php echo ($reseller_info->is_reseller == 1 ? 'YES':'NO');  ?></td>
                                                    </tr>                                                     
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Directs</td>
                                                        <td><?php echo $reseller_info->reseller_direct_count;  ?></td>
                                                    </tr>                                                    
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Referral Bonus</td>
                                                        <td><?php echo $reseller_info->reseller_referrall_bonus;  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Left Count</td>
                                                        <td><?php echo $reseller_info->reseller_l_count;  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Right Count</td>
                                                        <td><?php echo $reseller_info->reseller_r_count;  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Voucher Claimed?</td>
                                                        <td><?php echo ($reseller_info->gc_available == 1 ? 'NO':'YES');  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Reseller Upgraded?</td>
                                                        <td><?php echo ($reseller_info->gold_updated == 1 ? 'YES':'NO');  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Reseller Date Upgraded?</td>
                                                        <td><?php echo $reseller_info->gold_date;  ?></td>
                                                    </tr>
                                                    <tr role="row" class="heading">
                                                        <td width="10%">Reseller AR</td>
                                                        <td><?php echo ($reseller_info->reseller_ar == 0 ? 'N/A':$reseller_info->reseller_ar);  ?></td>
                                                    </tr>                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="form-actions" align="right">
                                <div class="row">
                                    <?php
                                        $user = $this->ion_auth_admin->user()->row();
                                    ?>                                    
                                    <div class="col-md-12">
                                        <?php if($user->group_id == 1): ?>
                                            <button type="submit" class="btn green">Submit</button>
                                        <?php endif; ?>
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