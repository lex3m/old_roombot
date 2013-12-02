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
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Cabin|Electrolize|Cuprum&amp;subset=latin">


    <script>if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
    <script src="<?php echo $templateUrl; ?>/jquery.js"></script>
    <script>jQuery.noConflict();</script>

    <script src="<?php echo $templateUrl; ?>/script.js"></script>
    <script>if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
    <script src="<?php echo $templateUrl; ?>/script.responsive.js"></script>
</head>
<body>

<div id="gaz-main">
<?php if ($view->containsModules('user3', 'extra1', 'extra2')) : ?>
<nav class="gaz-nav clearfix">
    <div class="gaz-nav-inner">
    
<?php if ($view->containsModules('extra1')) : ?>
<div class="gaz-hmenu-extra1"><?php echo $view->position('extra1'); ?></div>
<?php endif; ?>
<?php if ($view->containsModules('extra2')) : ?>
<div class="gaz-hmenu-extra2"><?php echo $view->position('extra2'); ?></div>
<?php endif; ?>
<?php echo $view->position('user3'); ?>
 
        </div>
    </nav>
<?php endif; ?>
<div class="gaz-sheet clearfix">
<header class="gaz-header clearfix"><?php echo $view->position('header', 'gaz-nostyle'); ?>
<div class="gaz-slider gaz-slidecontainerheader">
    <div class="gaz-slider-inner">
<div class="gaz-slide-item gaz-slideheader0">
<div class="gaz-textblock gaz-slideheader0-object137604871" data-left="50%">
        <div class="gaz-slideheader0-object137604871-text"><p style="color: #576775; font-size:38px;font-family:Lobster, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;font-weight:bold;font-style:normal;text-decoration:none;text-transform:uppercase">ПРОМСЕРВИС</p><p style="color: #364049; font-size:22px;font-family:Cabin, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;text-decoration:none;text-transform:uppercase">постачання газу</p></div>
    
</div>
</div>
<div class="gaz-slide-item gaz-slideheader1">
<div class="gaz-textblock gaz-slideheader1-object206700637" data-left="50%">
        <div class="gaz-slideheader1-object206700637-text"><p style="color: #476985; font-size:38px;font-family:Lobster, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;font-weight:bold;font-style:normal;text-decoration:none;text-transform:uppercase">Think Big</p><p style="color: #2D4253; font-size:22px;font-family:Cabin, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;text-decoration:none;text-transform:uppercase">Time To Change</p></div>
    
</div>
</div>
<div class="gaz-slide-item gaz-slideheader2">
<div class="gaz-textblock gaz-slideheader2-object1817741454" data-left="50%">
        <div class="gaz-slideheader2-object1817741454-text"><p style="color: #576775; font-size:38px;font-family:Lobster, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;font-weight:bold;font-style:normal;text-decoration:none;text-transform:uppercase">Development</p><p style="color: #364049; font-size:22px;font-family:Cabin, Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;text-decoration:none;text-transform:uppercase">Hello and Welcome.</p></div>
    
</div>
</div>

    </div>
</div>
<div class="gaz-slidenavigator gaz-slidenavigatorheader">
<a href="#" class="gaz-slidenavigatoritem"></a><a href="#" class="gaz-slidenavigatoritem"></a><a href="#" class="gaz-slidenavigatoritem"></a>
</div>



    <div class="gaz-shapes">


            </div>

                
                    
</header>
<?php echo $view->position('banner1', 'gaz-nostyle'); ?>
<?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'gaz-block'); ?>
<div class="gaz-layout-wrapper clearfix">
                <div class="gaz-content-layout">
                    <div class="gaz-content-layout-row">
                        <?php if ($view->containsModules('left')) : ?>
<div class="gaz-layout-cell gaz-sidebar1 clearfix">
<?php echo $view->position('left', 'gaz-block'); ?>




                        </div>
<?php endif; ?>
                        <div class="gaz-layout-cell gaz-content clearfix">
<?php
  echo $view->position('banner2', 'gaz-nostyle');
  if ($view->containsModules('breadcrumb'))
    echo artxPost($view->position('breadcrumb'));
  echo $view->positions(array('user1' => 50, 'user2' => 50), 'gaz-article');
  echo $view->position('banner3', 'gaz-nostyle');
  echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' gaz-messages'));
  echo '<jdoc:include type="component" />';
  echo $view->position('banner4', 'gaz-nostyle');
  echo $view->positions(array('user4' => 50, 'user5' => 50), 'gaz-article');
  echo $view->position('banner5', 'gaz-nostyle');
?>



                        </div>
                        <?php if ($view->containsModules('right')) : ?>
<div class="gaz-layout-cell gaz-sidebar2 clearfix">
<?php echo $view->position('right', 'gaz-block'); ?>


                        </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
<?php echo $view->positions(array('bottom1' => 33, 'bottom2' => 33, 'bottom3' => 34), 'gaz-block'); ?>
<?php echo $view->position('banner6', 'gaz-nostyle'); ?>

<footer class="gaz-footer clearfix"><?php echo $view->position('copyright', 'gaz-nostyle'); ?></footer>

    </div>
    <p class="gaz-page-footer">
        <span id="gaz-footnote-links">Designed by <a href="http://topsu.ru/" target="_blank">Создание сайтов</a>.</span>
    </p>
</div>



<?php echo $view->position('debug'); ?>
</body>
</html>