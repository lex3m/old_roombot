<?php
/* @var $this KindUsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kind Users',
);

$this->menu=array(
	array('label'=>'Create KindUsers', 'url'=>array('create')),
	array('label'=>'Manage KindUsers', 'url'=>array('admin')),
);
?>

<h1>Kind Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
