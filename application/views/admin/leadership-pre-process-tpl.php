<?php include('includes/header.php'); ?>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Leadership Pre-Process</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('/admin'); ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Leadership</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

            <!-- BEGIN PAGE CONTENT-->
            <?php
                $user = $this->ion_auth_admin->user()->row();
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-grid"></i>Encashment Requests
                            </div>
                            <?php if($maintenance_settings['active'] == 1): ?>
                            <div class="actions">
                                <a href="javascript:;" class="btn default yellow-stripe" id="process-leadership">
                                <i class="fa fa-plus"></i>
                                <span class="hidden-480">
                                    Process Leadership
                                </span>
                                </a>                               
                            </div>
                            <?php endif; ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php include('includes/notes.php'); ?>
                </div>                
            </div>            
            <div class="row">
                <div class="col-md-12">
                    <table id="user" class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td style="width:15%"> Current User </td>
                                <td style="width:85%">
                                    <?php echo $user->username; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%"> Total Members </td>
                                <td style="width:85%">
                                    <?php echo $member_count; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%"> Total Heads </td>
                                <td style="width:85%">
                                    <?php echo $head_count; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2"> Current Figures </td>
                            </tr>
                            <tr>
                                <td style="width:15%"> Total Head Income </td>
                                <td style="width:85%">
                                    ₱ <?php echo $total_income; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%"> Total CD Balance </td>
                                <td style="width:85%">
                                    ₱ <?php echo $cd_balance; ?>
                                </td>
                            </tr>                             
                        </tbody>
                    </table>
                </div>
            </div>          
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>

<div class="modal fade" id="process" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='process-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="process-msg">Are you sure you want to process leadership income?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="process-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="process-no">No</button>
      </div>      
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
var base_url = '<?php echo site_url(); ?>';

$("#process-leadership").on('click', function (){
    $('#process').modal('show');
});

$("#process-yes").on('click', function (){
    
    window.location.href = base_url+'admin/leadership/process';

});

</script>