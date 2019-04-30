<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Reseller Voucher Request History</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Request</span>
                    <i class="fa fa-angle-right"></i>
	            </li>
                <li>
                    <span>Reseller Voucher History</span>
                </li>                
	        </ul>         
	    </div>
	    <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-title">
                </div>                
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="10%">Tracking Code</th>
                            <th width="10%">Date Requested</th>
                            <th width="10%">Date Processed</th>
                            <th width="5%">Head Name</th>
                            <th width="10%">Claim Status</th>
                            <th width="15%">
                                 Actions
                            </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td></td>
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
	<!-- END CONTENT BODY -->
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
        <p class="text-left" id="confirm-msg">Are you sure you want to continue your request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="confirm-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="confirm-no">No</button>
      </div>      
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
        <p class="text-left" id="cancel-msg">Are you sure you want to cancel your request?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="cancel-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="cancel-no">No</button>
      </div>      
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
function cancelRequest(){
    $('#cancel').modal('show');
}

$("#cancel-yes").on('click', function (){

    var reseller_claims_id = $('#cancel-request-button').data('ecash-id');

    $.ajax({
        url: base_url+"transactions/ajax/cancel-reseller-voucher-request",
        data:{'reseller_claims_id' : reseller_claims_id},
        success: function(data) {           
            if(data.status == 'success'){
                location.reload();
            }                
        },
        type: 'POST',
    });
});


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$('#request_form').submit(function(e) {
    e.preventDefault();
    $('#confirm').modal('show');
});

$("#confirm-yes").on('click', function (){
    $('#request_form').unbind('submit').submit();
});

var base_url = '<?php echo site_url(); ?>';

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
                    "url": base_url + 'transactions/ajax/get_reseller_voucher_requests', // ajax source
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