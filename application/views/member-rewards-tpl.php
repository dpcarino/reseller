<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<?php
    $member_star_wallet_info->stars;
?>

<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h1 class="page-title"> Gold Elite Rewards
        </h1>
                
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Rewards</span>
                </li>
                <li>
                </li>                
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class=" icon-social-twitter font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Rewards</span>
                        </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-sm btn-circle green-sharp easy-pie-chart-reload">
                            <i class="fa fa-star-o"></i> - <?php echo $member_star_wallet_info->stars; ?></a>
                        </div>                        
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_actions_pending">
                                <?php foreach($rewards as $reward): ?>
                                <!-- BEGIN: Actions -->
                                <div class="mt-actions">
                                    <div class="mt-action">
                                        <div class="mt-action-body">
                                            <div class="mt-action-row">
                                                <div class="mt-action-info ">
                                                    <div class="mt-action-icon ">
                                                        <i class="icon-present"></i>
                                                    </div>
                                                    <div class="mt-action-details ">
                                                        <span class="mt-action-author"><?php echo $reward->reward; ?></span>
                                                        <p class="mt-action-desc">Star Rewards Required : <?php echo $reward->stars_required; ?> star(s)</p>
                                                    </div>
                                                </div>
                                                <div class="mt-action-buttons ">
                                                        <a href="<?php echo site_url('reward/details')."/".$reward->reward_id; ?>" class="btn btn-sm btn-circle btn-default blue"><i class="fa fa-sticky-note-o"></i>
                                                            View Reward
                                                        </a>
                                                        <?php if($member_star_wallet_info->stars >= $reward->stars_required): ?>
                                                        <a href="<?php echo site_url('request/rewards'); ?>" class="btn btn-sm btn-circle btn-default yellow"><i class="fa fa-trophy"></i>
                                                            Claim Reward
                                                        </a>
                                                        <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Actions -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include("includes/footer.php"); ?>