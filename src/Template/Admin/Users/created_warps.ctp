<?php 
use Cake\Routing\Router;
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
          <p><span>Users</span> <span>Warps Joined by </span></p>
        </div>
      </div>

<section class="content-wrapper content-filter">
 <span class="error-alert users-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->        
        <?php if($spaycsCount || $filter){ 
                echo $this->element('admin/user-filter', ['userFilter'=> false]);
        ?>
      <!--============= table head ===================-->
       <div class="container">
          <div class="event-box-wrapper clearfix">
            <!--=======Square-box=======-->
              <?php if ($spaycsCount) {
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
                      <div class="box-heading event"><?= $spayc->type?></div>
                      <div class="tag-line ell">
                          <span><?= $spayc->name?></span>
                          <i class="icon-public-icon"></i>
                      </div>
                      <!--======dropdown===-->
                      <div class="dropdown table-view-dropdown square-box-dropdown">
                        <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                          <button class="dropdown-item view"> <i class="icon-view"></i>View</button>
                          <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                          <button class="dropdown-item delete"> <i class="icon-Delete"></i>Delete</button>
                        </div>
                      </div>
                  </div>
                  <div class="info-wrap">
                      <div class="date-row info-data ell">
                          <span><?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date).' - '.$this->dateFormat($spayc->end_date):BLANK ?></span>
                      </div>
                      <div class="time-row info-data ell">
                          <span>10:00 AM - 10:00 PM</span>
                      </div>
                      <div class="address-row info-data ell">
                          <span>600 Ryann Streets Apt. 044</span>
                      </div>
                      <div class="comment-row info-data ell">
                          <span>50 Comments</span>
                      </div>
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
<?php echo $this->Html->script(['admin/user','admin/admin-manage-user']); ?>