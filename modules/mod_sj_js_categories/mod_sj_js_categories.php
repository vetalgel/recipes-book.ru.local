<?php
/**
 * @package SJ JS Categories for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/core/helper.php';
$layout = $params->get('layout', 'default');
$cacheid = md5(serialize(array($layout, $module->module)));
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'SJJSCategoriesHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;
$list = JModuleHelper::moduleCache($module, $params, $cacheparams);
require JModuleHelper::getLayoutPath($module->module, $layout);
