<?php
/* @var $this KindUsersController */
/* @var $model KindUsers */

$this->breadcrumbs=array(
	'Kind Users'=>array('index'),
	$model->ID,
);

$this->menu=array(
	array('label'=>'List KindUsers', 'url'=>array('index')),
	array('label'=>'Create KindUsers', 'url'=>array('create')),
	array('label'=>'Update KindUsers', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete KindUsers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KindUsers', 'url'=>array('admin')),
);
?>

<h1>View KindUsers #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'userType',
	),
)); ?>
