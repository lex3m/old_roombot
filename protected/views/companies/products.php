<div class="span-17">
<?php $this->widget('CabinetHeader', array('url_ID'=>$member->urlID));
 ?>
 <div class="span-17 last">
        Товары
        <?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('добавить товар',array('products/add')); ?> 
   </div>
   <div class="span-17 last">
  <?php 

 $this->widget('zii.widgets.CListView', array('viewData' => array( 'member' => $member),'dataProvider'=>$dataProvider,'itemView'=>'_productsrow','ajaxUpdate'=>false)); 
  ?>
  </div>
</div>
 <div  class="span-1 last">
<?php $this->widget('CompanyControlPanel', array('id'=>$member->urlID));
 ?>
</div>
<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'a.grouped_elements',
    'config'=>array(),
    )
); 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'confirm_delete_product',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
        'closeOnEscape'=> 'true',
        'width'=>'400',
        'show'=>'show',
    ), 
)); echo 'Вы точно хотите удалить этот товар?<br>';
 echo CHtml::button('Да', array('id'=>'yes_confirm_delete_product')); 
 echo CHtml::button('Нет', array('id'=>'no_confirm_delete_product'));  
$this->endWidget('zii.widgets.jui.CJuiDialog');



Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/companiesEdit.js");
?>