<?php
defined('_JEXEC') or die;

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$document = $this;

// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;

Artx::load("Artx_Page");

// Initialize $view:
$view = $this->artx = new ArtxPage($this);

// Decorate component with Artisteer style:
$view->componentWrapper();

JHtml::_('behavior.framework', true);

?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $document->language; ?>">
<head>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" />

    <!-- Created by Artisteer v4.0.0.58475 -->
    
    
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.responsive.css" media="all">


    <script>if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
    <script src="<?php echo $templateUrl; ?>/jquery.js"></script>
    <script>jQuery.noConflict();</script>

    <script src="<?php echo $templateUrl; ?>/script.js"></script>
    <script>if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
    <script src="<?php echo $templateUrl; ?>/script.responsive.js"></script>
</head>
<body>

<div id="gazmain">
    <div class="gazsheet clearfix">
<header class="gazheader clearfix"><?php echo $view->position('header', 'gaznostyle'); ?>


    <div class="gazshapes">

<div class="gaztextblock gazobject21079369" data-left="100%">
        <div class="gazobject21079369-text">ТОВ "Галузеве підприємство "Промсервіс"<br><br>Адрес: 40030, Україна, м. Суми,<br>вул. О. Береста, 13<br><br>тел.: +38-050-407-27-79<br>&nbsp; &nbsp; &nbsp; &nbsp; +38-0542-77-17-47</div>
    
</div><div class="gaztextblock gazobject2134721586" data-left="35.61%">
        <div class="gazobject2134721586-text"><span style="color: rgb(255, 255, 255); font-family: Arial, 'Arial Unicode MS', Helvetica, sans-serif; font-size: 24px; font-weight: bold; line-height: 24px; white-space: nowrap; "><a href="#" contenteditable="true" id="headline" style="line-height: 28px; text-decoration: none; color: rgb(255, 255, 255); outline-color: rgb(100, 100, 100); cursor: text; ">Постачання природного газу<br>за нерегульованим тарифом</a></span></div>
    
</div>
            </div>

<?php if ($view->containsModules('user3', 'extra1', 'extra2')) : ?>
<nav class="gaznav clearfix">
    
<?php if ($view->containsModules('extra1')) : ?>
<div class="gazhmenu-extra1"><?php echo $view->position('extra1'); ?></div>
<?php endif; ?>
<?php if ($view->containsModules('extra2')) : ?>
<div class="gazhmenu-extra2"><?php echo $view->position('extra2'); ?></div>
<?php endif; ?>
<?php echo $view->position('user3'); ?>
 
    </nav>
<?php endif; ?>

                    
</header>
<?php echo $view->position('banner1', 'gaznostyle'); ?>
<?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'gazblock'); ?>
<div class="gazlayout-wrapper clearfix">
                <div class="gazcontent-layout">
                    <div class="gazcontent-layout-row">
                        <?php if ($view->containsModules('left')) : ?>
<div class="gazlayout-cell gazsidebar1 clearfix">
<?php echo $view->position('left', 'gazblock'); ?>




                        </div>
<?php endif; ?>
                        <div class="gazlayout-cell gazcontent clearfix">
<?php
  echo $view->position('banner2', 'gaznostyle');
  if ($view->containsModules('breadcrumb'))
    echo artxPost($view->position('breadcrumb'));
  echo $view->positions(array('user1' => 50, 'user2' => 50), 'gazarticle');
  echo $view->position('banner3', 'gaznostyle');
  echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' gazmessages'));
  echo '<jdoc:include type="component" />';
  echo $view->position('banner4', 'gaznostyle');
  echo $view->positions(array('user4' => 50, 'user5' => 50), 'gazarticle');
  echo $view->position('banner5', 'gaznostyle');
?>



                        </div>
                    </div>
                </div>
            </div>
<?php echo $view->positions(array('bottom1' => 33, 'bottom2' => 33, 'bottom3' => 34), 'gazblock'); ?>
<?php echo $view->position('banner6', 'gaznostyle'); ?>

<footer class="gazfooter clearfix"><?php echo $view->position('copyright', 'gaznostyle'); ?></footer>

    </div>
    <p class="gazpage-footer">
        <span id="gazfootnote-links">Designed by <a href="http://topsu.ru/" target="_blank">topsu.ru</a>.</span>
    </p>
</div>



<?php echo $view->position('debug'); ?>
</body>
</html>