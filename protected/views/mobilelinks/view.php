<?php
/* @var $this MobilelinksController */
/* @var $model Mobilelinks */

$this->breadcrumbs=array(
	'Mobilelinks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Mobilelinks', 'url'=>array('index')),
	array('label'=>'Create Mobilelinks', 'url'=>array('create')),
	array('label'=>'Update Mobilelinks', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mobilelinks', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mobilelinks', 'url'=>array('admin')),
);
?>

<h1>View Mobilelinks #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tagId',
		'imageId',
	),
)); ?>
