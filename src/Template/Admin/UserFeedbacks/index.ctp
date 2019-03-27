<?php echo $this->element('admin/breadcrumbs', ['action' => $breadcrumbsTxt]); ?>
<?= $this->Flash->render() ?>
<section class="content-wrapper content-filter">
    <div class="container">
    <div class="filters">        
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
            </div>
    </div>
        <div class="userFeedbacks index">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="body-msg"></div>
                    <div class="table-wrapper">
            <div class="table-head">
            <div class="head-text flex-basis20 text-left">
                <span>User Name</span>
            </div>
            <div class="head-text flex-basis40 text-left">
                <span>Message</span>
            </div>
            <div class="head-text flex-basis15 text-left">
                <span>Attachment</span>
            </div>
            <div class="head-text flex-basis15 text-center">
                <span>Created</span>
            </div>
            <div class="head-text flex-basis10 text-center">
                <span>Action</span>
            </div>
          </div>
          <!--==============table data====================-->
          <?php if(empty($userFeedbacks)): ?>
          <div class="table-row">
            <div class="table-data flex-basis30 text-left"></div>
          </div>
          <?php endif; ?>
          <?php foreach ($userFeedbacks as $userFeedback): ?>
          <div class="table-row">
            <div class="table-data flex-basis30 text-left">
              <span>
              <?php
                if($userFeedback->has('user')){
                echo $this->Form->hidden('user_email',['value'=>$userFeedback->user->email,'class'=>'useremail']);
                echo $userFeedback->user->display_name;
                }else{
                echo '--';
                }
                ?>
              </span>
            </div>
            <div class="table-data flex-basis30 text-left">
              <span><?= $userFeedback->message ?></span>
            </div>
            <div class="table-data flex-basis20 text-center">
                <span>
                <?php 
                if(!empty($userFeedback->attachment)):
                    echo $this->Html->link('Download', ['controller' => 'UserFeedbacks', 'action' => 'download', $userFeedback->id]);
                else:
                    echo '--';
                endif;
                ?>
                </span>
            </div>
            <div class="table-data flex-basis20 text-center">
                <span><?= $userFeedback->created ?></span>
            </div>
            <div class="table-data flex-basis20 text-center">
                <span><?= $this->Html->link('<span class="replyon">Reply</span>', ['action' => 'reply', $userFeedback->id,'?'=>['keyword'=>$this->request->query('keyword')]], ['title' => 'Reply', 'escape' => false]) ?></span>
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
            $("#reply_to").val($(this).closest('.table-row').find('.useremail').val());
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