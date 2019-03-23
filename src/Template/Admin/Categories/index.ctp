<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>
<section class="content-wrapper content-filter">
    <div class="container">
    <?= $this->Flash->render() ?>
       <!--===========filter================-->
    <div class="filters">
        <div class="container">
            <div class="filter-wrapper">
              <!--============search dropdown========-->
                <div class="search">
                    <div class="form-group">
                        <form name="filter-form" id="filter-form" method="get" action="">
                        <?= $this->Form->input('keyword',['type'=>'text', 'class'=>'form-control','label'=>false, 'placeholder'=>'Search', 'value'=> $this->request->query('keyword')]); ?>
                        <span class="clear-search hide" id="clear-search"></span>
                        </form>
                    </div>
                </div>
                <div class="filter-by ml-auto">
                    <?= $this->Html->link(__("New Category") , ['action' => 'add'],['class'=>'btn button btn-md ','escape' => false]) ?>                
                </div>
            </div>
        </div>
    </div>
    <!--============= table head ===================-->    
        <div class="table-wrapper">
            <div class="table-head">
            <div class="head-text flex-basis30 text-left">
                <span class="table-filter"><?= $this->Paginator->sort('parent_id') ?></span>
            </div>
            <div class="head-text flex-basis30 text-left">
                <span class="table-filter"><?= $this->Paginator->sort('name','Title') ?></span>
            </div>
            <div class="head-text flex-basis20 text-left">
                <span><?= __('Emoji') ?></span>
            </div>
            <div class="head-text flex-basis20 text-center">
                <span><?= __('Actions') ?></span>
            </div>
          </div>
          <!--==============table data====================-->
          <?php foreach ($spaycCategories as $spaycCategory): ?>
          <div class="table-row">            
            <div class="table-data flex-basis30 text-left">
              <span><?= $spaycCategory->has('parent_spayc_category') ? $spaycCategory->parent_spayc_category->name:'' ?></span>
            </div>
            <div class="table-data flex-basis30 text-left">
              <span><?= h($spaycCategory->name) ?></span>
            </div>
            <div class="table-data flex-basis20 text-center">
                <span class="data-image">
                    <?= $this->emoji($spaycCategory->code); ?>
                </span>
            </div>
            <div class="table-data flex-basis20 text-center">
                <span>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $spaycCategory->id],['title'=>'Edit','escape' => false]) ?>
                </span>
            </div>
          </div>
          <?php endforeach; ?>
        <!--===========pagination========-->
        <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
            <ul class="pagination table-pagination">
              <?= $this->Paginator->prev('',['escape' => false]) ?>
              <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
              <?= $this->Paginator->next('',['escape' => false]) ?>
            </ul>
        <?php } ?>
        </div>
    </div>
</section>