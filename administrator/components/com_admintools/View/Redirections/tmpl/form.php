<?php
/**
 * @package   admintools
 * @copyright Copyright (c)2010-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Akeeba\AdminTools\Admin\Helper\Select;
use Akeeba\AdminTools\Admin\View\Redirections\Html;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var $this Html */

defined('_JEXEC') or die;

$baseUri = Uri::base();

if (substr($baseUri, -14) == 'administrator/')
{
	$baseUri = substr($baseUri, 0, -14);
}

?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="akeeba-form--horizontal">
	<div class="akeeba-container--66-33">
		<div>
			<div class="akeeba-form-group">
				<label for="dest">
					<?php echo Text::_('COM_ADMINTOOLS_LBL_REDIRECTION_DEST'); ?>
				</label>
				<div class="akeeba-input-group">
					<span><?= $baseUri ?></span>
					<input type="text" name="dest" id="dest" value="<?php echo $this->escape($this->item->dest); ?>" />
				</div>
				<p class="akeeba-help-text">
					<?php echo Text::_('COM_ADMINTOOLS_REDIRECTIONS_FIELD_DEST_DESC') ?>
				</p>
			</div>

			<div class="akeeba-form-group">
				<label for="source">
					<?php echo Text::_('COM_ADMINTOOLS_LBL_REDIRECTION_SOURCE'); ?>
				</label>
				<input type="text" name="source" id="source"
					   value="<?php echo $this->escape($this->item->source); ?>" />
				<p class="akeeba-help-text">
					<?php echo Text::_('COM_ADMINTOOLS_REDIRECTIONS_FIELD_SOURCE_DESC') ?>
				</p>
			</div>

			<div class="akeeba-form-group">
				<label for="keepurlparams">
					<?php echo Text::_('COM_ADMINTOOLS_REDIRECTIONS_FIELD_KEEPURLPARAMS'); ?>
				</label>

				<?php echo Select::keepUrlParamsList('keepurlparams', null, $this->item->keepurlparams) ?>

				<p class="akeeba-help-text">
					<?php echo Text::_('COM_ADMINTOOLS_REDIRECTIONS_FIELD_KEEPURLPARAMS_DESC') ?>
				</p>
			</div>

			<div class="akeeba-form-group">
				<label for="dest">
					<?php echo Text::_('JPUBLISHED'); ?>
				</label>

				<?php echo HTMLHelper::_('FEFHelper.select.booleanswitch', 'published', $this->item->published) ?>
				<p class="akeeba-help-text">
					<?php echo Text::_('COM_ADMINTOOLS_REDIRECTIONS_FIELD_PUBLISHED_DESC') ?>
				</p>
			</div>
		</div>
	</div>

	<div class="akeeba-hidden-fields-container">
		<input type="hidden" name="option" value="com_admintools" />
		<input type="hidden" name="view" value="Redirection" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" id="id" value="<?php echo (int) $this->item->id; ?>" />
		<input type="hidden" name="<?php echo $this->container->platform->getToken(true); ?>" value="1" />
	</div>
</form>
