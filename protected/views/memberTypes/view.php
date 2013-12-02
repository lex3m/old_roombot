<?php
/* @var $this MemberTypesController */
/* @var $model MemberTypes */

$this->breadcrumbs=array(
	'Member Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List MemberTypes', 'url'=>array('index')),
	array('label'=>'Create MemberTypes', 'url'=>array('create')),
	array('label'=>'Update MemberTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MemberTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MemberTypes', 'url'=>array('admin')),
);
?>

<h1>View MemberTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
