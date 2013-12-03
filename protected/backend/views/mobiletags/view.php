<?php
/* @var $this MobiletagsController */
/* @var $model Mobiletags */

$this->breadcrumbs=array(
	'Mobiletags'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Mobiletags', 'url'=>array('index')),
	array('label'=>'Create Mobiletags', 'url'=>array('create')),
	array('label'=>'Update Mobiletags', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mobiletags', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mobiletags', 'url'=>array('admin')),
);
?>

<h1>View Mobiletags #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
