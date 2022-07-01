
<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500"> 
    <ul class="menu-nav">
        <li class="menu-item <?php if ($menu_active == 'dashboard') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon flaticon-home"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>  
        <li class="menu-item <?php if ($menu_active == 'account') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/account" class="menu-link">
                <i class="menu-icon flaticon-user"></i>
                <span class="menu-text">Account</span>
            </a>
        </li>   
        <li class="menu-item <?php if ($menu_active == 'prod_info') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/products-info" class="menu-link">
                <i class="menu-icon flaticon-app"></i>
                <span class="menu-text">Product Information</span>
            </a>
        </li>   
        <li class="menu-item <?php if ($menu_active == 'trans_info') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/transactions-info" class="menu-link">
                <i class="menu-icon flaticon-list"></i>
                <span class="menu-text">Transaction Info</span>
            </a>
        </li>   
        <?php
            if(isset($data_cust[0]['TYPECUST'])){
                if($data_cust[0]['TYPECUST'] == 'Corporate'){
        ?>
                <li class="menu-item <?php if ($menu_active == 'monitoring') echo 'menu-item-active'; ?>" aria-haspopup="true"> 
                    <a href="https://prtg-netmon.indo.net.id/" target="_blank" class="menu-link">  
                        <i class="menu-icon flaticon-diagram"></i>
                        <span class="menu-text">Monitoring Bandwidth</span>
                    </a>
                </li>    
        <?php
                }
            }
        ?> 
        <?php
            if(isset($data_cust[0]['INSTALATIONNAME'])){
                if($data_cust[0]['INSTALATIONNAME'] == 'Alicloud'){
        ?>
                <li class="menu-item <?php if ($menu_active == 'usage_alicloud') echo 'menu-item-active'; ?>" aria-haspopup="true"> 
                    <a href="/usage-alibaba" class="menu-link">
                        <i class="menu-icon flaticon2-layers"></i>
                        <span class="menu-text">Usage Alibaba Cloud</span>
                    </a>
                </li>    
        <?php
                }
            }
        ?> 
        <li class="menu-item <?php if ($menu_active == 'billing') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/billing-statement" class="menu-link">
                <i class="menu-icon flaticon-interface-10"></i>
                <span class="menu-text">Billing Statement</span>
            </a>
        </li>     
        <li class="menu-item <?php if ($menu_active == 'report') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/report" class="menu-link">
                <i class="menu-icon flaticon-list-3"></i>
                <span class="menu-text">Report</span>
            </a>
        </li>    
        <li class="menu-item hide <?php if ($menu_active == 'pay_info') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/payment_info" class="menu-link">
                <i class="menu-icon flaticon-information"></i>
                <span class="menu-text">Payment Info</span>
            </a>
        </li>    
        <li class="menu-item" aria-haspopup="true">
            <a href="<?=base_url()?>auth/logout" class="menu-link">
                <i class="menu-icon flaticon-logout"></i>
                <span class="menu-text">Logout</span>
            </a>
        </li>    
    </ul> 
</div> 