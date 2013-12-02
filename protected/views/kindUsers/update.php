<?php
/* @var $this KindUsersController */
/* @var $model KindUsers */

$this->breadcrumbs=array(
	'Kind Users'=>array('index'),
	$model->ID=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List KindUsers', 'url'=>array('index')),
	array('label'=>'Create KindUsers', 'url'=>array('create')),
	array('label'=>'View KindUsers', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage KindUsers', 'url'=>array('admin')),
);
?>

<h1>Update KindUsers <?php echo $model->ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>