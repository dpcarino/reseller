<?php include("includes/header.php"); ?>
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
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Announcements</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Announcements</span>
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
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include("includes/footer.php"); ?>