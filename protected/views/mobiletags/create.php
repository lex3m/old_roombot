<?php
/* @var $this MobiletagsController */
/* @var $model Mobiletags */

$this->breadcrumbs=array(
	'Mobiletags'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mobiletags', 'url'=>array('index')),
	array('label'=>'Manage Mobiletags', 'url'=>array('admin')),
);
?>

<h1>Create Mobiletags</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>