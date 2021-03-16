<?php
/**
 * @package         Cache Cleaner
 * @version         7.3.3
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2020 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
use Joomla\CMS\Language\Text as JText;
use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Library\Extension as RL_Extension;
use RegularLabs\Library\Language as RL_Language;

/**
 * Module that cleans cache
 */

// return if Regular Labs Library plugin is not installed
jimport('joomla.filesystem.file');
if (
	! is_file(JPATH_PLUGINS . '/system/regularlabs/regularlabs.xml')
	|| ! is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php')
)
{
	return;
}

// return if Regular Labs Library plugin is not enabled
if ( ! JPluginHelper::isEnabled('system', 'regularlabs'))
{
	return;
}

require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';

if ( ! RL_Document::isJoomlaVersion(3, 'CACHECLEANER'))
{
	RL_Extension::disable('cachecleaner', 'module');

	RL_Language::load('plg_system_regularlabs');

	JFactory::getApplication()->enqueueMessage(
		JText::sprintf('RL_ADMIN_MODULE_HAS_BEEN_DISABLED', JText::_('CACHECLEANER')),
		'error'
	);

	return;
}

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$helper = new ModCacheCleaner;
$helper->render();
