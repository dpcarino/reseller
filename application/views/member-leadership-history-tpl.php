<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title">Leadership History</h1>
	    <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Leadership</span>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $current_head; ?></span>
                </li>                 
            </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Change Head
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php foreach($heads as $head): ?>
                        <li <?php echo ($current_head == $head->headname ? 'style="background-color: #4BA547; height: 30px;
                            padding-left: 15px;
                            padding-top: 5px;' : ''); ?>>
                            <a href="javascript:;" 
                                <?php if($current_head != $head->headname): ?>
                                    onclick="changeMemberHead('<?php echo $head->headname; ?>');"
                                <?php endif; ?> 
                            ><i class="icon-user"></i> <?php echo $head->headname; ?></a>
                        </li>                        
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div> 
	    </div>
	    <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">           
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_admins">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">Transaction ID</th>
                            <th width="5%">Date Processed</th>
                            <th width="5%">Action</th>
                        </tr>
                        <tr role="row" class="filter">
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
</div>
	<!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>

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
                    [15, 30, 50, 100, 150],
                    [15, 30, 50, 100, 150] // change per page values here
                ],
                "pageLength": 15, // default record count per page
                "ajax": {
                    "url": base_url + 'transactions/ajax/get_leadership_histories', // ajax source
                    "data": {
                        "head_id": "<?php echo $head_id; ?>",                     
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