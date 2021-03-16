<?php
/**
 * @version		1.1.0 imgen $
 * @package		imgen
 * @copyright	Copyright © 2011 - All rights reserved.
 * @license		GNU/GPL
 * @author		Fiona Coulter
 * @author mail	joomla - at - iswebdesign.co.uk
 * @website		http://www.spiralscripts.co.uk
 *
 *

 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//jimport( 'joomla.application.component.model' );
jimport('joomla.application.component.modelitem');
require_once(JPATH_SITE.'/components/com_imgen/helpers/imgen.php');

class ImgenModelImgen extends JModelItem
{
	function __construct(){
		parent::__construct();
	}
	
	function getImg(){
		
		
		$image = imgenHelper::getImagePath();
		return $image;
	}
	
	function getQuality()
	{
	    $jinput = JFactory::getApplication()->input;		
		$quality=(int)$jinput->get('quality',imgenHelper::getParamValue('quality',100),'int');
		{
		   if($quality < 0){$quality = 0;}
		   else if($quality > 100){ $quality = 100; }
		}
		return $quality;
	}



}
?>