<?php include('includes/header.php'); ?>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Member Reseller</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('/admin'); ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Member Reseller</a>
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
                                <i class="icon-grid"></i>Reseller Voucher Requests
                            </div>
                            <?php if($encashment_settings['active'] == 1): ?>
                            <div class="actions">
                                <a href="javascript:;" class="btn default yellow-stripe" id="process-encashment">
                                <i class="fa fa-plus"></i>
                                <span class="hidden-480">
                                    Process Voucher Requests
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
                                <td style="width:15%"> Total Voucher Amount </td>
                                <td style="width:85%">
                                    <?php echo $voucher_requests_cnt*3000; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%"> Total Request </td>
                                <td style="width:85%">
                                    <?php echo $voucher_requests_cnt; ?>
                                </td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="5%">Member ID</th>
                                    <th width="10%">Member Name</th>
                                    <th width="10%">Head Name</th>
                                    <th width="10%">Date Requested</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                <tr role="row" class="filter">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>

<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id='cancel-type'>Warning!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="cancel-msg">Are you sure you want to cancel this request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="cancel-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="cancel-no">No</button>
      </div>      
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
        <p class="text-left" id="process-msg">Are you sure you want to process this requests?</p>
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

function cancelRequest(){
    $('#cancel').modal('show');
}

$("#cancel-yes").on('click', function (){

    var reseller_claims_id = $('#cancel-request-button').data('ecash-id');

    $.ajax({
        url: base_url+"admin/reseller/ajax/cancel-reseller-voucher-request",
        data:{'reseller_claims_id' : reseller_claims_id},
        success: function(data) {           
            if(data.status == 'success'){
                location.reload();
            }                
        },
        type: 'POST',
    });
});

$("#process-encashment").on('click', function (){
    $('#process').modal('show');
});

$("#process-yes").on('click', function (){
    
    window.location.href = base_url+'admin/reseller/process';

});

var Codes = function () {

    var handleCodes = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#datatable_admins"),
            onSuccess: function (grid) {
                // execute some code on network or other general error  
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": base_url + 'admin/reseller/ajax/get_reseller_voucher_request', // ajax source
                },
                "order": [
                    [0, "desc"]
                ] // set first column as a default sort by asc
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleCodes();
        }
    };
}();

jQuery(document).ready(function() {
    Codes.init()
});
</script>