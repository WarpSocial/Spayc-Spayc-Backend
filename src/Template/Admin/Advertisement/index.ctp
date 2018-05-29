<?php 
use Cake\Routing\Router;
$statusArr = unserialize(STATUS_ARR);
$advertisementsCount=$filter=false;
if(count($advertisements) > 0) 
  $advertisementsCount=true; 
if($this->request->query())
  $filter=true;
$breadcrumbsTxt = (isset($user) && !empty($user)) ? 'Advertisements created by '.ucwords($user->display_name):''; 
 $nameIconSorting=$priceIconSorting=$statusIconSorting='filter.png';
if(isset($this->request->query['sort'])) {

    if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'asc')) 
        $nameIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'desc')) 
        $nameIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'price') && ($this->request->query['direction'] == 'asc')) 
        $priceIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'price') && ($this->request->query['direction'] == 'desc')) 
        $priceIconSorting = 'filter-down.png';

    if(($this->request->query['sort'] == 'status') && ($this->request->query['direction'] == 'asc')) 
        $statusIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'status') && ($this->request->query['direction'] == 'desc')) 
        $statusIconSorting = 'filter-down.png';
}
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>
<section class="content-wrapper content-filter">
 <span class="error-alert users-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->
        <?php if($advertisementsCount || $filter){ 
                echo $this->element('admin/user-filter', ['userFilter'=> false]);
        ?>
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
          <div class="table-head">
            <div class="head-text flex-basis15 text-left">
            <span class="table-filter"><?php echo $this->Paginator->sort('name','Name').'&nbsp;<i>'.$this->Paginator->sort('name',$this->Html->image($nameIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?>     
            </span>
            </div>
            <div class="head-text flex-basis12">
              <span class="table-filter"><?php echo $this->Paginator->sort('price',"Promotional Price").'&nbsp;<i>'.$this->Paginator->sort('price',$this->Html->image($priceIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span>
            </div>
            <div class="head-text flex-basis18 text-left"><span>Description</span></div>
            <div class="head-text flex-basis16 text-left"><span>Hyperlink</span></div>
            <div class="head-text flex-basis11"><span class="table-filter"><?php echo $this->Paginator->sort('status',"Status").'&nbsp;<i>'.$this->Paginator->sort('status',$this->Html->image($statusIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span></div>
            <div class="head-text flex-basis11"><span>Number of Total Views</span></div>
            <div class="head-text flex-basis11"><span>Number of Views Left</span></div>
            <div class="head-text flex-basis6"><span>Action</span></div>
          </div>
          <?php   if ($advertisementsCount) {?>  
            <?php foreach($advertisements as $advertisement) { ?>
            <!--==============table data====================-->
              <div class="table-row" id="<?=$advertisement->id?>">      
                <div class="table-data d-flex-a-center flex-basis15 text-left">
                  <span class="data-image"><?= !empty($advertisement->image)?$this->Html->image($advertisement->image, ['alt' => '']):$this->Html->image('table-img.png', ['alt' => 'img'])?></span>
                  <span class="data-name"><?= !empty($advertisement->name)?h(ucwords($advertisement->name)):BLANK ?></span>
                </div>

                <div class="table-data flex-basis12">
                  <span>$<?= !empty($advertisement->price)?($advertisement->price):BLANK_COUNT?></span>
                </div>
                
                <div class="table-data flex-basis18 text-left">
                  <span><?= !empty($advertisement->description)?$this->Text->truncate(h($advertisement->description),25,['ellipsis' => '...',
        'exact' => false]):BLANK ?></span>
                <?php if (!empty($advertisement->description) && (strlen($advertisement->description) > 25)) {?>
                  <span>
                  <a href="javascript:void(0)" onclick="showModel('<?= h($advertisement->description)?>');" class="item-read-more">+ Read more</a>
                  </span>
                  <?php } ?>
                </div>
                <div class="table-data flex-basis16 text-left">
                  <span>
                        <?= !empty($advertisement->url)?
                            $this->Html->link(strtolower($advertisement->url),$advertisement->url,[ 'target' => '_blank']):BLANK ?>
                  </span>
                </div>
                <div class="table-data flex-basis11">
                  <span><?php $txt = (strtolower($advertisement->status) === strtolower($statusArr['inactive']))?'Expire':$advertisement->status;
                        echo !empty($advertisement->status)?h($txt):BLANK ?></span>
                </div>
                <div class="table-data flex-basis11">
                  <span><?= !empty($advertisement->views)?h($advertisement->views):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis11">
                  <span><?= !empty($advertisement->balance)?h($advertisement->balance):BLANK_COUNT ?></span>
                </div>
                <?php  
                  $chkAdvertisement='advertisement';
                  if(isset($user) && !empty($user))
                    $chkAdvertisement='users';
                ?>
                <div class="table-data flex-basis6">
                  <span><a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop action-btn dropdown-item status_<?= $advertisement->id?>" page="<?php echo $this->Url->build(["controller" => "Advertisement","action" => "delete",$advertisement->id,$chkAdvertisement]);?>"><?= $this->Html->image('delete-red.png')?></a>
                  </span>
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
          <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
              <ul class="pagination table-pagination">
                <?= $this->Paginator->prev('',['escape' => false]) ?>
                <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
                <?= $this->Paginator->next('',['escape' => false]) ?>
              </ul>
          <?php } ?>

      </div>      
    </div>
    <?php }  else { ?>
      <div class="no-data-wrapper">
        <div class="no-data no-user" >
            <?php echo $this->Html->image('no-advertisement.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>No Advertisement Found!</h2>
            <p>Seems like no user has created the advertisement yet!</p>
        </div>
      </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>