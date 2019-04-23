<?php include('includes/header.php'); ?>
<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Paylite Details - <?php echo $head_info->headname; ?></h3>

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
                            <?php echo form_open_multipart('admin/heads/update-paylite/'.$head_info->head_id, array('class'=>'form-horizontal', 'id'=>'setting_form')); ?>
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
                                                <label class="control-label col-md-2">Amount <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="amount" id="amount" class="form-control" data-required="1" value="">
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Paid AR <span class="required">
                                                    * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="paid_ar" id="paid_ar" class="form-control" data-required="1" value="">
                                                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-info-circle"></i>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Payment History</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                                <thead>
                                <tr role="row" class="heading">
                                    <th width="5%">Paid AR</th>
                                    <th width="5%">Amount</th>
                                    <th width="5%">Date of Payment</th>                                           
                                </tr>
                                <?php foreach($payments as $payment): ?>
                                <tr role="row" class="filter">
                                    <?php if($payment->paid_ar == 0): ?>
                                        <td>Initial</td>
                                    <?php else: ?>
                                        <td><?php echo $payment->paid_ar; ?></td>
                                    <?php endif; ?>
                                    <td><?php echo $payment->amount; ?></td>
                                    <td><?php echo $payment->datecreated; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                            </div> 
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
        <p class="text-left" id="confirm-msg">Are you sure you want to continue update this head PayLite details</p>
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