<?php
/**
 * Software update notification
 *
 * @copyright Copyright Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

/**
 * @var string $softwareName      The name of the software being updated, e.g. "Foo Bar"
 * @var string $compatibilitySlug The fragment in the Compatibility page URL for this software e.g.
 *      "#foobar-compatibility"
 * @var string $currentVersion    Currently installed version of the software e.g. '1.2.3'
 * @var string $currentDate       Release date of the currently installed version
 * @var array  $updateInfo        Joomla update information for this software
 */

use Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

try
{
	$myDate = Date::getInstance($currentDate)->format(Text::_('DATE_FORMAT_LC3'));
}
catch (Exception $e)
{
	$myDate = $currentDate;
}

?>
<div class="akeeba-block--info">
	<h3>
		<?= Text::sprintf('AKEEBA_COMMON_UPDATE_UPDATEFOUND', $softwareName, $updateInfo['version']) ?>
	</h3>
	<p>
		<a href="<?= Uri::base(true) ?>index.php?option=com_installer&view=Update" class="akeeba-btn--primary">
			<?= Text::sprintf('AKEEBA_COMMON_UPDATE_UPDATENOW', $softwareName, $updateInfo['version']) ?>
		</a>
		<a href="<?= $updateInfo['infoURL'] ?>" target="_blank" rel="noopener" class="akeeba-btn--ghost">
			<?= Text::_('AKEEBA_COMMON_UPDATE_MOREINFO') ?>
		</a>
	</p>
	<?php if (!in_array(substr($currentVersion, 0, 3), ['rev', 'dev', 'svn'])): ?>
		<p class="akeeba-block--warning">
			<span class="large"><?= Text::sprintf('AKEEBA_COMMON_UPDATE_DEVREL_HEADER', $currentVersion) ?></span>
			<br />
			<?= Text::sprintf('AKEEBA_COMMON_UPDATE_DEVREL_INFO', $updateInfo['version'], $myDate) ?>
		</p>
	<?php else: ?>
		<p class="small">
			<?= Text::sprintf('AKEEBA_COMMON_UPDATE_DISCLAIMER', 'https://www.akeeba.com/compatibility.html' . $compatibilitySlug, $softwareName, JVERSION, PHP_VERSION) ?>
		</p>
	<?php endif ?>
</div>
