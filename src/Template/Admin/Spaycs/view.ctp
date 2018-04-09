<?php 
use Cake\Routing\Router;
$spaycUserStatusArr = unserialize(SPAYC_USER_STATUS_ARR);
$spaycTypeArr = unserialize(SPAYC_TYPE_ARR);
$groupTypeArr = unserialize(GROUP_TYPE_ARR);
//pr($spayc);die;
?>
<!--=============breadcrumbs==============-->            
  <div class="breadcrumbs">
    <div class="container">
      <h4>Manage Warps</h4>
      <p><span>Warps</span> <span>Warp Detail</span></p>
    </div>
  </div>

   <section class="content-wrapper content-filter">
        <!--======= event view wrapper==========-->
        <div class="container">
          <div class="event-view-wrapper">
            <!--======event info=====-->
            <div class="event-info clearfix">
              <div class="image-wrap">
              <?php
                $spaycImg = !empty($spayc->image)?$spayc->image:'no-image-big.png';
                echo $this->Html->image($spaycImg, ["alt" => "", 'class' =>'']); ?>
              </div>
              <div class="data-wrap">
                <h1><?= !empty($spayc->name)?$spayc->name:BLANK ?></h1>
                <h3><?php
                    $name = '';
                    if(!empty($user->display_name))
                        $name = ucwords($user->display_name);
                    if(!empty($spayc->is_admin))
                        $name .= '&nbsp;('.$spaycUserStatusArr[$spayc->is_admin].')';
                    echo $name;
                 ?>
                </h3>
                <p><?= !empty($spayc->description)?$spayc->description:'' ?></p>
                <div class="event-status">
                  <i class="icon-<?= strtolower($spayc->group_type) ?>-icon"></i>
                  <span><?= $spayc->group_type ?></span>
                </div>
                <?php if($spayc->type == $spaycTypeArr['event']) {?>
                <div class="date-wrapper">
                  <div class="start-date">
                    <span>Start</span>
                    <span class="bold-text">
                    <?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date,DATEFORMAT_DISPLAY).'&nbsp;at&nbsp;'.$this->dateFormat($spayc->start_date, TIMEFORMAT_SPAYC):BLANK ?>
                    </span>
                  </div>
                  <div class="end-date">
                    <span>End</span>
                    <span class="bold-text">
                    <?= !empty($this->dateFormat($spayc->end_date))?$this->dateFormat($spayc->end_date,DATEFORMAT_DISPLAY).'&nbsp;at&nbsp;'.$this->dateFormat($spayc->end_date, TIMEFORMAT_SPAYC):BLANK ?>
                    </span>
                  </div>
                </div>
                <?php } ?>

                <div class="address-wrapper">
                  <span>Address</span>
                  <span class="bold-text"><?= !empty($spayc->location)?$spayc->location:BLANK ?></span>
                </div>

                <div class="member-wrapper hide">
                  <span>Members</span>
                  <span class="bold-text">80</span>
                </div>
              </div>
            </div>
            <!--========event count======-->
            <div class="count-box">
              <div class="user-box"><span><?= !empty($spayc->joined_users)?$spayc->joined_users:BLANK_COUNT ?></span> Users</div>
              <div class="subscriber"><span><?= !empty($spayc->subscribed_users)?$spayc->subscribed_users:BLANK_COUNT ?></span> Subscribers</div>
              <div class="present-people"><span><?= !empty($spayc->total_presents)?$spayc->total_presents:BLANK_COUNT ?></span> Present People</div>
              <div class="comment"><span><?= !empty($spayc->total_comments)?$spayc->total_comments:BLANK_COUNT ?></span> Comments</div>
            </div>

            <!--======subspayc=====-->
            <div class="subspayc">
              <h2>Subwarps <span>(<?= count($spayc->sub_spaycs)?>)</span></h2>
              <div class="subspayc-box-wrapper clearfix">
                <?php 
                  if (count($spayc->sub_spaycs)) {
                    $spaycImgShadow = 'gradient-layer.png';
                    foreach($spayc->sub_spaycs as $sub_spaycs ) {                
                      $subSpaycImg ='no-image.png';
                      $spaycImgClass ='no-image-placeholder';
                      if(!empty($sub_spaycs->image)){
                        $subSpaycImg =$sub_spaycs->image;
                        $spaycImgClass='';
                      }
                ?>  
                <div class="subspayc-box">                 
                  <div class="subspayc-image-wrap <?= $spaycImgClass?>">
                    <?= $this->Html->image($subSpaycImg, ["alt" => "", 'class' =>'']); ?>
                    <?= $this->Html->image($spaycImgShadow, ["alt" => "", 'class' =>'img-shadow']); ?>
                  </div>
                  <div class="text-wrap">
                    <span class="<?= strtolower($sub_spaycs->group_type) ?>"></span>
                    <h4><?= !empty($sub_spaycs->name)?$sub_spaycs->name:BLANK?></h4>
                    <p><?= !empty($sub_spaycs->description)?$sub_spaycs->description:BLANK?></p>
                  </div>
                </div>
               <?php 
                  }
               } else { ?>
                <div class="no-data no-user" >                 
                    <h2>No Result Found!</h2>
                </div>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
    </section>