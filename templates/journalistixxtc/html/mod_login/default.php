<?php
/*
  JoomlaXTC XTC Template Overrides

  Copyright (C) 2011  Monev Software LLC.	All Rights Reserved.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  THIS LICENSE MIGHT NOT APPLY TO OTHER FILES CONTAINED IN THE SAME PACKAGE.

  Monev Software LLC
  www.joomlaxtc.com
 */
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<?php if ($type == 'logout') : ?>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
        <?php if ($params->get('greeting')) : ?>
            <div class="login-greeting">
                <?php
                if ($params->get('name') == 0) : {
                        echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
                    } else : {
                        echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('username'));
                    } endif;
                ?>
            </div>
        <?php endif; ?>
        <div class="center">
            <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.logout" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
<?php else : ?>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
        <?php if ($params->get('pretext')): ?>
            <div class="pretext">
                <p><?php echo $params->get('pretext'); ?></p>
            </div>
        <?php endif; ?>
        <fieldset class="userdata">
            <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
            <div class="input_dark">     
                <div class="input_wrap" style="margin:4px 0 14px 0; height:20px; ">
                    <input id="modlgn-username" type="text" name="username" class="inputbox" size="25" style="padding:2px 0 3px 5px; background:#777777; border:none; color:#bbbbbb; -moz-border-radius: 4px; -webkit-border-radius: 4px; height:20px;width:85%;" />
                </div>
                <div class="input_dark_right"></div>
            </div>
            <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
            <div class="input_dark">     
                <div class="input_wrap" style="margin:4px 0 7px 0; height:20px; ">
                    <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="25" style="padding:2px 0 3px 5px; background:#777777; border:none; color:#bbbbbb; -moz-border-radius: 4px; -webkit-border-radius: 4px; height:20px;width:85%;"  />
                </div>
                <div class="input_dark_right"></div>
            </div>

            <br />
            <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" style="background:#777777; border:none; color:#bbbbbb;" />
            <br /><br />
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                <p id="form-login-remember">
                    <label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
                    <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" style="margin-left:6px;"/>
                </p>
            <?php endif; ?>

            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </fieldset>
        <?php
        $usersConfig = JComponentHelper::getParams('com_users');
        if ($usersConfig->get('allowUserRegistration')) :
            ?>
            <a style="font-size: 10px; color: #666666;" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
                <?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
        <?php endif; ?>
        <br />
        <a style="font-size: 10px; color: #666666;" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
        <br />
        <a style="font-size: 10px; color: #666666;" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
        <?php if ($params->get('posttext')): ?>
            <div class="posttext">
                <p><?php echo $params->get('posttext'); ?></p>
            </div>
        <?php endif; ?>
    </form>
<?php endif; ?>
