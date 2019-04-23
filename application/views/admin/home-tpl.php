<?php include('includes/header.php'); ?>

<style type="text/css">
    @media (min-width: 1200px){
    .custom-dashboard-add .col-lg-4 {
        width: 28%!important;
    }    
}

@media (min-width: 992px){
    .custom-dashboard-add .col-md-5 {
        width: 33%;
    }
}
</style>

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

<!-- BEGIN PAGE TITLE-->

<h3 class="page-title"> Dashboard </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $members_count; ?>">0</span>
                </div>
                <div class="desc"> Members </div>
            </div>
        </a>
    </div>         
</div>
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
        <div class="visual">
            <i class="fa fa-users"></i>
        </div>
        <div class="details">
            <div class="number">
                <span data-counter="counterup" data-value="<?php echo $heads_count; ?>">0</span>
            </div>
            <div class="desc"> Heads </div>
        </div>
    </a>
    </div> 
</div> 
<div class="row">
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $gold_heads; ?>">0</span></div>
                <div class="desc"> Gold Elite Heads</div>
            </div>
        </a>
    </div>  
    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $cd_heads; ?>"></span> </div>
                <div class="desc"> CD Heads</div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 grey-cascade" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $total_codes; ?>"></span> </div>
                <div class="desc"> Total Codes Generated </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $codes_count; ?>"></span> </div>
                <div class="desc"> Paid Codes Generated </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $unused_paid_count; ?>">0</span></div>
                <div class="desc"> Unused Paid Codes</div>
            </div>
        </a>
    </div>  
    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $used_paid_count; ?>"></span> </div>
                <div class="desc"> Used Paid Codes</div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $paylite_codes; ?>"></span> </div>
                <div class="desc"> PayLite Codes Generated </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $unused_paylite_codes; ?>">0</span></div>
                <div class="desc"> Unused PayLite Codes</div>
            </div>
        </a>
    </div>  
    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-barcode"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $used_paylite_codes; ?>"></span> </div>
                <div class="desc"> Used PayLite Codes</div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
                <i class="fa fa-money"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $encashment_request; ?>"></span> </div>
                <div class="desc"> Encashment Requests </div>
            </div>
        </a>
    </div> 
</div>

</div>
<!-- END CONTENT BODY -->
</div>
</div>
<?php include('includes/footer.php'); ?>