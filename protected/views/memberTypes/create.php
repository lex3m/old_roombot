<?php
/* @var $this MemberTypesController */
/* @var $model MemberTypes */

$this->breadcrumbs=array(
	'Member Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MemberTypes', 'url'=>array('index')),
	array('label'=>'Manage MemberTypes', 'url'=>array('admin')),
);
?>

<h1>Create MemberTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>