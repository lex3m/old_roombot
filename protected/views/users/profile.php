<?php $this->widget('UserControlPanel', array(
    'id' => 'searchSidebar')); ?>
<h1>Мой профайл</h1>


<div class="form">
 
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-info-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($userInfo); ?>

	<div class="row">
		<?php echo $form->labelEx($userInfo,'surname'); ?>
		<?php echo $form->textField($userInfo,'surname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($userInfo,'surname'); ?>
	</div>

	
	<div class="row">
	<?php echo $form->labelEx($userInfo,'country_id'); 
         $regions = CHtml::listData(Countries::model()->findAll(array('order' => 'id')), 'id', 'name');
         $city = Cities::model()->find('id=:id', array(':id'=>$userInfo->city)); 
         if (!isset($city))
	      $options_array = array();
         else {
	      $options_array = array($city->countryID =>array('selected'=>true));
         }
         ?>
        <?php echo $form->DropDownList($userInfo,'country_id', $regions, array('prompt'=>'Выберите страну',
                'ajax'=>array(
                'type'=>'POST',
                'url'=>CController::createUrl('countries/Dynamiccities'), //'currentController/dynamiccities'
                'update'=>'#UserInfo_city',          
        ),

        'options' => $options_array )); ?>        
        <?php   
        echo $form->error($userInfo,'country_id');  
        ?> 
        </div>
        
         
	<div class="row">
		<?php echo $form->labelEx($userInfo,'city'); ?>  
	        <?php echo $form->DropDownList($userInfo,'city', array('prompt'=>'Выберите город'), array('options' => array('2'=>array('selected'=>true))));  ?>  
	        <?php echo $form->error($userInfo,'city'); ?>  
	</div>    

	

	<div class="row">
	<?php echo $form->labelEx($userInfo,'dateBirth'); ?>
	<?php
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	    'model' => $userInfo,
	    'attribute' => 'dateBirth',
	    'htmlOptions' => array(
		'size' => '10',         // textField size
		'maxlength' => '10',    // textField maxlength
	    ),
	    'options' => array(            // also opens with a button
	      'dateFormat' => 'yy-mm-dd',     // format of "2012-12-25"
	    ),
	)); 
	?>
	<?php echo $form->error($userInfo,'dateBirth'); ?>  
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?> 
	</div>

<?php $this->endWidget(); ?>

</div>


<?php  
    Yii::app()->clientScript->registerScript('changeCityAfterRefreshPage','
		  $.ajax({
		  type : "POST",
		  data: $("#user-info-form").serialize(), 
		  url : "'.CController::createUrl('countries/Dynamiccities').'",
		  success : function(data, statusText){
		      
		      if ('.$userInfo->city.'>0)
		      {
			  $("#UserInfo_city").empty().append(data);
			  $("#UserInfo_city [value='.$userInfo->city.']").attr("selected", "selected");
		      }  
		  },  
	      });
    ',CClientScript::POS_READY); 
?>
