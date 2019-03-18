<?php 
use Cake\Routing\Router;
$spaycUserStatusArr = unserialize(SPAYC_USER_STATUS_ARR);
$spaycTypeArr = unserialize(SPAYC_TYPE_ARR);
$groupTypeArr = unserialize(GROUP_TYPE_ARR);
$statusArr = unserialize(STATUS_ARR);
$txtMassage = unserialize(TEXT_MASSAGE); 
$breadcrumbsTxt= ucfirst($spayc->name);
?>
<!--=============breadcrumbs==============-->            
  <?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>
   <section class="content-wrapper content-filter">
   <span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
        <!--======= event view wrapper==========-->
        <div class="container">
          <div class="event-view-wrapper">
            <!--======event info=====-->
            <div class="event-info d-flex clearfix">
                <?= $this->warpImage($spayc); ?>
              <div class="data-wrap">
                <h1><?= !empty($spayc->name)?$spayc->name:BLANK ?></h1>
                <h3><?php
                    $name = '';
                    $totalAdmin = count($spayc['total_spayc_admin']);
                    if(!empty($user->display_name))
                        $name = ucwords($user->display_name);
                    if(!empty($spayc->is_admin))
                        $name .= '&nbsp;('.$spaycUserStatusArr[$spayc->is_admin].')';
                    echo $name;
                 ?>
                 <?php if($totalAdmin > 1) { ?>
                  <div id="admin_<?=$spayc->id?>" class="hide"><?= $this->element('admin/adminpopuptxt',['total_spayc_admin'=>$spayc['total_spayc_admin']])?></div>
                  <span class="subheading-span">
                  <a href="javascript:void(0)" onclick="showAdmin('<?=$spayc->id?>', '<?=$totalAdmin?>');" class="item-read-more">+ <?= ($totalAdmin -1)?></a>
                  </span>
                  <?php } ?>
                </h3>
                <div class="category-box">
                    <?php echo $this->spycCategories($spayc); ?>
                    <a href="<?php echo $this->url->build(['controller'=>'Spaycs','action'=>'categoryUpdate',$spayc->id]); ?>" class="btn button btn-md cat-edit"><i class="fas fa-check"></i>Edit</a>
                </div>
                <p><?= !empty($spayc->description)?$spayc->description:'' ?></p>
                <div class="event-status">
                  <i class="icon-<?= strtolower($spayc->group_type) ?>-icon"></i>
                  <span><?= $spayc->group_type ?></span>
                </div>
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
                <div class="warp-repeat"><?= $this->eventRepeat($spayc->warp_frequency) ?></div>
                <?php if(!empty($spayc->location)) { ?>
                <div class="address-wrapper">
                  <span>Address</span>
                  <span class="bold-text"><?= !empty($spayc->location)?$spayc->location:BLANK ?></span>
                </div>
                <?php } ?>

                <div class="member-wrapper hide">
                  <span>Members</span>
                  <span class="bold-text">80</span>
                </div>
              </div>
            </div>
            <!--========event count======-->
          <div class="count-box <?php echo (!empty($subspayc))?'count-box-three':''?> ">
              <div class="user-box"><span><?= !empty($spayc->joined_users)?$this->Html->link($spayc->joined_users,['controller' => 'Spaycs', 'action' => 'spayc-members',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span> Users</div>
               <?php if(empty($subspayc)) {?>
              <div class="subscriber"><span><?= !empty($spayc->subscribed_users)?$this->Html->link($spayc->subscribed_users,['controller' => 'Spaycs', 'action' => 'subscribedMembers',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span> Subscribers</div>
              <div class="present-people"><span><?= !empty($spayc->total_presents)?$this->Html->link($spayc->total_presents,['controller' => 'Spaycs', 'action' => 'physicalPresents',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span> Present People</div>
              <?php } else {?>
              <div class="subscriber"><span><?= !empty($spayc->friends)?$spayc->friends:BLANK_COUNT ?></span> Friends</div>
              <?php } ?>
              <div class="comment"><span><?= !empty($spayc->total_comments)? $this->Html->link($spayc->total_comments,['controller' => 'Spaycs', 'action' => 'comments',$spayc->matrix_room_id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span> Comments</div>
            </div>

            <!--======subspayc=====-->
            <?php if(empty($subspayc)) {?>
            <div class="subspayc">
              <h2>Subwarps <span class="sub_spaycs_count">(<?= count($spayc->sub_spaycs)?>)</span></h2>
              <div class="subspayc-box-wrapper clearfix main-spayc-div">
                <?php 
                  if (count($spayc->sub_spaycs)) {                      
                    $spaycImgShadow = 'gradient-layer.png';
                    foreach($spayc->sub_spaycs as $sub_spaycs ) { 
                      
                        $blocktxt =(ucfirst($sub_spaycs->status) == $statusArr['active'])?"Block":"Unblock";
                        $subSpayEmoji=false;
                        $subSpaycImg='';
                        $spaycImgClass ='no-image-placeholder';
                        if(!empty($sub_spaycs->image)) {
                            $subSpaycImg = $sub_spaycs->image; 
                            $spaycImgClass='';
                        } else if(!empty($sub_spaycs->spayc_category->code)){
                            $subSpayEmoji=true;
                            $dec = hexdec($sub_spaycs->spayc_category->code);
                            $subSpaycImg ="&#$dec;"; 
                        } else {
                          $subSpaycImg ='no-image.png';
                        }
                ?>  
                <div class="subspayc-box spayc-div-listing <?php echo $blocktxt =='Block'?'':'disabled';?>">
                  <div class="subspayc-image-wrap <?= !empty($subSpayEmoji)?'blank-emoji':''?> <?= $spaycImgClass?>">
                      <?php 
                        if($subSpayEmoji){
                            echo "<span class='emoji d-flex align-items-center justify-content-center w-100 h-100'>".$subSpaycImg."</span>";
                        } else {
                            echo $this->Html->image($subSpaycImg, ["alt" => "", 'class' =>'']);
                        }
                      ?>
                    <?= $this->Html->image($spaycImgShadow, ["alt" => "", 'class' =>'img-shadow']); ?>
                     <!--======dropdown===-->
                      <div class="dropdown table-view-dropdown square-box-dropdown">
                        <div class="table-dropdown"  id="table-data-dropdown_<?= $sub_spaycs->id?>" data-toggle="dropdown">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="table-data-dropdown_<?= $sub_spaycs->id?>">                             
                          <?= $this->Html->link("<i class='icon-view'></i>View",['controller' => 'Spaycs', 'action' => 'view',$sub_spaycs->id,$spayc->user_id,'subspayc'], ['class' => 'dropdown-item view','escape' => false]);?>    
<!--                          <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item status_<?php //echo $sub_spaycs->id?> <?php //echo strtolower($blocktxt)?>" page="<?php //echo $this->Url->build(["controller" => "Spaycs","action" => "setSpaycStatus",$sub_spaycs->id]);?>"><i class='icon-block'></i><span class="status_<?php //echo $sub_spaycs->id?>"><?php //echo $blocktxt?></span></a>                      -->
                          <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                          <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item delete" page="<?php echo $this->Url->build(["controller" => "Spaycs","action" => "deleteSpayc",$sub_spaycs->id]);?>"><i class='icon-Delete'></i>
                          <span>Delete</span></a>
                        </div>
                      </div>
                  </div>
                  <div class="text-wrap">
                    <span class="<?= !empty($sub_spaycs->group_type)?strtolower($sub_spaycs->group_type):'' ?>"></span>
                    <h4><?= !empty($sub_spaycs->name)?$sub_spaycs->name:''?></h4>
                    <p><?= !empty($sub_spaycs->description)?$sub_spaycs->description:''?></p>
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
            <?php } ?>
          </div>
        </div>
          <div id="no-spayc" class="hide">       
            <div class="no-data no-user" >                 
              <h2>No Result Found!</h2>
            </div>
          </div>
    </section>
<!-- Modal box to update category -->
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="CategoryUpdate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content user-list-modal">
          <div class="modal-header">
              <h5 class="modal-title">Update Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="modal-close"></span></button>
          </div>
          <div class="modal-body">
              <div class="flash-box"></div>
              <div class="category-box">
                  <form name="updatecat" id="updatecat" action="" method="post">
                  <div class="row">
                  <div class="form-group col-sm-8">
                      <input id="findcat" class="form-control" type="text" placeholder="Search..">
                  </div>
                      <div class="form-group col-sm-4">
                          <button class="btn btn-primary update-cat">Save</button>
                      </div>
                  </div>
                  <table class="table table-borderless" id="cat-item">
                      <tr>
                          <th>Parent Category</th>
                          <th>Category</th>
                          <th>Emoji</th>
                          <th>Primary Category</th>
                          <th>Other Category</th>
                      </tr>
                      <?php $warpCat = $this->warpCategories($spayc); ?>
                      <?php foreach ($categories as $parentcateory): ?>
                      <?php foreach ($parentcateory['sub_categories'] as $category): ?>                      
                        <tr>
                            <td><?= $parentcateory->name ?></td>
                            <td><?= h($category->name) ?></td>                            
                            <td>
                                <span style="font-size: 25px;">
                                <?php echo $this->emoji($category->code); ?>
                                </span>
                            </td>
                            <td><input type="checkbox" data-option="primary" class="form-control catopt" name="primary_category" value="<?= $category->id ?>" <?php echo ($category->id == $warpCat['primary'])?'checked="checked"':'' ?> /></td>
                            <td><input type="checkbox" data-option="other" class="form-control catopt" name="other_category[]" value="<?= $category->id ?>" <?php echo in_array($category->id,$warpCat['other'])?'checked="checked"':'' ?> /></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                  </table>
                  </form>    
              </div>
          </div>
      </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){       
        $("#findcat").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#cat-item tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $(document).on('change','.catopt',function(){
            var attrName = $('input[name="'+$(this).attr('name')+'"]');
            var selected = attrName.filter(':checked').length;
            
            if(($(this).attr('data-option') == 'primary') && (selected > 1)){
                $(this).prop('checked',false);
                notification('Only one primary category can select.','error');
            }
            if(($(this).attr('data-option') == 'other') && (selected > 5)){
                $(this).prop('checked',false);
                notification('Only five other category can select.','error');
            }
        });
        $(document).on('click','.update-cat',function(){
            $("#updatecat").submit();
            $(this).addClass('disabled');
	});
    });
</script>
<?php echo $this->Html->script(['admin/spayc','admin/admin-manage-user']); ?>