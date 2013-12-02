<div class="span-17 last">
<div class="span-17 last" id="<?php echo $data->urlID; ?>"> <strong>
<?php echo CHtml::link(CHtml::encode($data->fullName),array('consultants/view','id'=>$data->urlID)); ?></strong>     
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Редактировать',array('consultants/edit','id'=>$data->urlID));
?>    
<?php 
if ($data->block==0) $block_name_action = 'Заблокировать'; else $block_name_action = 'Разблокировать';
if ($member->id==Yii::app()->user->getId()) echo CHtml::link($block_name_action,array('consultants/block'),array('id'=>'block_consultant','target'=>$data->urlID,'title
'=>$data->fullName)); ?> 
<?php if ($member->id==Yii::app()->user->getId()) echo CHtml::link('Удалить',array('consultants/delete'),array('id'=>'delete_consultant','target'=>$data->urlID,'title
'=>$data->fullName)); ?>  
</div> 
<br><br>
Компания:  <?php $company=Companies::model()->findByPk($data->companyID);
echo $company->name;?>  
<br><br>
Рубрики:  <br><?php foreach ($data->subbrancheslinks as $subbranch)
            {
                $subbranchName = KindBranches::model()->findbyPk($subbranch->kindBranchID);
                echo $subbranchName->name.'<br>';
            }
               ?>
<br><br>
</div>
<br><br>