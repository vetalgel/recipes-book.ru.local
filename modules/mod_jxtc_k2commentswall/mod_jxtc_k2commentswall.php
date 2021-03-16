<?php
/*
	JoomlaXTC K2 Comments Wall

	version 1.8.0

	Copyright (C) 2008-2012 Monev Software LLC.	All Rights Reserved.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	THIS LICENSE IS NOT EXTENSIVE TO ACCOMPANYING FILES UNLESS NOTED.

	See COPYRIGHT.txt for more information.
	See LICENSE.txt for more information.

	Monev Software LLC
	www.joomlaxtc.com
*/

defined( '_JEXEC' ) or die;

jimport( 'joomla.html.parameter' );


require_once( dirname(__FILE__).'/helper.php' );

jimport('joomla.html.parameter');
require_once JPATH_SITE.'/components/com_k2/helpers/route.php';

$live_site = JURI::base();
$doc = JFactory::getDocument();
$db = JFactory::getDBO();
$contentconfig = JComponentHelper::getParams( 'com_content' );
$moduleDir = 'mod_jxtc_k2commentswall';

$db->setQuery("SELECT id from #__menu WHERE link like '%index.php?option=com_k2%' and published='1'");
$Itemid = $db->loadResult();if ($Itemid) { $Itemid = '&Itemid='.$Itemid; }

$userid = $params->get('userid');
$filtertags = $params->get('filtertags','');
$sortorder = $params->get( 'sortorder', 0 );

$compat = $params->get('compat');
$avatarw = $params->get('avatarw',30); if ($avatarw) {$avatarw = 'width="'.$avatarw.'"'; }
$avatarh = $params->get('avatarh',30); if ($avatarh) {$avatarh = 'height="'.$avatarh.'"'; }

$columns = $params->get('columns',1);
$rows	= $params->get('rows', 1);
$pages = $params->get('pages', 1);

	$moreclone = $params->get('moreclone', 0);
	$moreqty = $params->get('moreqty', 0);
	$morecols	= trim( $params->get('morecols',1));
	$morelegend	= trim($params->get('moretext', ''));
	$morelegendcolor	= $params->get('morergb','cccccc');
	$moretemplate	= $params->get('moretemplate', '');

$template	= $params->get('template','');
$moduletemplate	= trim( $params->get('moduletemplate','{mainarea}'));
$itemtemplate	= trim( $params->get('itemtemplate','{title}'));
if ($template && $template != -1) {
	$moduletemplate=file_get_contents(JPATH_ROOT.'/modules/'.$moduleDir.'/templates/'.$template.'/module.html');
	$itemtemplate=file_get_contents(JPATH_ROOT.'/modules/'.$moduleDir.'/templates/'.$template.'/element.html');
	$moretemplate=file_get_contents(JPATH_ROOT.'/modules/'.$moduleDir.'/templates/'.$template.'/more.html');
	if (file_exists(JPATH_ROOT.'/modules/'.$moduleDir.'/templates/'.$template.'/template.css')) {
		$doc->addStyleSheet($live_site.'modules/'.$moduleDir.'/templates/'.$template.'/template.css','text/css');
	}
}

$maxlength	= $params->get('maxlength', 0);
$dateformat	= trim( $params->get('dateformat','Y-m-d' ));

$limit = $columns*$rows*$pages;
$limit += $moreqty;

$items = mod_jxtc_k2commentswallHelper::getData( $userid, $sortorder, $filtertags, $limit );


if (count($items) == 0) {
	echo JText::_('No comments found.');
	return;
}

require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));

$items = $params->get('moreclone', 0)
	? array_slice($items,0,$moreqty)
	: array_slice($items,($columns * $rows * $pages),$moreqty);

require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default').'_more');

JPluginHelper::importPlugin('content');
$contentconfig = JComponentHelper::getParams('com_content');
$dispatcher = JDispatcher::getInstance();
$item = new stdClass();
$item->text = $modulehtml;
$results = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$contentconfig, 0 ));
$modulehtml = $item->text;
echo '<div id="'.$jxtc.'">'.$modulehtml.'</div>';

