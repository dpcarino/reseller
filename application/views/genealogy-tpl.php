<?php include('includes/header.php'); ?>

<?php include("includes/sidebar.php"); ?>

<?php
    $geanology_arr = explode(';', $genealogy_str);

    // echo '<pre>';
    // print_r($geanology_arr);
    // echo '</pre>';
?>

<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content" style="min-height: 1435px;">
	    <!-- BEGIN PAGE HEADER-->
	    <h1 class="page-title">Member Genealogy</h1>
	    <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Genealogy</span>
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
                        <li <?php echo ($current_head == $head->headname ? 'style="background-color: #4BA547; height: 30px; padding-left: 15px; padding-top: 5px;' : ''); ?>>
                            <a href="javascript:;" onclick="changeMemberHead('<?php echo $head->headname; ?>');"><i class="icon-user"></i> <?php echo $head->headname; ?></a>
                        </li>                        
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div> 
	    </div>
	    <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <section class="management-hierarchy">
                    <div class="hv-container">
                        <div class="hv-wrapper">

                            <!-- Key component -->
                            <div class="hv-item">
                                <?php 
                                    $parent = explode('|', $geanology_arr[0]);

                                    $head_info = $this->Heads_model->get_head($parent[1]);

                                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                    if($member_details_info->authorized_id_img_1 == ''){
                                        $img_src = base_url('assets/no-image.png');
                                    }else{
                                        $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                    }
                                ?>
                                <div class="hv-item-parent">
                                    <div class="person">
                                        <img src="<?php echo $img_src; ?>" alt="">
                                        <p class="name">
                                            <?php echo $parent[2]; ?>
                                            <br>
                                            <?php echo $parent[3]; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="hv-item-children">

                                    <div class="hv-item-child">
                                        <!-- Key component -->
                                        <div class="hv-item">
                                            <?php 
                                                $child_1 = explode('|', $geanology_arr[1]);

                                                if($child_1[1] == 0){
                                                    $img_src = base_url('assets/no-image.png');
                                                }else{
                                                    $head_info = $this->Heads_model->get_head($child_1[1]);

                                                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                    if($member_details_info->authorized_id_img_1 == ''){
                                                        $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                    }else{
                                                        $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                    } 
                                                }                                                
                                            ?>                                
                                            <a href="javascript:;" onclick="<?php echo ($child_1[1] == 0 ? "" : "changeGeneology('".$child_1[1]."')" ); ?>" style="text-decoration: none;">
                                            <div class="hv-item-parent">
                                                <div class="person">
                                                    <img src="<?php echo $img_src; ?>" alt="">
                                                    <p class="name">
                                                        <?php if($child_1[1] != 0): ?>
                                                        <?php echo $child_1[2]; ?>
                                                        <br>
                                                        <?php echo $child_1[3]; ?>
                                                        <?php else: ?>
                                                            SLOT FREE
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            </a>
                                            <div class="hv-item-children">

                                                <div class="hv-item-child">
                                                    <!-- Key component -->
                                                    <div class="hv-item">
                                                        <?php 
                                                            $child_3 = explode('|', $geanology_arr[3]);   

                                                            if($child_3[1] == 0){
                                                                $img_src = base_url('assets/no-image.png');
                                                            }else{
                                                                $head_info = $this->Heads_model->get_head($child_3[1]);

                                                                $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                if($member_details_info->authorized_id_img_1 == ''){
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                }else{
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                } 
                                                            }  
                                                        ?>
                                                        <a href="javascript:;" onclick="<?php echo ($child_3[1] == 0 ? "" : "changeGeneology('".$child_3[1]."')" ); ?>" style="text-decoration: none;">
                                                        <div class="hv-item-parent">
                                                            <div class="person">
                                                                <img src="<?php echo $img_src; ?>" alt="">
                                                                <p class="name">
                                                                    <?php if($child_3[1] != 0): ?>
                                                                    <?php echo $child_3[2]; ?>
                                                                    <br>
                                                                    <?php echo $child_3[3]; ?>
                                                                    <?php else: ?>
                                                                        SLOT FREE
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        </a>
                                                        <div class="hv-item-children">

                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_7 = explode('|', $geanology_arr[7]);

                                                                        if($child_7[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_7[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        } 
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_7[1] == 0 ? "" : "changeGeneology('".$child_7[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_7[1] != 0): ?>
                                                                                <?php echo $child_7[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_7[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_8 = explode('|', $geanology_arr[8]);

                                                                        if($child_8[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_8[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        }                                                                        
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_8[1] == 0 ? "" : "changeGeneology('".$child_8[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_8[1] != 0): ?>
                                                                                <?php echo $child_8[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_8[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="hv-item-child">
                                                    <!-- Key component -->
                                                    <div class="hv-item">
                                                        <?php 
                                                            $child_4 = explode('|', $geanology_arr[4]);

                                                            if($child_4[1] == 0){
                                                                $img_src = base_url('assets/no-image.png');
                                                            }else{
                                                                $head_info = $this->Heads_model->get_head($child_4[1]);

                                                                $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                if($member_details_info->authorized_id_img_1 == ''){
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                }else{
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                } 
                                                            } 
                                                        ?>
                                                        <a href="javascript:;" onclick="<?php echo ($child_4[1] == 0 ? "" : "changeGeneology('".$child_4[1]."')" ); ?>" style="text-decoration: none;">
                                                        <div class="hv-item-parent">
                                                            <div class="person">
                                                                <img src="<?php echo $img_src; ?>" alt="">
                                                                <p class="name">
                                                                    <?php if($child_4[1] != 0): ?>
                                                                    <?php echo $child_4[2]; ?>
                                                                    <br>
                                                                    <?php echo $child_4[3]; ?>
                                                                    <?php else: ?>
                                                                        SLOT FREE
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        </a>
                                                        <div class="hv-item-children">

                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_9 = explode('|', $geanology_arr[9]);

                                                                        if($child_9[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_9[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        } 
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_9[1] == 0 ? "" : "changeGeneology('".$child_9[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_9[1] != 0): ?>
                                                                                <?php echo $child_9[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_9[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_10 = explode('|', $geanology_arr[10]);

                                                                        if($child_10[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_10[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        } 
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_10[1] == 0 ? "" : "changeGeneology('".$child_10[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_10[1] != 0): ?>
                                                                                <?php echo $child_10[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_10[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="hv-item-child">
                                        <!-- Key component -->
                                        <div class="hv-item">
                                            <?php 
                                                $child_2 = explode('|', $geanology_arr[2]);

                                                if($child_2[1] == 0){
                                                    $img_src = base_url('assets/no-image.png');
                                                }else{
                                                    $head_info = $this->Heads_model->get_head($child_2[1]);

                                                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                    if($member_details_info->authorized_id_img_1 == ''){
                                                        $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                    }else{
                                                        $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                    } 
                                                } 
                                            ?> 
                                            <a href="javascript:;" onclick="<?php echo ($child_2[1] == 0 ? "" : "changeGeneology('".$child_2[1]."')" ); ?>" style="text-decoration: none;">
                                            <div class="hv-item-parent">
                                                <div class="person">
                                                    <img src="<?php echo $img_src; ?>" alt="">
                                                    <p class="name">
                                                        <?php if($child_2[1] != 0): ?>
                                                        <?php echo $child_2[2]; ?>
                                                        <br>
                                                        <?php echo $child_2[3]; ?>
                                                        <?php else: ?>
                                                            SLOT FREE
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            </a>
                                            <div class="hv-item-children">

                                                <div class="hv-item-child">
                                                    <!-- Key component -->
                                                    <div class="hv-item">
                                                        <?php 
                                                            $child_5 = explode('|', $geanology_arr[5]);

                                                            if($child_5[1] == 0){
                                                                $img_src = base_url('assets/no-image.png');
                                                            }else{
                                                                $head_info = $this->Heads_model->get_head($child_5[1]);

                                                                $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                if($member_details_info->authorized_id_img_1 == ''){
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                }else{
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                } 
                                                            }
                                                        ?>
                                                        <a href="javascript:;" onclick="<?php echo ($child_5[1] == 0 ? "" : "changeGeneology('".$child_5[1]."')" ); ?>" style="text-decoration: none;">
                                                        <div class="hv-item-parent">
                                                            <div class="person">
                                                                <img src="<?php echo $img_src; ?>" alt="">
                                                                <p class="name">
                                                                    <?php if($child_5[1] != 0): ?>
                                                                    <?php echo $child_5[2]; ?>
                                                                    <br>
                                                                    <?php echo $child_5[3]; ?>
                                                                    <?php else: ?>
                                                                        SLOT FREE
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        </a>
                                                        <div class="hv-item-children">

                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_11 = explode('|', $geanology_arr[11]);

                                                                        if($child_11[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_11[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        }
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_11[1] == 0 ? "" : "changeGeneology('".$child_11[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_11[1] != 0): ?>
                                                                                <?php echo $child_11[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_11[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_12 = explode('|', $geanology_arr[12]);

                                                                        if($child_12[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_12[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        }
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_12[1] == 0 ? "" : "changeGeneology('".$child_12[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_12[1] != 0): ?>
                                                                                <?php echo $child_12[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_12[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="hv-item-child">
                                                    <!-- Key component -->
                                                    <div class="hv-item">
                                                        <?php 
                                                            $child_6 = explode('|', $geanology_arr[6]);

                                                            if($child_6[1] == 0){
                                                                $img_src = base_url('assets/no-image.png');
                                                            }else{
                                                                $head_info = $this->Heads_model->get_head($child_6[1]);

                                                                $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                if($member_details_info->authorized_id_img_1 == ''){
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                }else{
                                                                    $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                } 
                                                            }
                                                        ?>
                                                        <a href="javascript:;" onclick="<?php echo ($child_6[1] == 0 ? "" : "changeGeneology('".$child_6[1]."')" ); ?>" style="text-decoration: none;">
                                                        <div class="hv-item-parent">
                                                            <div class="person">
                                                                <img src="<?php echo $img_src; ?>" alt="">
                                                                <p class="name">
                                                                    <?php if($child_6[1] != 0): ?>
                                                                    <?php echo $child_6[2]; ?>
                                                                    <br>
                                                                    <?php echo $child_6[3]; ?>
                                                                    <?php else: ?>
                                                                        SLOT FREE
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        </a>
                                                        <div class="hv-item-children">

                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_13 = explode('|', $geanology_arr[13]);
                                                                        if($child_13[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_13[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        }
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_13[1] == 0 ? "" : "changeGeneology('".$child_13[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_13[1] != 0): ?>
                                                                                <?php echo $child_13[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_13[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class="hv-item-child">
                                                                <!-- Key component -->
                                                                <div class="hv-item">
                                                                    <?php 
                                                                        $child_14 = explode('|', $geanology_arr[14]);

                                                                        if($child_14[1] == 0){
                                                                            $img_src = base_url('assets/no-image.png');
                                                                        }else{
                                                                            $head_info = $this->Heads_model->get_head($child_14[1]);

                                                                            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                                                                            if($member_details_info->authorized_id_img_1 == ''){
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            }else{
                                                                                $img_src = base_url('assets/layouts/layout2/img/default-profile.png');
                                                                            } 
                                                                        }
                                                                    ?>
                                                                    <a href="javascript:;" onclick="<?php echo ($child_14[1] == 0 ? "" : "changeGeneology('".$child_14[1]."')" ); ?>" style="text-decoration: none;">
                                                                    <div class="hv-item-child">
                                                                        <div class="person">
                                                                            <img src="<?php echo $img_src; ?>" alt="">
                                                                            <p class="name">
                                                                                <?php if($child_14[1] != 0): ?>
                                                                                <?php echo $child_14[2]; ?>
                                                                                <br>
                                                                                <?php echo $child_14[3]; ?>
                                                                                <?php else: ?>
                                                                                    SLOT FREE
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>        

    </div>    
</div>
	<!-- END CONTENT BODY -->
</div>

<?php include("includes/footer.php"); ?>