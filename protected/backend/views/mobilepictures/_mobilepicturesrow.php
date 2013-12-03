<?php if ($data->moderation==1)     
            $checkImage='checkepicture.png';
        else 
            $checkImage='uncheckepicture.png';
?>
<img style="float:left; padding-right:5px;" width="12px" height="12px" src="/images/site/<?php echo $checkImage; ?>"  />
<?php
echo '<span class=\'name_picture_id_'.$data->id.'\' name=\''.$data->id.'\' id=\'name_picture\'>'.$data->name.'</span>';
?>
<br>
<?php echo $data->date; ?>
<br>
<?php
echo '<div class="span-22 last" style="margin-bottom:10px;" id="company_photo" name="'.$data->id.'">';
echo '<a target="_blank" href="'.$this->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)).'"><img  width="100px" height="100px" style="margin-right: 25px; float:left" src="/images/mobile//images/'.$data->image.'"/></a>';
//echo CHtml::link('удалить',"#",array("submit"=>array('delete', 'id'=>$image->id), 'confirm' => 'Вы уверены?')); 
echo CHtml::link('<img style="float:left" width="12px" height="12px" src="/images/site/delete_icon.png"  />', array('delete'),array('id'=>'delete_picture','target'=>$data->id));
echo '<div class="span-7" style="margin-left:20px;">Теги:<br><br>';
echo '<div id="tags'.$data->id.'">';  
foreach ($data->taglinks as $m)  
{   $tag=Mobiletags::model()->findByPk($m->tagId);
    echo '<div id="taglinkk'.$m->id.'" style="margin-bottom:10px;">'.$tag->name;
    echo CHtml::link('<img id="'.$m->id.'" style="float:right" width="12px" height="12px" src="/images/site/delete_icon.png"  />', array('delete'),array('id'=>'delete_tag','target'=>$m->id));
    echo '</div>';
}
echo '</div>';
echo '</div>';
echo '<div class="span-7">';
echo '<a style="margin-left:50px;" name="new_tag" id="'.$data->id.'" href="#">Добавить теги</a>';
echo '</div>';
echo '</div>';
?>  
<br>
<br>