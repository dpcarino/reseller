<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>
<?php
    $reward_pts = 1;
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h1 class="page-title"> Gold Elite Dashboard
        </h1> 
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <span>Knight Status</span>
                    <i class="fa fa-angle-right"></i>
                </li>                
                <li>
                    <?php if($memberhead_info->knight_status != 1): ?>
                    <i class="icon-clock" style="color: red;"></i>
                    <span id="knight-timer" style="color: red;"></span>&nbsp;<span style="color: red;">remaining</span>
                    <?php else: ?>
                    Knight Activated
                    <?php endif; ?> 
                </li>               
            </ul>
        </div>             
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Dashboard</span>
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
            <?php include('includes/notes.php'); ?>
            <div class="col-lg-6 col-xs-12 col-sm-12">                
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Announcements</span>
                        </div>
                        <div class="actions">
                            <a href="<?php echo site_url('view/annoucements'); ?>" class="btn btn-sm btn-circle green-sharp easy-pie-chart-reload">
                            <i class="fa fa-comment-o"></i> View All Announcements</a>
                        </div>                         
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_comments_1">
                                <?php foreach($announcements as $annoucement): ?>
                                <!-- BEGIN: Comments -->
                                <div class="mt-comments">
                                    <div class="mt-comment">
                                        <div class="mt-comment-body">
                                            <?php
                                                $admin_info = $this->User_model->get_admin_by_id($annoucement->admin_id);
                                            ?>
                                            <div class="mt-comment-info">
                                                <span class="mt-comment-author"><?php echo $admin_info->first_name; ?> <?php echo $admin_info->last_name; ?></span>
                                                <span class="mt-comment-date"><?php echo date('d M, g:iA', strtotime($annoucement->datecreated)); ?></span>
                                                <br>
                                            </div>                                         
                                            <div class="mt-comment-text"><?php echo $annoucement->teaser; ?></div>
                                            <div class="mt-comment-info">
                                            <span class="mt-comment-date">
                                                <a href="<?php echo site_url('annoucement/details')."/".$annoucement->announcement_id; ?>" class="btn btn-sm btn-circle btn-default blue"><i class="fa fa-sticky-note-o"></i>
                                                    View Announcement
                                                </a>
                                            </span> 
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Comments -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xs-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class=" icon-social-twitter font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Rewards</span>
                        </div>
                        <div class="actions">
                            <a href="<?php echo site_url('rewards'); ?>" class="btn btn-sm btn-circle green-sharp easy-pie-chart-reload">
                            <i class="fa fa-gift"></i> View All Rewards</a>
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
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->total_income); ?>">0</span>
                            ₱
                        </div>
                        <div class="desc"> Total Head Income </div>
                    </div>
                    <div class="visual">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
        </div> 
        <!--div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->total_income); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Total Head Income</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                            </span>
                        </div>         
                        <?php if($memberhead_info->total_income != '0.00'): ?>               
                        <div class="status" style="text-align: right;">
                            <a href="<?php echo site_url('transactions/move-to-wallet').'/'.$memberhead_info->head_id; ?>" class="btn btn-sm btn-circle yellow easy-pie-chart-reload">
                            <i class="fa fa-money"></i> Move to Wallet</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>        
        </div-->
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->cd_balance); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Total CD Balance</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                            </span>
                        </div>
                    </div>
                </div>
            </div>        
        </div>        
        <div class="row">
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->direct_referrall_bonus); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Weekly Direct Refferal Bonus</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-pink">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->total_direct_bonus); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Total Direct Refferal Bonus</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-pink">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>        
        <div class="row">
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->paid_direct_count; ?>">0</span>
                            </h3>
                            <small>Gold Direct Referral Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-pink">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->cd_direct_count; ?>">0</span>
                            </h3>
                            <small>CD Direct Referral Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-pink">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>  
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->weekly_income); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Weekly Group Sales Commission</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->total_gsc_bonus); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Total Group Sales Commission</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <?php echo $memberhead_info->position; ?>
                            </h3>
                            <small>Weekly Ranking</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
        <div class="row">
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->lgsp; ?>">0</span>
                                <small class="font-green-sharp">Pts.</small>
                            </h3>
                            <small>Left Group Sale Commision</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->rgsp; ?>">0</span>
                                <small class="font-green-sharp">Pts.</small>
                            </h3>
                            <small>Right Group Sale Commision</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->paid_l_count; ?>">0</span>
                            </h3>
                            <small>Gold Left Group Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->cd_l_count; ?>">0</span>
                            </h3>
                            <small>CD Left Group Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->paid_r_count; ?>">0</span>
                            </h3>
                            <small>Gold Right Group Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->cd_r_count; ?>">0</span>
                            </h3>
                            <small>CD Right Group Count</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success yellow">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div> 
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo number_format($memberhead_info->total_leadership_bonus); ?>">0</span>
                                <small class="font-green-sharp">₱</small>
                            </h3>
                            <small>Total Leadership Bonus</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-pink">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>          
        <div class="row">
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $paid_codes_count; ?>">0</span>
                            </h3>
                            <small>Paid Codes Available</small>
                        </div>
                        <div class="icon">
                            <i class="icon-tag"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!--div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $cd_codes_count; ?>">0</span>
                            </h3>
                            <small>CD Codes Available</small>
                        </div>
                        <div class="icon">
                            <i class="icon-tag"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
                        </div>
                    </div>
                </div>
            </div-->             
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="<?php echo $memberhead_info->stars; ?>">0</span>
                            </h3>
                            <small>Stars Available</small>
                        </div>
                        <div class="icon">
                            <i class="icon-star"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp">
                            </span>
                        </div>                        
                        <div class="status">
                            <div class="status-title"> </div>
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