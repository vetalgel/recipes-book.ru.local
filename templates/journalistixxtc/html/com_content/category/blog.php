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
    <div class="blog">
        <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <h1>
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
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
            <div class="category-desc">
                <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                    <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
                <?php endif; ?>
                <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                    <?php echo JHtml::_('content.prepare', $this->category->description); ?>
                <?php endif; ?>
                <div class="clr"></div>
            </div>
        <?php endif; ?>



        <?php $leadingcount = 0; ?>
        <?php if (!empty($this->lead_items)) : ?>
            <div class="items-leading">
                <?php foreach ($this->lead_items as &$item) : ?>
                    <div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate('item');
                        ?>
                    </div>
                    <?php
                    $leadingcount++;
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        $introcount = (count($this->intro_items));
        $counter = 0;
        ?>
        <?php if (!empty($this->intro_items)) : ?>
            <div class="teaserarticles <?php if ((int) $this->columns != 1)
            echo "multicolumns"; ?>">

                <?php foreach ($this->intro_items as $key => &$item) : ?>
                    <?php
                    $key = ($key - $leadingcount) + 1;
                    $rowcount = ( ((int) $key - 1) % (int) $this->columns) + 1;
                    $row = $counter / $this->columns;

                    $firstlast = "";
                    if ($rowcount == 1)
                            $firstlast = "first";
                    if ($rowcount == $this->columns)
                            $firstlast = "last";
                        
                    if ($rowcount == 1) :
                        ?>
                        <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?>">
                        <?php endif; ?>
                        <div class="item column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> <?php echo $firstlast; ?> float-left width<?php echo intval(100 / (int) $this->columns); ?>">
                            <?php
                            $this->item = &$item;
                            echo $this->loadTemplate('item');
                            ?>
                        </div>
                        <?php $counter++; ?>
                        <?php if (($rowcount == $this->columns) or ($counter == $introcount)): ?>
                            <span class="row-separator"></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>


        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>

            <?php echo $this->loadTemplate('links'); ?>

        <?php endif; ?>


        <?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
            <div class="cat-children">
                <h3>
                    <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
                </h3>
                <?php echo $this->loadTemplate('children'); ?>
            </div>
        <?php endif; ?>

        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
            <div class="pagination">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="counter">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>

                <?php endif; ?>
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
