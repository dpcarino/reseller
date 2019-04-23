<?php include('includes/header.php'); ?>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Leadership Details - <?php echo $transaction_id; ?></h3>

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
                        <a href="#">Leadership Details</a>
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
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="5%">Member Name</th>
                                <th width="5%">Head</th>
                                <th width="5%">Knight Status</th>
                                <th width="5%">Sponsor Count</th>
                                <th width="5%">Leadership Income</th>
                                <th width="5%">CD Deduction</th>
                                <th width="5%">CD Balance</th>
                                <th width="5%">Date Processed</th>
                                <th width="10%">Actions</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="filter[both][membername]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="filter[both][headname]">
                                </td>                                
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>

<script>
function setDetailsId(details_id){
    $.ajax({
        url: base_url + 'admin/leadership/ajax/set-details-id',
        data:{'details_id' : details_id, 'transaction_id' : '<?php echo $transaction_id; ?>'},
        success: function(data) {           
            if(data.status == 'error'){
              console.log('error details id');
            }else{
              console.log(data.msg);
              window.location.href = base_url+'admin/leadership/history-detail-level';
            }                
        },
        type: 'POST',
    });
}

function setLeaderId(leader_id){
    $.ajax({
        url: base_url + 'admin/leadership/ajax/set-leader-id',
        data:{'leader_id' : leader_id, 'transaction_id' : '<?php echo $transaction_id; ?>'},
        success: function(data) {           
            if(data.status == 'error'){
              console.log('error leader id');
            }else{
              console.log(data.msg);
              window.location.href = base_url+'admin/leadership/history-gsc';
            }                
        },
        type: 'POST',
    });
}

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
                    "url": base_url + 'admin/leadership/ajax/get_leadership_history_details', // ajax source
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