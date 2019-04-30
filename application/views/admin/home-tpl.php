<?php include('includes/header.php'); ?>

<div class="page-container custom-dashboard-add">
<?php include("includes/sidebar.php"); ?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content admin" style="background: #FFF;">
    <!-- BEGIN PAGE HEADER-->

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <div class="row">
            <div class="portlet red-thunderbird box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa"></i> System 
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="portlet-title" id="paylite-type"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">Encashment</td>
                                                <td>
                                                    <?php echo ($encashment_settings['active'] == 1 ? 'ON' : 'OFF'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Maintenance </td>
                                                <td>
                                                    <?php echo ($maintenance_settings['active'] == 1 ? 'ON' : 'OFF'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> System Logs </td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $system_logs; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="portlet yellow box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa"></i> Gold Elite 
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="portlet-title" id="paylite-type"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">Members</td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $members_count; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Heads </td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $heads_count; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Gold Elite Heads </td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $gold_heads; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> CD Heads </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $cd_heads; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="portlet green box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa"></i> Codes 
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="portlet-title" id="paylite-type"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">Total Codes Generated</td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $total_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-title" id="paylite-type"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Paid Codes Generated 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $codes_count; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Unused Paid Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $unused_paid_count; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Used Paid Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $used_paid_count; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> PayLite Codes Generated 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $paylite_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Unused PayLite Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $unused_paylite_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Used PayLite Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $used_paylite_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Reseller Codes Generated 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $reseller_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Unused Reseller Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $unused_reseller_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> 
                                                    <i class="fa fa-ticket"></i> Used Reseller Codes 
                                                </td>
                                                <td> 
                                                    <span data-counter="counterup" data-value="<?php echo $used_reseller_codes; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>

            </div>            
        </div>

        <div class="row">
            <div class="portlet purple box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa"></i> Claims 
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="portlet-title" id="paylite-type"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-striped table-bordered table-advance">
                                        <tbody>
                                            <tr>
                                                <td style="width: 50%">Encashment Requests</td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $encashment_request; ?>">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Reseller Requests </td>
                                                <td>
                                                    <span data-counter="counterup" data-value="<?php echo $voucher_requests; ?>">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

    </div>
</div>
<?php include('includes/footer.php'); ?>