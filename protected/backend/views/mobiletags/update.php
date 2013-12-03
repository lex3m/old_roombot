<?php
/* @var $this MobiletagsController */
/* @var $model Mobiletags */

$this->breadcrumbs=array(
	'Mobiletags'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mobiletags', 'url'=>array('index')),
	array('label'=>'Create Mobiletags', 'url'=>array('create')),
	array('label'=>'View Mobiletags', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mobiletags', 'url'=>array('admin')),
);
?>

<h1>Update Mobiletags <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>