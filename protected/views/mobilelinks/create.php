<?php
/* @var $this MobilelinksController */
/* @var $model Mobilelinks */

$this->breadcrumbs=array(
	'Mobilelinks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mobilelinks', 'url'=>array('index')),
	array('label'=>'Manage Mobilelinks', 'url'=>array('admin')),
);
?>

<h1>Create Mobilelinks</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>