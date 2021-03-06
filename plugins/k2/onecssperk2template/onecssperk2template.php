<?php
/*------------------------------------------------------------------------

# plg_onecssperk2template - CSS4K2 K2 plugin

# ------------------------------------------------------------------------

# author    Jiliko.net

# copyright Copyright (C) 2010 Jiliko.net. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.jiliko.net

# Technical Support:  Forum - http://www.jiliko.net/forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JLoader::register('K2Plugin',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php');

class plgK2OneCssPerK2Template extends K2Plugin {

	// Some params
	var $pluginName = 'oneCssPerK2Template';
	var $pluginNameHumanReadable = 'One Css Per K2 Template';

	function plgK2OneCssPerK2Template(&$subject, $params) {
		parent::__construct($subject, $params);
	}
	
	function onK2PrepareContent( & $item, & $params, $limitstart) {
		global $mainframe;
	}

	function onK2AfterDisplay( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2BeforeDisplay( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2AfterDisplayTitle( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2BeforeDisplayContent( & $item, & $params, $limitstart) {
		global $mainframe;
		return '';
	}

	function onK2AfterDisplayContent( & $item, & $params, $limitstart) {
		global $mainframe;
		
		//We load the plugin parameters
		$plugin =& JPluginHelper::GetPlugin('k2', 'onecssperk2template');
		$pluginParams = new JParameter($plugin->params);
		
		// Call loadCss function if we're in the k2 item view
		$view=JRequest::getCmd('view');
		
		if ($pluginParams->get('multiCss',0))
			$this->loadCss($item->params);
		else
			$this->loadCss($params);
		
		return '';
	}

	function onK2CategoryDisplay( & $category, & $params, $limitstart) {
		global $mainframe;
		
		// Call loadCss function if we're in the k2 itemlist view
		$view=JRequest::getCmd('view');
		
		if($view == 'itemlist')
			$this->loadCss($params);
			
		return '';
	}

	function onK2UserDisplay( & $user, & $params, $limitstart) {
		global $mainframe;
		
		// Call loadCss function if we're in the k2 itemlist view
		$view=JRequest::getCmd('view');
		
		if($view == 'itemlist')
			$this->loadCss($params);
			
		return '';
	}

	function onK2SherpaSearchDisplay( & $search, & $params, $limitstart) {
		global $mainframe;
		
		$this->loadCss($params);
			
		return '';
	}
	
	function loadCss($params) {
		global $mainframe;
	
		jimport('joomla.filesystem.file');
		
		$theme = $params->get('theme','');
		
		if($theme == '')
			$theme = 'default';

		$doc = & JFactory::getDocument();

		//We add the css file to the head of the document.
		//Testing where to get the custom K2 template css
		if (JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_k2'.DS.$theme.DS.$theme.'_style.css'))
			$doc->addStyleSheet(JURI::base().'templates/'.$mainframe->getTemplate().'/html/com_k2/'.$theme.'/'.$theme.'_style.css');
		elseif (JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_k2'.DS.'templates'.DS.$theme.DS.$theme.'_style.css'))
			$doc->addStyleSheet(JURI::base().'templates/'.$mainframe->getTemplate().'/html/com_k2/templates/'.$theme.'/'.$theme.'_style.css');
		elseif (JFile::exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'templates'.DS.$theme.DS.$theme.'_style.css'))
			$doc->addStyleSheet(JURI::base().'components/com_k2/templates/'.$theme.'/'.$theme.'_style.css');
			
		//We load the plugin parameters
		$plugin =& JPluginHelper::GetPlugin('k2', 'onecssperk2template');
		$pluginParams = new JParameter($plugin->params);
	  
		//If we DON'T want to keep the k2 css loaded
		if(!$pluginParams->get('keepk2css',1)) {
			//We load the head data of the document in an array
			$tabHead = $doc->getHeadData();

			//For each stylesheets loaded, we check the key (the path & name of the css file)
			foreach($tabHead['styleSheets'] as $key => $styleSheet){
				if( strpos($key, '/k2.css')) {
				//The entry of the css file is deleted
				unset($tabHead['styleSheets'][$key]);
				break;
				}
	    	}
	    
			//The new head data is loaded in the document
			$doc->setHeadData($tabHead);
	  	}
	}
	
} // END CLASS
