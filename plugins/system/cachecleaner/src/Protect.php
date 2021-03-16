<?php
/**
 * @package         Cache Cleaner
 * @version         6.2.1
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Plugin\System\CacheCleaner;

defined('_JEXEC') or die;

use RegularLabs\Library\Protect as RL_Protect;

class Protect
{
	static $name = 'CacheCleaner';

	public static function _(&$string)
	{
		RL_Protect::protectFields($string);
		RL_Protect::protectSourcerer($string);
		RL_Protect::protectByRegex($string, '\{nocdn\}.*?\{/nocdn\}');
	}
}
