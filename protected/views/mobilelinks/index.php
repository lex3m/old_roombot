<?php
/* @var $this MobilelinksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mobilelinks',
);

$this->menu=array(
	array('label'=>'Create Mobilelinks', 'url'=>array('create')),
	array('label'=>'Manage Mobilelinks', 'url'=>array('admin')),
);
?>

<h1>Mobilelinks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
