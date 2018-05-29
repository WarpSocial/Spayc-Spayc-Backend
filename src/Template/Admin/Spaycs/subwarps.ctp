<?php 
use Cake\Routing\Router;
$breadcrumbsTxt = (isset($spayc) && !empty($spayc)) ? 'subwarp in the '.ucwords($spayc->name):''; 
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>

   <section class="content-wrapper content-filter">
        <!--======= event view wrapper==========-->
        <div class="container">
          <div class="event-view-wrapper">
            <!--======subspayc=====-->
            <div class="subspayc">             
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
                     <!--======dropdown===-->
                      <div class="dropdown table-view-dropdown square-box-dropdown">
                        <div class="table-dropdown"  id="table-data-dropdown_<?= $sub_spaycs->id?>" data-toggle="dropdown">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="table-data-dropdown_<?= $sub_spaycs->id?>">                             
                          <?= $this->Html->link("<i class='icon-view'></i>View",['controller' => 'Spaycs', 'action' => 'view',$sub_spaycs->id,$spayc->user_id,'subspayc'], ['class' => 'dropdown-item view','escape' => false]);?>    
                          <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                          <button class="dropdown-item delete"> <i class="icon-Delete"></i>Delete</button>
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
                  <div class="no-data-wrapper">
                    <div class="no-data no-user" >
                        <?php echo $this->Html->image('no-spayc.png', ["alt" => "", 'class' =>'mb-30' ]);?>
                        <h2>No Subwarps Found!</h2>
                        <p>Seems like no user has created the subwarps yet!</p>
                    </div>
                  </div>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
    </section>