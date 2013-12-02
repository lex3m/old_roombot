<?php
/* @var $this MobilepicturesController */
/* @var $model Mobilepictures */

$this->breadcrumbs=array(
	'Mobilepictures'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mobilepictures', 'url'=>array('index')),
	array('label'=>'Create Mobilepictures', 'url'=>array('create')),
	array('label'=>'View Mobilepictures', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mobilepictures', 'url'=>array('admin')),
);
?>

<h1>Update Mobilepictures <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>