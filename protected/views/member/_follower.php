<?php
/* @var $this MemberController */
/* @var $data Member */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Пользователь')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->members->login), array('member/dashboard', 'id'=>$data->members->urlID)); ?>
	<br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('Последние комментарии'));  ?>:</b>

    <?php $i = 0;
        foreach($data->members->comments as $comment) {
            echo $comment->content. "<br>";
            $i++;
            if ($i == 5) break;
        } ?>


</div>