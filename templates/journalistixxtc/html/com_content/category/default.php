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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
?>
<div class="joomla <?php echo $this->pageclass_sfx; ?>">
    <div class="categorylist">

        <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <h2>
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h2>
        <?php endif; ?>

        <?php if ($this->params->get('show_category_title', 1) OR $this->params->get('page_subheading')) : ?>
            <h2>
                <?php echo $this->escape($this->params->get('page_subheading')); ?>
                <?php if ($this->params->get('show_category_title')) : ?>
                    <span class="subheading-category"><?php echo $this->category->title; ?></span>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
            <div class="description">
                <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                    <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
                <?php endif; ?>
                <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                    <?php echo JHtml::_('content.prepare', $this->category->description); ?>
                <?php endif; ?>
                <div class="clr"></div>
            </div>
        <?php endif; ?>

        <div class="cat-items">
            <?php echo $this->loadTemplate('articles'); ?>
        </div>

        <?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
            <div class="cat-children">
                <h3>
                    <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
                </h3>

                <?php echo $this->loadTemplate('children'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
