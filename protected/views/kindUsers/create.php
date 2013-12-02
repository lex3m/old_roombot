<?php
/* @var $this KindUsersController */
/* @var $model KindUsers */

$this->breadcrumbs=array(
	'Kind Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List KindUsers', 'url'=>array('index')),
	array('label'=>'Manage KindUsers', 'url'=>array('admin')),
);
?>

<h1>Create KindUsers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>