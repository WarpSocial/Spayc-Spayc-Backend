<div class="spaycCategories index">
<div class="panel panel-default">
        <div class="panel-heading"><?= __('Spayc Categories') ?> Listing
            <div class="pull-right rtbutton">
                <?= $this->Html->link(__("<span class='fa fa-plus'></span>&nbsp;&nbsp;New spaycCategory") , ['action' => 'create'],['class'=>'btn btn-primary','escape' => false]) ?>
               
           </div>
        </div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>SNO</th>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('parent_id','Parent Name') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('code') ?></th>
                <th>Emoji</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; ?>
            <?php foreach ($spaycCategories as $spaycCategory): ?>
            <tr>
                <td><?php echo $i;$i++ ?></td>
                <td><?= $this->Number->format($spaycCategory->id) ?></td>
                <td><?= $spaycCategory->has('parent_spayc_category') ? $spaycCategory->parent_spayc_category->name : '' ?></td>
                <td><?= h($spaycCategory->name) ?></td>
                <td><?= h($spaycCategory->slug) ?></td>
                <td><?= h($spaycCategory->code) ?></td>
                <td><span style="font-size: 25px;">
                    <?php 
                    
                    if(preg_match('/\{(.*)\}/', $spaycCategory->code)){
                        preg_match_all('/{(.*?)}/',  $spaycCategory->code, $matches);
                        if(!empty($matches[1])){
                            echo "&#".hexdec($matches[1][0])."&#".hexdec($matches[1][1]).";";
                        }
                    }else{
                        echo "&#".hexdec($spaycCategory->code).";";
                    }
                    ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    
    </div><!-- end panel body -->
</div>
</div>
