<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action' => '']); ?>

<section class="content-wrapper content-filter">
    <span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
    <!--===========filter================-->
    <div class="filters">
        <div class="container">
            <form method="get" accept-charset="utf-8" id="userFilterFrm" autocomplete="off" novalidate="novalidate" action="/spayc/admin/spam-reports">          <div class="filter-wrapper">
                    <!--============search dropdown========-->
                    <div class="search">
                        <div class="form-group">
                            <div class="input text"><input type="text" name="keyword" class="form-control" placeholder="Search" id="keyword"></div>	                <span class="clear-search hide" id="clear-search"></span>
                        </div>
                    </div>
                </div>
            </form>  </div>
    </div>
    <!--============= table head ===================-->
    <div class="container">        
        <div class="table-wrapper">      
            <div class="table-head">
                <div class="head-text flex-basis30 text-left">
                    <span>Warps</span>
                </div> 
                <div class="head-text flex-basis30 text-left">                        
                    <span>Message</span>
                </div>                
                <div class="head-text flex-basis15"><span>No. of Users Reported Spam</span></div>
                <div class="head-text flex-basis10"><span>Action</span></div>
            </div>
            <input type="hidden" id="set_status">
            <div id="Banned_image" style="display: none"><img src="/spayc/images/user_banned.svg" alt=""></div>
            <div id="Unbanned_image" style="display: none"><img src="/spayc/images/user_unbanned.svg" alt=""></div>
            <?php foreach($items as $row): ?>
            <div class="table-row">
                <div class="table-data flex-basis30 text-left"></div>
            </div>
            <?php endforeach; ?>
            <div class="table-row">
                <div class="table-data flex-basis30 text-left"></div>
                <div class="table-data flex-basis30 text-left"><span>Lanespayc</span></div>
                <div class="table-data flex-basis15"><span>Bolt</span></div>
                <div class="table-data flex-basis15"><span>1</span></div>
                <div class="table-data flex-basis6">
                    <div class="dropdown table-view-dropdown">
                        <div class="table-dropdown" id="table-data-dropdown_2" data-toggle="dropdown" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="table-data-dropdown_2"> 
                            <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item status_2 block" page="/spayc/admin/spaycs/set-spayc-status/2"><i class="icon-block"></i><span class="status_2">Block</span></a> 
                      <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item delete" page="/spayc/admin/spaycs/delete-spayc/2"><i class="icon-Delete"></i>
                      <span>Delete</span></a> 
                  </div>
                </div>
                    
                </div>
            </div>            

        </div>      
    </div>
</section>

<?php echo $this->Html->script(['admin/admin-manage-user']); ?>