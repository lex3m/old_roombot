<?php
/* @var $this MobilelinksController */
/* @var $model Mobilelinks */

$this->breadcrumbs=array(
	'Mobilelinks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mobilelinks', 'url'=>array('index')),
	array('label'=>'Create Mobilelinks', 'url'=>array('create')),
	array('label'=>'View Mobilelinks', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mobilelinks', 'url'=>array('admin')),
);
?>

<h1>Update Mobilelinks <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>