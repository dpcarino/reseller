<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title"> Wallet</h1>
	    <div class="page-bar">
	        <ul class="page-breadcrumb">
	            <li>
	                <i class="icon-home"></i>
	                <a href="<?php echo site_url('dashboard'); ?>">Home</a>
	                <i class="fa fa-angle-right"></i>
	            </li>
	            <li>
	                <span>Wallet</span>
	            </li>
	        </ul>
	    </div>
	    <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo number_format($member_wallet_info->amount); ?>">0</span>
                            ₱
                        </div>
                        <div class="desc"> Current Wallet </div>
                    </div>
                </a>
            </div>
        </div>        
        <div class="row">
            <div class="col-md-12">
                <!--div class="portlet-title">
                    <div class="actions" style="text-align: right;">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <a href="javascript:;" class="btn btn-md btn-circle yellow easy-pie-chart-reload">
                            <i class="fa fa-money"></i> Move All to Wallet</a>
                        </div>
                    </div>
                </div-->                
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="20%">Head</th>
                            <th width="8%">Total Income</th>
                            <th width="15%">
                                 Actions
                            </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="filter[both][headname]">
                            </td>
                            <td></td>     
                            <td>
                                <div class="margin-bottom-5">
                                    <button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
                                    <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
                                </div>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>    
	</div>
	<!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>
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
        <p class="text-left" id="cancel-msg">Are you sure you want to move this to your wallet?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default blue" data-dismiss="modal" id="cancel-yes">Yes</button>
        <button type="button" class="btn btn-default red" data-dismiss="modal" id="cancel-no">No</button>
        <input type="hidden" id="input-head-id" value="">
      </div>      
    </div>
  </div>
</div>
<script>
function moveToWallet(head_id){
    $('#cancel').modal('show');
    $('#input-head-id').val(head_id);
}

$("#cancel-yes").on('click', function (){

    // var head_id = $('#wallet-move-button').data('head_id');
    var input_head_id = $('#input-head-id').val();
    var head_id = $('#wallet-move-button-'+input_head_id).data('head_id');

    $.ajax({//transactions/move-to-wallet/
        url: base_url+"transactions/ajax/set-wallet-head",
        data:{'head_id' : head_id},
        success: function(data) {           
            if(data.status == 'success'){
                window.location.href = base_url+'transactions/move-to-wallet/';
            }                
        },
        type: 'POST',
    });

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
                    [15, 30, 50, 100, 150],
                    [15, 30, 50, 100, 150] // change per page values here
                ],
                "pageLength": 15, // default record count per page
                "ajax": {
                    "url": base_url + 'transactions/ajax/get_income_heads', // ajax source
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