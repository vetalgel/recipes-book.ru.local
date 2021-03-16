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
defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
?>
<div style=" display:table; width:100%; "  class="joomla <?php echo $this->pageclass_sfx ?>">
    <div class="contact">
        <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <h2 style="width:100%; clear:both;" class="contentheading">
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h2>
        <?php endif; ?>
        <?php if ($this->contact->name && $this->params->get('show_name')) : ?>
            <h2 style="width:100%; clear:both;" class="contentheading">
                <span class="contact-name"><?php echo $this->contact->name; ?></span>
            </h2>
        <?php endif; ?>

        <?php if ($this->contact->image && $this->params->get('show_image')) : ?>
            <div style="float:left; margin-bottom:10px;" class="image">
                <?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle')); ?>
            </div>
        <?php endif; ?>

        <div style="float:right;width:50%">
            <?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
                <h3><?php echo $this->contact->con_position; ?></h3>
            <?php endif; ?>

            <?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
                <h3>
                    <span class="contact-category"><?php echo $this->contact->category_title; ?></span>
                </h3>
            <?php endif; ?>
            <?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
                <?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid); ?>
                <h3>
                    <span class="contact-category"><a href="<?php echo $contactLink; ?>">
                            <?php echo $this->escape($this->contact->category_title); ?></a>
                    </span>
                </h3>
            <?php endif; ?>
            <?php if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
                <form action="#" method="get" name="selectForm" id="selectForm">
                    <?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
                    <?php echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link); ?>
                </form>
            <?php endif; ?>
            <?php if ($this->params->get('presentation_style') != 'plain') { ?>
                <?php echo JHtml::_($this->params->get('presentation_style') . '.start', 'contact-slider'); ?>
                <?php echo JHtml::_($this->params->get('presentation_style') . '.panel', JText::_('COM_CONTACT_DETAILS'), 'basic-details');
            } ?>

            <?php echo $this->loadTemplate('address'); ?>

            <?php if ($this->params->get('allow_vcard')) : ?>
                <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
                <?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS'); ?>
                <a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf'); ?>">
                    <?php echo JText::_('COM_CONTACT_VCARD'); ?></a>
                </div>
            <?php endif; ?>
            <p></p>
            <?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>

                <?php if ($this->params->get('presentation_style') != 'plain'): ?>
                    <?php echo JHtml::_($this->params->get('presentation_style') . '.panel', JText::_('COM_CONTACT_EMAIL_FORM'), 'display-form'); ?>
                <?php endif; ?>
                <?php if ($this->params->get('presentation_style') == 'plain'): ?>
                    <?php echo '<h3>' . JText::_('COM_CONTACT_EMAIL_FORM') . '</h3>'; ?>
                <?php endif; ?>
                <?php echo $this->loadTemplate('form'); ?>
            <?php endif; ?>
            <?php if ($this->params->get('show_links')) : ?>
                <?php echo $this->loadTemplate('links'); ?>
            <?php endif; ?>
            <?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
                <?php if ($this->params->get('presentation_style') != 'plain'): ?>
                    <?php echo JHtml::_($this->params->get('presentation_style') . '.panel', JText::_('JGLOBAL_ARTICLES'), 'display-articles'); ?>
                <?php endif; ?>
                <?php if ($this->params->get('presentation_style') == 'plain'): ?>
                    <?php echo '<h3>' . JText::_('JGLOBAL_ARTICLES') . '</h3>'; ?>
                <?php endif; ?>
                <?php echo $this->loadTemplate('articles'); ?>
            <?php endif; ?>
            <?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
                <?php if ($this->params->get('presentation_style') != 'plain'): ?>
                    <?php echo JHtml::_($this->params->get('presentation_style') . '.panel', JText::_('COM_CONTACT_PROFILE'), 'display-profile'); ?>
                <?php endif; ?>
                <?php if ($this->params->get('presentation_style') == 'plain'): ?>
                    <?php echo '<h3>' . JText::_('COM_CONTACT_PROFILE') . '</h3>'; ?>
                <?php endif; ?>
                <?php echo $this->loadTemplate('profile'); ?>
            <?php endif; ?>
            
            <?php if ($this->params->get('presentation_style') != 'plain') { ?>
                <?php echo JHtml::_($this->params->get('presentation_style') . '.end');
            } ?>
        </div>
    </div>
</div>
