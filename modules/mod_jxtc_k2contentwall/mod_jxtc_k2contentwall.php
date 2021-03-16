<?php
/*
	JoomlaXTC K2 Content Wall

	version 1.25.3

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


//Core calls
$live_site = JURI::base();
$doc = JFactory::getDocument();
$contentconfig = JComponentHelper::getParams( 'com_content' );
$moduleDir = 'mod_jxtc_k2contentwall';
$db = JFactory::getDBO();

// Include the syndicate functions only once
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.html.parameter');
require_once 'helper.php' ;
require_once JPATH_SITE.'/components/com_k2/helpers/route.php';
require_once JPATH_SITE.'/components/com_k2/helpers/utilities.php';
require_once (JPATH_SITE.'/components/com_k2/models/itemlist.php');
require_once (JPATH_SITE.'/components/com_k2/models/item.php');

//Core Vars
$envcatid = JRequest::getInt('catid');
$envid = JRequest::getInt('id');
$envview = JRequest::getVar('view');
$nullDate	= $db->getNullDate();
$date = JFactory::getDate();
$now = $date->toSQL();


//Parameters
$tag_id = $params->get('tag_id', 0);
$cattwetttext = $params->get('cattwittext', 'Like this? Tweet it to your followers!');
$twetttext = $params->get('twittext', 'Like this? Tweet it to your followers!');
$related = $params->get('related', 1);
$numvotes = $params->get('numvotes', 0);
$catid = $params->get('category_id');
$childen = $params->get('getChildren');
$usecurrentcat = $params->get('usecurrentcat',1);
$compat = $params->get('compat');
$comcompat = $params->get('comcompat');
$authorid = (array) $params->get( 'authorid', 0 );
$group	= $params->get('group', 0);
$sortfield = $params->get('sortfield', 0);
$sortorder = $params->get('sortorder', 1);
$featured = $params->get('featured', 1);
$forced = $params->get('forced');

$template	= $params->get('template','');
$moduletemplate = trim( $params->get('modulehtml','{mainarea}'));
$itemtemplate = trim( $params->get('html','{intro}'));
$columns = $params->get('columns',1);
$rows	= $params->get('rows', 1);
$pages = $params->get('pages', 1);
$dateformat	= trim( $params->get('dateformat','Y-m-d' ));
$morepos = $params->get('morepos', 'b');
$moreqty = $params->get('moreqty', 0);
$morecols	= trim( $params->get('morecols',1));
$morelegend	= trim($params->get('moretext', ''));
$morelegendcolor	= $params->get('morergb','cccccc');
$moretemplate	= $params->get('morehtml', '{title}');
if ($template && $template != -1) {
    $moduletemplate=file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_k2contentwall/templates/'.$template.'/module.html');
    $itemtemplate=file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_k2contentwall/templates/'.$template.'/element.html');
    $moretemplate=file_get_contents(JPATH_ROOT.'/modules/mod_jxtc_k2contentwall/templates/'.$template.'/more.html');

    if (file_exists(JPATH_ROOT.'/modules/mod_jxtc_k2contentwall/templates/'.$template.'/template.css')) {
        $doc->addStyleSheet($live_site.'modules/mod_jxtc_k2contentwall/templates/'.$template.'/template.css','text/css');
    }
}

// Build Query

if ($usecurrentcat == 1) {
    if ($envview == 'category' && $envid > 0) {
        $catid = $envid;
    }
    elseif (!empty($envcatid)) {
        $catid = $envcatid;
    }
}

$mainqty = $columns*$rows*$pages;
$varaux = $mainqty + $moreqty;

if(!is_array($catid)){$catid = array($catid);}

if($catid[0] != 0){
    if($childen){
        $child = array();
				$auxModel = new K2ModelItemlist();
        foreach ($catid as $id) {
            $aux = $auxModel->getCategoryTree($id);
            $aux[] = $id;
            $aux = array_unique($aux);
            $child = array_merge($child, $aux);
        }
        $catid = array_unique($child);
    }
}

$items = mod_jxtc_k2contentwallHelper::getData( $catid, $authorid, $group, $varaux, $sortfield, $sortorder, $featured, $tag_id, $forced);

if (count($items) == 0) return;// Return if empty

// Check for RL support
$enablerl = false;
if (stripos($itemtemplate,'{readinglist}')!==false || stripos($moretemplate,'{readinglist}')!==false) {
	jimport( 'joomla.plugin.helper' );
	$enablerl = JpluginHelper::isEnabled('content','jxtcreadinglistk2');
}

// Main Area
$rowmaxtitle	= $params->get('maxtitle');
$rowmaxtitlesuf	= $params->get('maxtitlesuf','...');
$rowmaxintro	= $params->get('maxintro');
$rowmaxintrosuf	= $params->get('maxintrosuf','...');
$rowmaxtext	= $params->get('maxtext');
$rowmaxtextsuf	= $params->get('maxtextsuf','...');
$rowtextbrk	= $params->get('textbrk');
require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));

// More Area
$rowmaxtitle	= $params->get('moretitle');
$rowmaxtitlesuf	= $params->get('moretitlesuf','...');
$rowmaxintro	= $params->get('moreintro');
$rowmaxintrosuf	= $params->get('moreintrosuf','...');
$rowmaxtext	= $params->get('moremaxtext');
$rowmaxtextsuf	= $params->get('moremaxtextsuf','...');
$rowtextbrk	= $params->get('moretextbrk', '');

$items = $params->get('moreclone', 0)
	? array_slice($items,0,$moreqty)
	: array_slice($items,($columns * $rows * $pages),$moreqty);

require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default').'_more');

// Content Plugins
JPluginHelper::importPlugin('content');
JPluginHelper::importPlugin('k2');

$dispatcher = JDispatcher::getInstance();
$contentconfig = JComponentHelper::getParams('com_content');
$k2config = K2HelperUtilities::getParams('com_k2');
$item = new stdClass();
$item->text = $modulehtml;
$results = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$contentconfig, 0 ));
$results = $dispatcher->trigger('onK2PrepareContent', array(&$item,&$contentconfig, 0 ));
$modulehtml = $item->text;

echo '<div id="'.$jxtc.'">'.$modulehtml.'</div>';
