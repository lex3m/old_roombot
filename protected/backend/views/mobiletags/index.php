<?php
/* @var $this MobiletagsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mobiletags',
);

$this->menu=array(
	array('label'=>'Create Mobiletags', 'url'=>array('create')),
	array('label'=>'Manage Mobiletags', 'url'=>array('admin')),
);
?>

<h1>Mobiletags</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
