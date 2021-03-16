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

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="joomla <?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading') != 0) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>
    <div class="blog">
        <?php $leadingcount = 0; ?>
        <?php if (!empty($this->lead_items)) : ?>
            <div class="leadingarticles">
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
            <?php foreach ($this->intro_items as $key => &$item) : ?>

                <?php
                $key = ($key - $leadingcount) + 1;
                $rowcount = ( ((int) $key - 1) % (int) $this->columns) + 1;
                $row = $counter / $this->columns;

                if ($rowcount == 1) :
                    ?>

                    <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?>">
                    <?php endif; ?>
                    <div class="item column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished"' : null; ?>">
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
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
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

