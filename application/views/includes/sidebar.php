<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- END SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="nav-item <?php echo ($this->uri->uri_string() == '/' ? 'start active open' : ''); ?>">
                    <a href="<?php echo site_url('dashboard'); ?>" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('downloads/GOLD-ELITE-USER-GUIDE.pdf'); ?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-info"></i>
                        <span class="title">How To?</span>
                    </a>
                </li>
                <li class="nav-item <?php echo ($this->uri->uri_string() == 'member/codes' ? 'start active open' : ''); ?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-tag"></i>
                        <span class="title">Codes</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('codes/listing'); ?>" class="nav-link ">
                                <i class="icon-bulb"></i>
                                <span class="title">Listings</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('codes/transfer-history'); ?>" class="nav-link ">
                                <i class="icon-graph"></i>
                                <span class="title">Transfer History</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('codes/used-history'); ?>" class="nav-link ">
                                <i class="icon-graph"></i>
                                <span class="title">Used History</span>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item <?php echo ($this->uri->uri_string() == 'member/add' ? 'start active open' : ''); ?>">
                    <a href="<?php echo site_url('member/add'); ?>" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">Add Member</span>
                    </a>
                </li>
                <li class="nav-item <?php echo ($this->uri->uri_string() == 'member/add/heads' ? 'start active open' : ''); ?>">
                    <a href="<?php echo site_url('member/add/heads'); ?>" class="nav-link nav-toggle">
                        <i class="icon-users"></i>
                        <span class="title">Add Heads</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('member/genealogy'); ?>" class="nav-link nav-toggle">
                        <i class="icon-users"></i>
                        <span class="title">Genealogy</span>
                    </a>
                </li>
                <li class="nav-item <?php echo ($this->uri->uri_string() == 'transactions' ? 'start active open' : ''); ?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-book-open"></i>
                        <span class="title">Transactions</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/wallet'); ?>" class="nav-link ">
                                <i class="icon-credit-card"></i>
                                <span class="title">Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/wallet-history'); ?>" class="nav-link ">
                                <i class="icon-credit-card"></i>
                                <span class="title">Wallet History</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/star-wallet'); ?>" class="nav-link ">
                                <i class="icon-star"></i>
                                <span class="title">Star Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/star-wallet-history'); ?>" class="nav-link ">
                                <i class="icon-star"></i>
                                <span class="title">Star Wallet History</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/gsc-history'); ?>" class="nav-link ">
                                <i class="icon-notebook"></i>
                                <span class="title">GSC History</span>
                            </a>
                        </li> 
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('transactions/leadership-history'); ?>" class="nav-link ">
                                <i class="icon-notebook"></i>
                                <span class="title">Leadership History</span>
                            </a>
                        </li> 
                    </ul>                    
                </li>                
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-refresh"></i>
                        <span class="title">Request</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start active open">
                            <a href="<?php echo site_url('request/encashment'); ?>" class="nav-link ">
                                <i class="icon-credit-card"></i>
                                <span class="title">Encashment</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('request/encashment-history'); ?>" class="nav-link ">
                                <i class="icon-credit-card"></i>
                                <span class="title">Encashment History</span>
                            </a>
                        </li>                        
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('request/rewards'); ?>" class="nav-link ">
                                <i class="icon-present"></i>
                                <span class="title">Rewards</span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('request/reward-history'); ?>" class="nav-link ">
                                <i class="icon-present"></i>
                                <span class="title">Reward History</span>
                            </a>
                        </li>
                    </ul>                    
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('profile'); ?>" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-arrow-down"></i>
                        <span class="title">Downloads</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo base_url('downloads/GOLD-ELITE-Presentation.ppt'); ?>" target="_blank" class="nav-link nav-toggle">
                                <i class="icon-envelope-letter"></i>
                                <span class="title">Gold Elite Presentation</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('downloads/GOLD-ELITE-MEMBERSHIP-APPLICATION-FORM.pdf'); ?>" target="_blank" class="nav-link nav-toggle">
                                <i class="icon-envelope-letter"></i>
                                <span class="title">Gold Elite Application Form</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('downloads/GOLD-ELITE-MEMBERSHIP-PAYLITE-APPLICATION-FORM.pdf'); ?>" target="_blank" class="nav-link nav-toggle">
                                <i class="icon-envelope-letter"></i>
                                <span class="title">Gold Elite PayLite Application Form</span>
                            </a>
                        </li>
                        <!--li class="nav-item">
                            <a href="<?php echo base_url('downloads/GOLD-ELITE-CD-PAYMENT-FORM.pdf'); ?>" target="_blank" class="nav-link nav-toggle">
                                <i class="icon-envelope-letter"></i>
                                <span class="title">CD Payment Form</span>
                            </a>
                        </li-->
                    </ul>                    
                </li>
                <?php if($memberdetails_info->member_status == 3 OR $memberdetails_info->member_status == 4): ?>
                <li class="nav-item">
                    <a href="<?php echo site_url('member/search'); ?>" class="nav-link nav-toggle">
                        <i class="icon-magnifier"></i>
                        <span class="title">Search</span>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?php echo site_url('member/logout'); ?>" class="nav-link nav-toggle">
                        <i class="icon-logout"></i>
                        <span class="title">Logout</span>
                    </a>
                </li>                               
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->