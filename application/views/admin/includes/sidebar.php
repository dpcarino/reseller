<div class="page-sidebar-wrapper">
<!-- BEGIN SIDEBAR -->
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
    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler">
                <span></span>
            </div>
        </li>
        <?php
            $user = $this->ion_auth_admin->user()->row();
        ?>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
        <li class="nav-item <?php echo ($this->uri->uri_string() == 'admin' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin'); ?>" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
        </li>
        <li class="heading">
            <h3 class="uppercase">Admin Panel</h3>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/codes/listings' || $this->uri->uri_string() == 'admin/codes/generate' ? 'start active open' : ''); ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-book-open"></i>
                <span class="title">Codes</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/codes/generate'); ?>" class="nav-link ">
                        <i class="icon-basket"></i>
                        <span class="title">Generate Codes</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo site_url('admin/codes/listings'); ?>" class="nav-link ">
                        <i class="icon-list"></i>
                        <span class="title">Code Listings</span>
                    </a>
                </li>                
            </ul>
        </li>
        <li class="heading">
            <h3 class="uppercase">Products Panel</h3>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/packages' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/packages'); ?>" class="nav-link nav-toggle">
                <i class="icon-basket-loaded"></i>
                <span class="title">Entry Packages</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>           
        </li>
        <li class="heading">
            <h3 class="uppercase">User Panel</h3>
        </li>
        <?php if($user->group_id == 1): ?>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/search' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/search'); ?>" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title">Admins</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>           
        </li>       
        <?php endif; ?>

        <li class="nav-item <?php echo ($this->uri->uri_string() == 'admin/heads/search' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/heads/search'); ?>" class="nav-link nav-toggle">
                <i class="icon-users"></i>
                <span class="title">Heads</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>           
        </li>        
        <li class="nav-item <?php echo ($this->uri->uri_string() == 'admin/members/search' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/members/search'); ?>" class="nav-link nav-toggle">
                <i class="icon-users"></i>
                <span class="title">Members</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>          
        </li>
        <?php if($user->group_id == 1): ?>
        <li class="heading">
            <h3 class="uppercase">Process</h3>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/encashments' || $this->uri->uri_string() == 'admin/rewards' ? 'start active open' : ''); ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-book-open"></i>
                <span class="title">Claims</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/encashments'); ?>" class="nav-link ">
                        <i class="icon-basket"></i>
                        <span class="title">Encashment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/rewards'); ?>" class="nav-link ">
                        <i class="icon-basket"></i>
                        <span class="title">Rewards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/reseller'); ?>" class="nav-link ">
                        <i class="icon-basket"></i>
                        <span class="title">Reseller Voucher</span>
                    </a>
                </li>                              
            </ul>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/encashment/payouts' || $this->uri->uri_string() == 'admin/rewards/claims' || $this->uri->uri_string() == 'admin/reseller/payouts' ? 'start active open' : ''); ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-book-open"></i>
                <span class="title">Claim History</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo site_url('admin/encashment/payouts'); ?>" class="nav-link ">
                        <i class="icon-list"></i>
                        <span class="title">Encashment</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo site_url('admin/rewards/claims'); ?>" class="nav-link ">
                        <i class="icon-list"></i>
                        <span class="title">Rewards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/reseller/payouts'); ?>" class="nav-link ">
                        <i class="icon-list"></i>
                        <span class="title">Reseller Voucher</span>
                    </a>
                </li>                                
            </ul>
        </li>        
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/leadership' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/leadership'); ?>" class="nav-link nav-toggle">
                <i class="icon-badge"></i>
                <span class="title">Leadership</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <?php endif; ?>
        
        <!--li class="heading">
            <h3 class="uppercase">Genealogy</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-pin"></i>
                <span class="title">Coming Soon</span>
                <span class="arrow"></span>
            </a>
        </li-->         
        <li class="heading">
            <h3 class="uppercase">Reports</h3>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/leadership/history' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/leadership/history'); ?>" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Leadership History</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/reports/auto-paid' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/reports/auto-paid'); ?>" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Auto Paid History</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>   
        <li class="heading">
            <h3 class="uppercase">Settings</h3>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/settings/announcements' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/settings/announcements'); ?>" class="nav-link nav-toggle">
                <i class="icon-pin"></i>
                <span class="title">Announcements</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/settings/rewards' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/settings/rewards'); ?>" class="nav-link nav-toggle">
                <i class="icon-present"></i>
                <span class="title">Rewards</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>        
        <?php if($user->group_id == 1): ?>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/settings/elite-settings' || $this->uri->uri_string() == 'admin/settings/encashment-settings' ? 'start active open' : ''); ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Settings</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/settings/elite-settings'); ?>" class="nav-link ">
                        <i class="icon-settings"></i>
                        <span class="title">Elite</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo site_url('admin/settings/encashment-settings'); ?>" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Encashment & Rewards</span>
                        <span class="arrow"></span>
                    </a>
                </li>
            </ul>            
        </li>
        <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/settings/maintenance-settings' ? 'start active open' : ''); ?>">
            <a href="<?php echo site_url('admin/settings/maintenance-settings'); ?>" class="nav-link nav-toggle">
                <i class="icon-power"></i>
                <span class="title">Maintenance</span>
                <span class="selected"></span>
                <span class="arrow"></span>
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item  ">
            <a href="<?php echo site_url('admin/logout'); ?>" class="nav-link nav-toggle">
                <i class="icon-logout"></i>
                <span class="title">Logout</span>
                <span class="arrow"></span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
</div>