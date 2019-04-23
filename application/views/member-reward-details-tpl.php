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
                    <span>Reward</span>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <?php echo $reward_info->reward; ?>
                </li>                
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="blog-page blog-content-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-single-content bordered blog-container">
                        <div class="blog-single-head">
                            <h1 class="blog-single-head-title"><?php echo $reward_info->reward; ?></h1>
                            <div class="blog-single-head-date">
                                <i class="icon-star font-blue"></i> - <?php echo $reward_info->stars_required; ?> Required
                            </div>
                        </div>
                        <div class="blog-single-desc">
                            <p><?php echo $reward_info->reward_description; ?></p>
                        </div>                         
                        <div class="blog-single-img">
                            <?php if($reward_info->reward_img != ''): ?>
                            <img src="<?php echo base_url('uploads/rewards')."/".$reward_info->reward_img; ?>"> 
                            <?php endif; ?>
                        </div>
                        <div class="blog-single-foot">
                            <ul class="blog-post-tags">
                                <li class="uppercase">
                                    <a href="<?php echo site_url('rewards'); ?>" class="btn btn-sm btn-circle btn-default yellow"><i class="fa fa-backward"></i>Back to Rewards</a>
                                </li>                                
                                <?php if($member_star_wallet_info->stars >= $reward_info->stars_required): ?>
                                <li class="uppercase">
                                    <a href="<?php echo site_url('request/rewards'); ?>" class="btn btn-sm btn-circle btn-default yellow"><i class="fa fa-trophy"></i>Claim Reward</a>
                                </li>
                                <?php endif; ?>
                            </ul>
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