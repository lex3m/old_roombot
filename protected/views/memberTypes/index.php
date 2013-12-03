<?php
/* @var $this MemberTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Member Types',
);

$this->menu=array(
	array('label'=>'Create MemberTypes', 'url'=>array('create')),
	array('label'=>'Manage MemberTypes', 'url'=>array('admin')),
);
?>

<h1>Member Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
