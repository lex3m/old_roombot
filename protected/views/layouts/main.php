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

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.17475.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquerypp.custom.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.elastislide.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/search.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lightbox-2.6.min.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lightbox.css" rel="stylesheet" />
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
                             <img style="padding-left: 5px;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_r.png"  width="120" height="44" alt="<?php echo Yii::t('mainLayout', 'on main'); ?>" title="<?php echo Yii::app()->name;?>" />
                         </a>
                 </h1>
                         <nav class="left header__navWrapper" role="navigation"> <ul class="header__navMenu header__mainMenu left">
                         <li>
                             <a class="to_bookmarks" style="cursor: pointer;">
                                 В закладки!
                             </a>
                         </li>
                         <!--<li>
                         <a href="<?php if(Yii::app()->user->isGuest) echo Yii::app()->getHomeUrl(); else echo $this->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)); ?>" class="header__mainMenu-home" title="Home">Главная
                         </a>
                         </li>-->
                         <li class="header__explore-wrapper"><a href="<?php echo Yii::app()->createUrl('site/photos');?>" class="header__mainMenu-explore"><?php echo Yii::t('mainLayout', 'Photos'); ?></a>
                         </li>
                         </ul> </nav>
                         <div class="headerSearch left" role="search">
                             <form class="quicksearch rb-border-box">
                                 <input class="quicksearch__input input g-all-transitions-300" placeholder="<?php echo Yii::t('mainLayout', 'Search'); ?>" type="search" name="q" autocomplete="off" aria-label="Search" aria-autocomplete="list" aria-owns="searchMenuList">
                                <button class="quicksearch__submit submit" type="submit"><?php echo Yii::t('mainLayout', 'Search'); ?></button>
                            </form>
                         </div>
             </div>
             <div class="header__right right">
                 <div  id="language-selector" style="float:left; margin:5px;">
                     <?php
                        $this->widget('LanguageSelector');
                     ?>
                 </div>
                 <div class="header__applink">
                     <a class="" target="_blank" href="https://play.google.com/store/apps/details?id=com.astam.roombot">
                         <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app.png"  width="40" height="40" alt="Google play" title="Google play" />
                    </a>
                 </div>
                 <div class="header__loginMenu left">
                     <?php echo CHtml::link(Yii::t('mainLayout', 'Instruction'), array('site/instruction'),array('class'=>'header__login')); ?>
                     <?php if(Yii::app()->user->isGuest)
                         echo CHtml::link(Yii::t('mainLayout', 'Log in'),array('site/login'),array('class'=>'header__login'));
                     else
                         echo CHtml::link(Yii::t('mainLayout', 'Log out'),array('site/logout'),array('class'=>'header__login'));
                     ?>
                     <?php if(Yii::app()->user->isGuest) : ?><?php echo Yii::t('mainLayout', 'or'); ?>  <?php endif; ?>
                     <button
                     <?php if(Yii::app()->user->isGuest) { ?>
                         onclick="window.location.href = '<?php echo  Yii::app()->createUrl('companies/register'); ?>';"
                     <?php } else { ?>
                         onclick="window.location.href = '<?php echo  Yii::app()->createUrl('member/dashboard',array('id'=>Yii::app()->user->urlID)); ?>';"
                     <?php } ?>
                         style="margin-left:15px;" class="rb-button rb-button-medium signupButton rb-button-cta" title="<?php echo Yii::t('mainLayout', 'Sign up');?>" tabindex="0">
                         <?php if(Yii::app()->user->isGuest) { echo Yii::t('mainLayout', 'Sign up'); } else { echo Yii::t('mainLayout', 'Dashboard');  } ?>
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
             <span><?php echo Yii::t('mainLayout', 'Developed by'); ?> <a href="http://topsu.ru/" target="_blank">"Вершина успеха"</a> <?php echo date('Y'); ?> </span>
    </div>
</div><!-- #footer -->

<?php  if (($this->uniqueid==='site')&&($this->action->Id==='index')): ?>
<div class="gallery">
                   <?php
                    $criteria = new CDbCriteria();
//                    $criteria->condition = 'moderation=:moderation';
                    $criteria->params = array(':moderation'=>1);
                    $criteria->order ='id DESC';
                    $criteria->limit =20;
                    $photos=Mobilepictures::model()->findAll($criteria);?>
                    <ul id="carousel" class="elastislide-list">
                        <?php     
                        foreach ($photos as $photo)
                            echo '<li data-preview="'.Yii::app()->request->baseUrl.'/images/mobile/images/'.$photo->image.'">
                                    <a target="_blank" href="'.Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$photo->id)).'" ><img src="'.Yii::app()->request->baseUrl.'/images/mobile/images/'.$photo->image.'" alt="image" /></a>
                                  </li>' . "\n \t";
                       ?>
                    </ul>
</div>
<?php
Yii::app()->clientScript->registerScript('slider',"
        $( '#carousel' ).elastislide( {
            minItems : 5
        } );
");
?>
<?php endif; ?>
                
            </div>
        </div>



<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>

/*(function(){
    var widget_id = '96364';
    var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);
})();*/

</script>
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
$('.to_bookmarks').on('click', function( e ) {
    if (!window.location.origin)
        window.location.origin = window.location.protocol+\"//\"+window.location.host;

    var bookmarkUrl =  window.location.origin;
    var bookmarkTitle = document.title;

    if (window.sidebar &&  window.sidebar.addPanel) { // For Mozilla Firefox Bookmark
        window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,'');
        alert('Успешно добавлено');
    } else if( window.external && window.external.AddFavorite) { // For IE Favorite
        window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
        alert('Успешно добавлено');
    } else if(window.opera) { // For Opera Browsers
        $('a.to_bookmarks').attr('href',bookmarkUrl);
        $('a.to_bookmarks').attr('title',bookmarkTitle);
        $('a.to_bookmarks').attr('rel', 'sidebar');
        alert('Успешно добавлено');
    } else { // for other browsers which does not support
        if (navigator.userAgent.toLowerCase().indexOf('opr') > -1) {
            alert(\"Эта функция не доступна в Opera. Нажмите на символ звездочки в конце строки url-адреса текущей вкладки или нажмите Ctrl-D (Command+D для Mac) чтобы создать закладку.\");
        } else if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            alert(\"Эта функция не доступна в Mozilla Firefox. Нажмите на символ звездочки в конце строки url-адреса текущей вкладки или нажмите Ctrl-D (Command+D для Mac) чтобы создать закладку.\");
        } else if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
            alert(\"Эта функция не доступна в Google Chrome. Нажмите на символ звездочки в конце строки url-адреса текущей вкладки или нажмите Ctrl-D (Command+D для Mac) чтобы создать закладку.\");
        } else {
            alert(\"Эта функция не доступна для Вашего браузера. Пожалуйста, Добавьте наш сайт в закладки вручную.\");
        }
        return false;
    }
});
",CClientScript::POS_READY);
?>
</body>

</html>