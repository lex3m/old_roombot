<h1>Информация изображения</h1>
<?php echo $model->name; ?><br><br>
<?php echo $model->info; ?><br><br>
<?php echo $model->date; ?><br><br> 
Теги:<br>
<?php
foreach ($tags as $tag)
    {
        echo $tag->name.'<br>';
    }