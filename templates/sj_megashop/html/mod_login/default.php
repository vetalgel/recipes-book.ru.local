<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');

?>
<?php if ($type == 'logout') : ?>
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="logout-form">
	<?php if ($params->get('greeting')) : ?>
		<div class="login-greeting">
		<?php if($params->get('name') == 0) : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
		} else : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
		} endif; ?>
		</div>
	<?php endif; ?>
		<div class="logout-button">
			<input type="submit" name="Submit" class="btn" value="<?php echo JText::_('JLOGOUT'); ?>" />
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.logout" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
<?php else : ?>

	<ul class="yt-loginform hidden-xs">
        <li class="yt-login">
            <a class="login-switch" data-toggle="modal" href="#myLogin" title="<?php JText::_('Login');?>">
	    <i class="fa fa-lock"></i>
               <?php echo JText::_('JLOGIN'); ?>
            </a>
            <div id="myLogin" class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">

				<h3 class="title"><?php echo JText::_('MOD_LOGIN_EX'); ?></h3>
				<div class="modal-body">
				<div class="row">
					<div class="col-md-6 lineb">
						<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form-inline">
				    <?php if ($params->get('pretext')): ?>
					<div class="pretext">
					<p><?php echo $params->get('pretext'); ?></p>
					</div>
				    <?php endif; ?>
				    <div class="userdata">
					<div id="form-login-username" class="control-group control-groupex">
					    <label for="modlgn-username"><i class="fa fa-user"></i></label>
									<input id="modlgn-username" type="text" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" name="username" class="inputbox"  size="18" />
					</div>
					<div id="form-login-password" class="control-group control-groupex">
					    <label for="modlgn-passwd"><i class="fa fa-key"></i></label>
									<input id="modlgn-passwd" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" type="password" name="password" class="inputbox" size="18"  />
					</div>

					<div id="form-login-remember" class="control-group ">
						<a class="forgotpw" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
						<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
					</div>

					<div id="form-login-submit" class="control-group">
					    <div class="controls">
						<button type="submit" tabindex="3" name="Submit" class="button"><i class="fa fa-lock"></i><?php echo JText::_('JLOGIN') ?></button>
										<a  class="button fb" href="#"><i class="icon-facebook"></i>Log in with Facebook</a>
					    </div>
					</div>

					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				    </div>
				    <?php if ($params->get('posttext')): ?>
					<div class="posttext">
					    <p><?php echo $params->get('posttext'); ?></p>
					</div>
				    <?php endif; ?>
				</form>
					</div>
					<div class="col-md-6">
					<h3 class="titlen"><?php echo JText::_('JREGISTER_NEW');?></h3>
					<small class="stitlen"><?php echo JText::_('JREGISTER_DES');?></small>
					<ul class="listdes">
						<li><?php echo JText::_('JREGISTER_DES1');?></li>
						<li><?php echo JText::_('JREGISTER_DES2');?></li>
						<li><?php echo JText::_('JREGISTER_DES3');?></li>
					</ul>
					<div  class="control-group">
					    <div class="controls">
				<a class="button btreg" href="<?php echo JRoute::_("index.php?option=com_users&view=registration");?>" onclick="showBox('yt_register_box','jform_name',this, window.event || event);return false;">
				<?php echo JText::_('JREGISTER_BT');?></a>
					    </div>
					</div>
					</div>
				</div>
				</div>


            </div>
        </li>
        <li class="yt-register" style="display: none;">
			<?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>

				<a
						class="register-switch text-font"
						href="<?php echo JRoute::_("index.php?option=com_users&view=registration");?>"
						onclick="showBox('yt_register_box','jform_name',this, window.event || event);return false;"
						>
					<span class="title-link"><span><?php echo JText::_('JREGISTER');?></span></span>
				</a>
			<?php endif; ?>

			<div id="yt_register_box" class="show-box" style="display:none">
				<div class="inner">
					<h3><?php echo JText::_('JREGISTER');?></h3>


				</div>
			</div>

        </li >

    </ul>

<?php endif; ?>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($){


	$('body').on('click','.modal-backdrop',function(){

		$('#myLogin').css('display','none');
		$('.modal-backdrop').css('display','none');
	});

	$('.yt-login a').unbind('click').click(function(){
		$('#myLogin').css('display','block');
		$('.modal-backdrop').css('display','block');

	});
});
//]]>
</script>
