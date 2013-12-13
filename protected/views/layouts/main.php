<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

<!--    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.17475.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquerypp.custom.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.elastislide.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/elastislide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" media="screen, projection" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name='yandex-verification' content='67582c7237df5aff' />  
</head>

<body>
 
<div id="wrapper">
   <!-- <div class="ipad">-->
         <div class="header fixed v-dark v-z-index-header sc-border-box">
             <div class="header__left left">
                 <h1 class="header__logo left">
                          <a class="header__logo" href="<?php if(Yii::app()->user->isGuest) echo Yii::app()->getHomeUrl(); else echo $this->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)); ?>">
                             <img style="padding-left: 5px;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_r.png"  width="120" height="44" alt="На главную" title="Roombot" />
                         </a>

                 </h1>
                         <nav class="left header__navWrapper" role="navigation"> <ul class="header__navMenu header__mainMenu left">
                         <!--<li>
                         <a href="<?php if(Yii::app()->user->isGuest) echo Yii::app()->getHomeUrl(); else echo $this->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)); ?>" class="header__mainMenu-home" title="Home">Главная
                         </a>
                         </li>-->
                         <li class="header__explore-wrapper"><a href="<?php echo Yii::app()->createUrl('site/photos');?>" class="header__mainMenu-explore">Фотографии</a>
                         </li>
                         </ul> </nav>
                         <div class="headerSearch left" role="search">
                             <form class="quicksearch rb-border-box">
                                 <input class="quicksearch__input input g-all-transitions-300" placeholder="Искать" type="search" name="q" autocomplete="off" aria-label="Search" aria-autocomplete="list" aria-owns="searchMenuList">
                                <button class="quicksearch__submit submit" type="submit">Искать</button>
                            </form>
                         </div>
             </div>
             <div class="header__right right">
                 <div class="header__applink">
                     <a class="" target="_blank" href="https://play.google.com/store/apps/details?id=com.platon.roombot&hl=ru">
                         <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app.png"  width="40" height="40" alt="Google play" title="Google play" />
                    </a>
                 </div>
                 <div class="header__loginMenu left">
                     <?php echo CHtml::link('Инструкция',array('site/instruction'),array('class'=>'header__login')); ?>
                     <?php if(Yii::app()->user->isGuest)
                         echo CHtml::link('Войти',array('site/login'),array('class'=>'header__login'));
                     else
                         echo CHtml::link('Выйти',array('site/logout'),array('class'=>'header__login'));
                     ?>
                     <?php if(Yii::app()->user->isGuest) : ?> или <?php endif; ?>
                     <button
                     <?php if(Yii::app()->user->isGuest) { ?>
                         onclick="window.location.href = '<?php echo  Yii::app()->createUrl('companies/register'); ?>';"
                     <?php } else { ?>
                         onclick="window.location.href = '<?php echo  Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)); ?>';"
                     <?php } ?>
                         style="margin-left:15px;" class="rb-button rb-button-medium signupButton rb-button-cta" title="Зарегистрироваться" tabindex="0">
                         <?php if(Yii::app()->user->isGuest) { echo 'Зарегистрироваться'; } else { echo 'Мой кабинет';  } ?>
                     </button>
                 </div>

             </div>
         </div>

         <div id="tags-menu">
             <?php $this->widget('TagMenu',array(
                    'lastItemCssClass'=>'moreItems',
                    'items'=> Mobiletags::model()->getMenuList(),
                    'htmlOptions'=>array('class'=>'tags-menu1'),

             ));
             ?>
         </div>
         <?php
              //Yii::app()->clientScript->registerScript("tag-menu", " $('#tags-menu ul').menu();", CClientScript::POS_LOAD);
         ?>
        <?php echo $content; ?>

    <!-- </div>--><!-- .ipad-->
</div><!-- #wrapper -->
 


<div id="footer">
    <div class="copirayt">
             <span>Разработка приложения от студии <a href="http://topsu.ru/" target="_blank">"Вершина Успеха"</a> 2013 г.</span>
    </div>
</div><!-- #footer -->


<?php  if (($this->uniqueid==='site')&&($this->action->Id==='index')): ?>
<div class="gallery">
                   <?php
                    $criteria = new CDbCriteria();
                    $criteria->condition = 'moderation=:moderation';
                    $criteria->params = array(':moderation'=>1);
                    $criteria->order ='id DESC';
                    $criteria->limit =20;
                    $photos=Mobilepictures::model()->findAll($criteria);?>
                    <ul id="carousel" class="elastislide-list">
                        <?php     
                        foreach ($photos as $photo)
                            echo '<li data-preview="'.Yii::app()->request->baseUrl.'/images/mobile/images/'.$photo->image.'">
                                    <a href=""><img src="'.Yii::app()->request->baseUrl.'/images/mobile/images/'.$photo->image.'" alt="image" /></a>
                                  </li>' . "\n \t";
                       ?>
                    </ul>
</div>
<?php
Yii::app()->clientScript->registerScript('slider',"
        $( '#carousel' ).elastislide( {
            minItems : 5
        } );

        $('#carousel li a').click(function(){
            return false;
        })
");
?>
<?php endif; ?>
                
            </div>
        </div>
        
      

        <!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>

(function(){ var widget_id = '96364';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->  
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45541039-1', 'roombot.com.ua');
  ga('send', 'pageview');

</script>
<?php
Yii::app()->clientScript->registerScript('search',"
$('button.quicksearch__submit').on('click',function(){
      var query = $('input.quicksearch__input').val();
      var baseUrl = '".Yii::app()->createUrl('site/photos',array('q'=>'_query_'))."';
      if (query!='')
        {
            var url = baseUrl.replace('_query_', query);
            location.href = url;
            return false;
        }
});
",CClientScript::POS_READY);
?>
</body>


</html>