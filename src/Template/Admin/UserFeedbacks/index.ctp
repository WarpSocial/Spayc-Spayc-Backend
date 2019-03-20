<?php echo $this->element('admin/breadcrumbs', ['action' => $breadcrumbsTxt]); ?>
<?= $this->Flash->render() ?>
<section class="content-wrapper content-filter">
    <div class="container">
        <div class="userFeedbacks index">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('user_id') ?></th>
                                <th><?= $this->Paginator->sort('attachment') ?></th>
                                <th><?= $this->Paginator->sort('created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userFeedbacks as $userFeedback): ?>
                                <tr>
                                    <td><?= $this->Number->format($userFeedback->id) ?></td>
                                    <td><?= $userFeedback->has('user') ? $userFeedback->user->display_name : '' ?></td>
                                    <td><?php 
                                    if(!empty($userFeedback->attachment)):
                                        echo $this->Html->link('Download', ['controller' => 'UserFeedbacks', 'action' => 'download', $userFeedback->id]);
                                    else:
                                        echo '--';
                                    endif;
                                    ?></td>
                                    <td><?= h($userFeedback->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<span class="replyon">Reply</span>', ['action' => 'reply', $userFeedback->id], ['title' => 'Reply', 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
                    <ul class="pagination table-pagination">
                      <?= $this->Paginator->prev('',['escape' => false]) ?>
                      <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
                      <?= $this->Paginator->next('',['escape' => false]) ?>
                    </ul>
                <?php } ?>
                </div><!-- end panel body -->
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="CategoryUpdate" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content user-list-modal">
            <div class="modal-header">
                <h5 class="modal-title">Reply<?php echo $userFeedback->has('user') ? ' to '.ucfirst($userFeedback->user->display_name) : '' ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="modal-close"></span></    button>
            </div>
            <div class="modal-body">                
                <div class="row row-modal">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Reply To</label>
                            <input id="reply_to" class="form-control" type="text" readonly="readonly" value="<?= $userFeedback->user->email ?>">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="reply_message" id="reply_message" class="form-control" rows="10"></textarea>
                        </div>                  
                        <div class="form-group">
                            <button class="btn button btn-md">Reply</button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){       
        $(document).on('click','.replyon',function(ev){
            ev.preventDefault();
            $("#category-modal").modal("show");
        });
    });
</script>