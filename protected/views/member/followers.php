<div class="list-bot">
<h1 style = "margin-bottom: 0;">Мои подписки</h1>
<br>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_follower',
    'summaryText' => 'Показаны {start}-{end} из {count}.'
)); ?>
