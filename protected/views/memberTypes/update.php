<?php
/* @var $this MemberTypesController */
/* @var $model MemberTypes */

$this->breadcrumbs=array(
	'Member Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MemberTypes', 'url'=>array('index')),
	array('label'=>'Create MemberTypes', 'url'=>array('create')),
	array('label'=>'View MemberTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MemberTypes', 'url'=>array('admin')),
);
?>

<h1>Update MemberTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>