<?php 
use Cake\Routing\Router;
$spaycTypeArr = unserialize(SPAYC_TYPE_ARR);
$groupTypeArr = unserialize(GROUP_TYPE_ARR);
$spaycsCount=$filter=false;
if(count($spaycs) > 0) 
  $spaycsCount=true; 
if($this->request->query())
  $filter=true;
?>
<!--=============breadcrumbs==============-->            
      <div class="breadcrumbs">
        <div class="container">
          <h4>Manage Users</h4>
          <p><span>Users</span> <span>Warps Created by <?= !empty($user->display_name)?ucwords($user->display_name):''?>  </span></p>
        </div>
      </div>

<section class="content-wrapper content-filter">
<span class="error-alert users-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->        
        <?php if($spaycsCount || $filter){ 
                echo $this->element('admin/user-filter', ['userFilter'=> false]);
        ?>
       <div class="container">
          <div class="event-box-wrapper clearfix">
            <!--=======Square-box=======-->
              <?php if ($spaycsCount) {
                $spaycImgShadow = 'gradient-layer.png';
                foreach($spaycs as $spayc) {                
                  $spaycImg ='no-image.png';
                  $spaycImgClass ='no-image-placeholder';
                  if(!empty($spayc->image)){
                    $spaycImg =$spayc->image;
                    $spaycImgClass='';
                  }
              ?>  
              <div class="square-box">
                  <div class="image-wrap <?= $spaycImgClass?>">
                    <?= $this->Html->image($spaycImg, ["alt" => "", 'class' =>'']); ?>
                    <?= $this->Html->image($spaycImgShadow, ["alt" => "", 'class' =>'img-shadow']); ?>
                      <div class="box-heading <?= strtolower($spayc->type)?>"><?= !empty($spayc->type)?$spayc->type:BLANK?></div>
                      <div class="tag-line ell">
                          <span><?= !empty($spayc->name)?$spayc->name:BLANK?></span>
                          <i class="icon-<?= strtolower($spayc->group_type) ?>-icon"></i>
                      </div>
                      <!--======dropdown===-->
                      <div class="dropdown table-view-dropdown square-box-dropdown">
                        <div class="table-dropdown"  id="table-data-dropdown_<?= $spayc->id?>" data-toggle="dropdown">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="table-data-dropdown_<?= $spayc->id?>">                             
                          <?= $this->Html->link("<i class='icon-view'></i>View",['controller' => 'Spaycs', 'action' => 'view',$spayc->id,$spayc->user_id], ['class' => 'dropdown-item view','escape' => false]);?>    
                          <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                          <button class="dropdown-item delete"> <i class="icon-Delete"></i>Delete</button>
                        </div>
                      </div>
                  </div>
                  <div class="info-wrap">
                    <?php if($spayc->type == $spaycTypeArr['event']) {?>
                      <div class="date-row info-data ell">
                          <span><?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date,DATEFORMAT_SPAYC).'&nbsp;-&nbsp;'.$this->dateFormat($spayc->end_date, DATEFORMAT_SPAYC):BLANK ?></span>
                      </div>
                      <div class="time-row info-data ell">
                          <span><?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date,TIMEFORMAT_SPAYC).'&nbsp;-&nbsp;'.$this->dateFormat($spayc->end_date, TIMEFORMAT_SPAYC):BLANK ?></span>
                      </div>
                      <?php } if(!empty($spayc->location)) { ?>
                      <div class="address-row info-data ell">
                        <span><?= $spayc->location ?></span>
                      </div>
                      <?php } if(!empty($spayc->total_presents)) { ?>
                      <div class="presented-row info-data ell">
                          <span><?= $spayc->total_presents ?> Present</span>
                      </div>
                      <?php } if(!empty($spayc->joined_users)) { ?>
                      <div class="friends-row info-data ell">
                          <span><?= $spayc->joined_users ?> Joiners</span>
                      </div>
                      <?php } if(!empty($spayc->total_comments)) { ?>
                      <div class="comment-row info-data ell">
                        <span><?= $spayc->total_comments ?> Comments</span>
                      </div>
                      <?php } ?>
                  </div>
              </div>
              <?php 
                }
               } else { ?>
              <div class="no-data-wrapper">
                <div class="no-data no-user" >
                    <?php echo $this->Html->image('no-result.png', ["alt" => "", 'class' =>'mb-30' ]);?>
                    <h2>No Result Found!</h2>
                    <p>Try with different keywords to find what you're looking for.</p>
                </div>
              </div>
          <?php } ?>
          </div>
        <!--===========pagination========-->
          <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
              <ul class="pagination table-pagination">
                <?= $this->Paginator->prev('',['escape' => false]) ?>
                <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
                <?= $this->Paginator->next('',['escape' => false]) ?>
              </ul>
          <?php } ?>
         
      </div>
      
    <?php }  else { ?>
      <div class="no-data-wrapper">        
        <div class="no-data no-spayc">          
          <?php echo $this->Html->image('no-spayc.png', ["alt" => "", 'class' =>'mb-30' ]);?>
          <h2> No Spayc Found!</h2>
          <p>Seems like no user has created the spayc yet!</p>
        </div>
      </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>