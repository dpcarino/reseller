<?php include('includes/header.php'); ?>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">GSC History - <?php echo $transaction_id; ?></h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('/admin'); ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Reports</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">GSC History</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo $transaction_id; ?></a>
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
                    <?php include('includes/notes.php'); ?>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="actions">
                                <a href="<?php echo site_url('admin/leadership/history-detail'); ?>" class="btn default red-stripe">
                                <i class="fa fa-backward"></i>
                                <span class="hidden-480">
                                    Back to Details
                                </span>
                                </a>                               
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="5%">Head Name</th>
                                <th width="5%">Left GSC</th>
                                <th width="5%">Right GSC</th>
                                <th width="5%">CD Left Count</th>
                                <th width="5%">CD Right Count</th>
                                <th width="5%">Gold Left Count</th>
                                <th width="5%">Gold Right Count</th>
                                <th width="5%">Direct Referral Bonus</th>
                                <th width="5%">GSC Income</th>
                                <th width="5%">CD Deduction</th>
                                <th width="5%">CD Balance</th>
                                <th width="5%">Weekly Stars</th>
                                <th width="5%">Date Processed</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td></td>                                
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>

<script>
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
                "pageLength": 50, // default record count per page
                "ajax": {
                    "url": base_url + 'admin/leadership/ajax/get_leadership_history_gsc', // ajax source
                    "data": {
                        "leader_id": "<?php echo $leader_id; ?>",
                        "transaction_id": "<?php echo $transaction_id; ?>",
                    }
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