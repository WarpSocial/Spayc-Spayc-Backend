<?php 
use Cake\Routing\Router;
$statusArr = unserialize(STATUS_ARR);
$spaycTypeArr = unserialize(SPAYC_TYPE_ARR);
$groupTypeArr = unserialize(GROUP_TYPE_ARR);
$txtMassage = unserialize(TEXT_MASSAGE);  
$spaycsCount=$filter=false;
if(count($spaycs) > 0) 
  $spaycsCount=true; 
if($this->request->query())
  $filter=true;

$breadcrumbTxt = !empty($listBy) ? SITE_TITLE.'s '.$listBy.' by '.ucwords($user->display_name):''; 
?>       

<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbTxt]);?>
<section class="content-wrapper content-filter main-spayc-div">
 <span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
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
                  $spayEmoji=false;
                  $spaycImg ='no-image.png';                 
                  $spaycImgClass ='no-image-placeholder';                  
                  if(!empty($spayc->image)){
                    $spaycImg =$spayc->image;                                
                    $spaycImgClass='';
                  } else if(!empty($spayc->spayc_category->code)){
                    $spayEmoji=true;
                    $dec = hexdec($spayc->spayc_category->code);
                    $spaycImg ="&#$dec;"; 
                  }

                  
                  
                  
              ?>  
              <?php                
              $blocktxt =(ucfirst($spayc->status) == $statusArr['active'])?"Block":"Unblock";?>
              <div class="square-box spayc-div-listing <?php echo $blocktxt =='Block'?'':'disabled';?>">
                  <div class="image-wrap <?= !empty($spayEmoji)?'blank-emoji':''?> <?= $spaycImgClass?>">
                    <?php if($spayEmoji){
                      echo "<span class='emoji d-flex align-items-center justify-content-center w-100 h-100'>".$spaycImg."</span>";
                    } else { ?>
                    <?php echo $this->Html->image($spaycImg, ["alt" => "", 'class' =>'']); }?>
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
                      <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item status_<?= $spayc->id?> <?= strtolower($blocktxt)?>" page="<?php echo $this->Url->build(["controller" => "Spaycs","action" => "setSpaycStatus",$spayc->id]);?>"><i class='icon-block'></i><span class="status_<?= $spayc->id?>"><?= $blocktxt?></span>
                      </a>                      
                        <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item delete" page="<?php echo $this->Url->build(["controller" => "Spaycs","action" => "deleteSpayc",$spayc->id]);?>"><i class='icon-Delete'></i>
                            <span>Delete</span></a>
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
    <?php }  ?>
    <div id="no-spayc" class="hide">       
    <div class="no-data-wrapper" >
        <div class="no-data no-spayc">          
          <?php echo $this->Html->image('no-spayc.png', ["alt" => "", 'class' =>'mb-30' ]);?>
          <h2> No Spayc Found!</h2>
          <p>Seems like no user has created the spayc yet!</p>
        </div>
      </div>
   </div>

</section>
<?php echo $this->Html->script(['admin/spayc','admin/admin-manage-user']); ?>
