   <div class="span-6"> 
    <h1><?php echo $model->name; ?></h1>
   </div>
   <div class="span-6"> 
    <h1><?php if (count($phones)>0) echo $phones[0]->phone; ?></h1>
   </div>
   <div class="span-4 last"> 
    <?php echo CHtml::link('Сделать заказ',array('controller/action')); ?>
   </div>
   <div class="span-17 last">
    <?php
     foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
     }
        ?>
    </div>
