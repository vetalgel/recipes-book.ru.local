<?php

/**
 * JCH Optimize - Joomla! plugin to aggregate and minify external resources for
 * optmized downloads
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die;

use JchOptimize\Core\Admin;

if (!function_exists('jchoptimize_class_autoload'))
{
	include_once dirname(dirname(__FILE__)) . '/jchoptimize/loader.php';
}

abstract class JFormFieldAuto extends JFormField {

	protected $bResources = FALSE;

	public function setup(SimpleXMLElement $element, $value, $group = NULL) {
		return parent::setup($element, $value, $group);
	}

	/**
	 * 
	 * @return string
	 */
	protected function getInput() {
		//JCH_DEBUG ? Profiler::mark('beforeGetInput - ' . $this->type) : null;

		$aButtons = $this->getButtons();
		$sField = Admin::generateIcons($aButtons);

		// JCH_DEBUG ? Profiler::mark('beforeGetInput - ' . $this->type) : null;

		return $sField;
	}

	/**
	 * 
	 * @param type $oController
	 */
	protected static function display($oController) {
		$oUri = clone JUri::getInstance();
		$oUri->delVar('jchtask');
		$oUri->delVar('jchdir');
		$oUri->delVar('status');
		$oUri->delVar('msg');
		$oUri->delVar('dir');
		$oUri->delVar('cnt');
		$oController->setRedirect($oUri->toString());
		$oController->redirect();
	}

	abstract protected function getButtons();
}
