<?php //echo $this->element('admin/breadcrumbs', ['action' => $breadcrumbsTxt]); ?>
<?= $this->Flash->render() ?>
<section class="content-wrapper content-filter">
    <div class="container">
        <div class="userFeedbacks index">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="body-msg"></div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('user_id') ?></th>
                                <th><?= $this->Paginator->sort('message') ?></th>
                                <th><?= $this->Paginator->sort('attachment') ?></th>
                                <th><?= $this->Paginator->sort('created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userFeedbacks as $userFeedback): ?>
                                <tr>
                                    <td><?= $this->Number->format($userFeedback->id) ?></td>
                                    <td><?php
                                     if($userFeedback->has('user')){
                                        echo $this->Form->hidden('user_email',['value'=>$userFeedback->user->email,'class'=>'useremail']);
                                        echo $userFeedback->user->display_name;
                                     }else{
                                        echo '--';
                                     }
                                     ?></td>
                                     <td><?= $userFeedback->message ?></td>
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
                <h5 class="modal-title">Reply on comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="modal-close"></span></    button>
            </div>
            <div class="modal-body">                
                <div class="row row-modal">
                    <form id="reply-form" name="reply-form" action="" method="post" class="reply-form">
                        <div class="col-sm-12">
                            <div id="flashmsg"></div>
                            <div class="form-group">
                                <label>Reply To</label>
                                <input id="reply_to" class="form-control" type="text" readonly="readonly" >
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="reply_message" id="reply_message" class="form-control" rows="10"></textarea>
                                <small class="input-alert hide">This field cannot be left empty</small>
                            </div>                  
                            <div class="form-group">
                                <button type="submit" class="btn button btn-md replybtn">Reply</button>
                            </div>
                        </div>
                    </form>    
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
            $("#reply_to").val('');
            $("#reply-form").attr('action','');
            $("#reply_message").val('');
            $(".input-alert").addClass('hide');
            $("#reply_to").val($(this).closest('tr').find('.useremail').val());
            $("#reply-form").attr('action',$(this).closest('a').attr('href'));
            $("#category-modal").modal("show");
        });
        
        $(document).on('submit','#reply-form',function(e){
            var replyMsg = $("#reply_message").val();
            var url = $(this).attr('action');
            if(replyMsg.length <= 0){
                $(".input-alert").removeClass('hide');
            }
            $(".replybtn").addClass('disabled');
            $.ajax({
                type: 'POST',
                url: url,
                data: {'message':replyMsg}
            }).done(function(data,textStatus, jqXHR){
                if(data.status === true){
                    WARPJS.notification(data.message,'success',".body-msg");
                }else{
                    WARPJS.notification(data.message,'error',"#flashmsg");
                }
                $("#category-modal").modal("hide");
                $(".replybtn").removeClass('disabled');
            }).fail(function(jqXHR, textStatus, errorThrown) { 
                WARPJS.notification(data.message,'error',"#flashmsg");
                $(".replybtn").removeClass('disabled');
            });            
            return false;
        });
    });
</script>