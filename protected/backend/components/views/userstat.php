<h1>Посещения пользователей</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$users,
    'columns' => array(
        array(
            'name' => 'IP',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->ip)'
        ),
        array(
            'name' => 'Дата',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->date)',
        ),
        array(
            'name' => 'Страна',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->date)',
        ),
    ),
));
?>