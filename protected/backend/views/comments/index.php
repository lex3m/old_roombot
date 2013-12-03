<h1>Комментарии</h1>
<?php $this->widget('AdminHeadMenu', array()); ?>
<?php
 $this->widget('zii.widgets.CListView', array('viewData' => array(),'dataProvider'=>$dataProvider,'itemView'=>'_comments','ajaxUpdate'=>false)); 
?>