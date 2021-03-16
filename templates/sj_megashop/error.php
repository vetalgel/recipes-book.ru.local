<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}

//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>

<html  lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="HandheldFriendly" content="true">

	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/css/error.css" type="text/css" />
</head>
<body>
	<div class="wrapall">
		<div class="wrap-inner">
			<div class="contener">
				<div class="block-main">
					<img class="bg404" src="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/images/404/bg404.jpg" alt="">
					<div class="first-block">
						<a class="logo" href="index.php">
							<img  src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate();?>/images/styling/green/logo.png" alt="" />
						</a>
						<div class="title404">404</div>
						<div class="mess-code"><?php echo $this->error->getMessage(); ?></div>
						<div class="mess-code1"><?php echo JText::_('JERROR_404_1'); ?></div>
						<div class="mess-code2"><?php echo JText::_('JERROR_404_2'); ?></div>
					</div>
					<div class="second-block">
						<p class="nav-button">
							<a class="button bt1" href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
								<?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?>
							</a>
							<a class="button bt2" href="javascript: history.go(-1)" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
								<?php echo JText::_('JERROR_LAYOUT_404_GOBACK'); ?>
							</a>
						</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
