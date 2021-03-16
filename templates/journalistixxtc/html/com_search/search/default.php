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
?>

<div class="joomla <?php echo $this->pageclass_sfx; ?>">
    <div class="search">
        <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <h2 style="width:100%; clear:both;" class="contentheading">
                <?php if ($this->escape($this->params->get('page_heading'))) : ?>
                    <?php echo $this->escape($this->params->get('page_heading')); ?>
                <?php else : ?>
                    <?php echo $this->escape($this->params->get('page_title')); ?>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php echo $this->loadTemplate('form'); ?>
        <?php
        if ($this->error == null && count($this->results) > 0) :
            echo $this->loadTemplate('results');
        else :
            echo $this->loadTemplate('error');
        endif;
        ?>
    </div>
</div>
