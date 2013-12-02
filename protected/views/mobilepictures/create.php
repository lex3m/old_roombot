<?php
/* @var $this MobilepicturesController */
/* @var $model Mobilepictures */

$this->breadcrumbs=array(
	'Mobilepictures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mobilepictures', 'url'=>array('index')),
	array('label'=>'Manage Mobilepictures', 'url'=>array('admin')),
);
?>

<h1>Create Mobilepictures</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>