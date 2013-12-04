<div class="list-bot">
<h1 style = "margin-bottom: 0;">Мои <?php echo Yii::app()->controller->action->id == 'myfollowers' ? 'подписчики' : 'подписки'; ?></h1>
<br>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_follower',
    'summaryText' => 'Показаны {start}-{end} из {count}.',
    'emptyText' => 'У вас еще нет подписок'
)); ?>

<?php
Yii::app()->clientScript->registerScript('remove-follower',"

     $( '.rmfollower').on('click', function(event){
           event.preventDefault();
           var followerUrl = $(this).attr('href');
           var urlID = followerUrl.split('/')[3];
           var parent = $(this).parent();
                $.ajax({
                       type: 'POST',
                       url: followerUrl,
                       data: {urlID: urlID},
                       success: function(msg){
                            if (msg == 1){
                                parent.remove();
                            }
                       }
                });
            return false;
     });
            ", CClientScript::POS_END);
?>