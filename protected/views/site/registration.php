
<div class="list-bot">
    <h1>Выберите тип регистрации</h1>
    <div class="ruka">
        <?php echo CHtml::link('Вы пользователь',array('users/register')); ?>
     </div>
     <div class="ruky">
        <?php echo CHtml::link('Вы компания или фотограф',array('companies/register')); ?>
     </div>
</div>