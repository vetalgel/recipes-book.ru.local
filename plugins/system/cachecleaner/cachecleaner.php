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
use Joomla\CMS\Language\Text as JText;
use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Library\Extension as RL_Extension;
use RegularLabs\Library\Language as RL_Language;
use RegularLabs\Library\Plugin as RL_Plugin;
use RegularLabs\Plugin\System\CacheCleaner\Cache;

// Do not instantiate plugin on install pages
// to prevent installation/update breaking because of potential breaking changes
$input = JFactory::getApplication()->input;
if (in_array($input->get('option'), ['com_installer', 'com_regularlabsmanager']) && $input->get('action') != '')
{
	return;
}

if ( ! is_file(__DIR__ . '/vendor/autoload.php'))
{
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php'))
{
	JFactory::getLanguage()->load('plg_system_cachecleaner', __DIR__);
	JFactory::getApplication()->enqueueMessage(
		JText::sprintf('CC_EXTENSION_CAN_NOT_FUNCTION', JText::_('CACHECLEANER'))
		. ' ' . JText::_('CC_REGULAR_LABS_LIBRARY_NOT_INSTALLED'),
		'error'
	);

	return;
}

require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';

if (! RL_Document::isJoomlaVersion(3, 'CACHECLEANER'))
{
	RL_Extension::disable('cachecleaner', 'plugin');

	RL_Language::load('plg_system_regularlabs');

	JFactory::getApplication()->enqueueMessage(
		JText::sprintf('RL_PLUGIN_HAS_BEEN_DISABLED', JText::_('CACHECLEANER')),
		'error'
	);

	return;
}

if (true)
{
	class PlgSystemCacheCleaner extends RL_Plugin
	{
		public $_lang_prefix     = 'CC';
		public $_page_types      = ['html', 'ajax', 'json', 'raw'];
		public $_enable_in_admin = true;
		public $_jversion        = 3;

		public function handleOnAfterRoute()
		{
			Cache::clean();
		}

		protected function changeFinalHtmlOutput(&$html)
		{
			return true;
		}

		protected function cleanFinalHtmlOutput(&$html)
		{
			$html = str_replace(['{nocdn}', '{/nocdn}'], '', $html);
		}
	}
}
